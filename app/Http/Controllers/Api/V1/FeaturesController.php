<?php

namespace App\Http\Controllers\Api\V1;

use App\Feature;
use App\Jobs\SendConfigJob;
use App\WeatherCity;
use Carbon\CarbonTimeZone;
use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller as BaseController;

class FeaturesController extends BaseController
{
    public function index()
    {
        $features = Feature::with('config')->orderBy('ordering')->get();
        $response = [];
        foreach ($features as $feature) {
            $response[] = [
                "id" => $feature->id,
                "slug" => $feature->slug,
                "name" => $feature->name,
                "active" => $feature->active,
                "ordering" => $feature->ordering,
                "icon" => $feature->icon,
                "base_config" => $feature->base_config,
                "config" => ($config = $feature->config) ? [
                    "active" => $config->active,
                    "data" => $config->data
                ] : null
            ];
        }

        return response()->json([
            'success' => true,
            'message' => null,
            'data' => $response
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show(Feature $feature)
    {
        $feature->load('config');
        switch ($feature->slug) {
            case "time":
                $response = $this->getTimeConfigData();
                break;
            case "weather":
                $response = $this->getWeatherConfigData();
                break;
            case "sensors":
                $response = $this->getSensorsConfigData();
                break;
            case "news":
                $response = $this->getNewsConfigData();
                break;
            case "tasks":
                $response = $this->getTasksConfigData();
                break;
            case "calendar":
                $response = $this->getCalendarConfigData();
                break;
            case "timetable":
                $response = $this->getTimetableConfigData();
                break;
            case "air":
                $response = $this->getAirConfigData();
                break;
            case "covid":
                $response = $this->getCovidConfigData();
                break;
            default:
                $response = [];
        }

        return response()->json([
            'success' => true,
            'message' => null,
            'data' => [
                'item' => $feature,
                'config_data' => $response
            ]
        ], 200);
    }

    public function update(Request $request, Feature $feature)
    {
        $rules = $feature->getConfigRules();
        $request->validate($rules);
        $feature->getConfig()->update(['data' => $request->all()]);
        if ($feature->getConfig->active) {
            foreach (auth()->user()->mirrors as $mirror) {
                dispatch($feature->getJob($feature->getConfig, 'mirror.' . $mirror->serial));
            }
        }
        return response()->json(['status' => 'success', 'message' => "Pomyślnie zapisano konfigurację"]);
    }

    public function setFeatureActive(Feature $feature, $active = 1)
    {
        try {
            $old_active = $feature->getConfig->active;
            $feature->getConfig->update(['active' => (int)$active]);
            foreach (auth()->user()->mirrors as $mirror) {
                dispatch(new SendConfigJob(auth()->user(), 'mirror.' . $mirror->serial));
                if ($active == 1 && $old_active != $active) {
                    dispatch($feature->getJob($feature->getConfig, 'mirror.' . $mirror->serial));
                }
            }
            $active_message = $active ? 'włączony' : 'wyłączony';
            return response()->json([
                'success' => true,
                'message' => 'Widget został ' . $active_message,
                'data' => null
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    private function getTimeConfigData()
    {
        return Cache::remember('API::TimeConfig', 2678400, function () {
            $timezones = collect(CarbonTimeZone::listIdentifiers())->mapToGroups(function ($value, $key) {
                $exploded = explode('/', $value);
                if ($exploded[1] ?? false) {
                    return [
                        $exploded[0] => [
                            'name' => $exploded[1],
                            'offset' => CarbonTimeZone::instance($value)->toOffsetName()
                        ]
                    ];
                }
                return [
                    $value => [
                        'name' => $value,
                        'offset' => CarbonTimeZone::instance($value)->toOffsetName()
                    ]
                ];
            })->toArray();
            $date_formats = [
                'Y-m-d' => 'YYYY-MM-DD',
                'd-m-Y' => 'DD-MM-YYYY',
            ];
            $time_formats = [
                'HH:mm' => 'Format 24 godzinny',
                'hh:mm A' => 'Format 12 godzinny',
            ];

            return [
                'timezones' => $timezones,
                'time_formats' => $time_formats
            ];
        });
    }

    private function getWeatherConfigData()
    {
        return Cache::remember('API::WeatherConfig', 2678400, function () {
            return ['cities' => WeatherCity::select('id', 'ext_id as city_id', 'name', 'country')
                ->orderBy('name')->get()->toArray()
            ];
        });
    }

    private function getNewsConfigData()
    {
        return [
            'default_channels' => [
                'https://www.tvn24.pl/najnowsze.xml' => 'TVN24 - najnowsze',
                'https://www.tvn24.pl/wiadomosci-z-kraju,3.xml' => 'TVN24 - kraj',
                'https://www.tvn24.pl/wiadomosci-ze-swiata,2.xml' => 'TVN24 - świat',
                'https://joemonster.org/backend.php' => 'JoeMonster',
                'https://www.gazetaprawna.pl/rss.xml' => 'GazetaPrawna',
                'https://asta24.pl/feed' => 'Asta24 - powiat pilski',
                'https://www.gry-online.pl/rss/news.xml' => 'GryOnline',
            ]
        ];
    }

    private function getAirConfigData()
    {
        return Cache::remember('API::WeatherConfig', 2678400, function () {
            $client = new Client();
            $response = $client->request('GET', 'http://api.gios.gov.pl/pjp-api/rest/station/findAll');
            $available_stations = collect(json_decode($response->getBody()->getContents()))->sortBy('stationName');
            $available_stations = $available_stations->map(function ($value) {
                return [
                    "id" => $value->id,
                    "stationName" => $value->stationName,
                    "city" => $value->city->name,
                    "street" => $value->addressStreet,
                    "address" => $value->city->name . ' ' . $value->addressStreet
                ];
            });

            return [
                'cities' => $available_stations->toArray(),
                'grouped_cities' => $available_stations->groupBy('city')->toArray()
            ];
        });
    }

    private function getCovidConfigData()
    {
        return [
            'available_types' => [
                1 => 'Statystyki globalne',
                2 => 'Statystyki Polski',
                3 => 'Obie statystyki',
            ]
        ];
    }

    private function getCalendarConfigData()
    {
        return [
            'available_providers' => [
                'microsoft' => 'Microsoft Calendar',
                'google' => 'Google Calendar',
            ]
        ];
    }

    private function getTimetableConfigData()
    {
        return null;
    }

    private function getSensorsConfigData()
    {
        return null;
    }

    private function getTasksConfigData()
    {
        return null;
    }
}
