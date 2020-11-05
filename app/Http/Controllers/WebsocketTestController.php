<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Feature;
use App\TokenStore\TokenCache;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Microsoft\Graph\Beta\Model;
use Microsoft\Graph\Graph;
use Feeds;

class WebsocketTestController extends Controller
{
    public function getData(Feature $feature)
    {
        $feature_config = $feature->getConfig;
        switch ($feature->slug) {
            case "air":
                return $this->SendAirQuality($feature_config);
                break;
            case "calendar":
                return $this->SendCalendar($feature_config);
                break;
            case "news":
                return $this->SendNews($feature_config);
                break;
            case "tasks":
                return $this->SendTasks($feature_config);
                break;
            case "weather":
                return $this->SendWeather($feature_config);
                break;
            case "covid":
                return $this->SendCovid($feature_config);
                break;
            case "time":
                return $this->SendTime($feature_config);
                break;
        }
    }

    public function SendAirQuality($feature)
    {
        $getIndexUrl = "http://api.gios.gov.pl/pjp-api/rest/aqindex/getIndex/" . $feature->data['station'] ?? '';
        $getStationUrl = "http://api.gios.gov.pl/pjp-api/rest/station/sensors/" . $feature->data['station'] ?? '';
        $getSensorUrl = "http://api.gios.gov.pl/pjp-api/rest/data/getData/";
        try {
            $client = new Client();
            $airInfo = [];
            $response = $client->request('GET', $getIndexUrl);
            $data = json_decode($response->getBody()->getContents());
            $airInfo['main'] = [
                'date' => $data->stCalcDate,
                'quality_id' => $data->stIndexLevel->id,
                'quality_message' => $data->stIndexLevel->indexLevelName,
            ];
            $response = $client->request('GET', $getStationUrl);
            foreach (json_decode($response->getBody()->getContents()) as $station) {
                $sensor = $client->request('GET', $getSensorUrl . $station->id);
                $airInfo['details'][] = [
                    'name' => ucfirst($station->param->paramName),
                    'code' => $station->param->paramCode,
                    'value' => json_decode($sensor->getBody()->getContents())->values[0] ?? false
                ];
            }
            broadcast(new Message('air', $airInfo));
            dump(['type'=>'air', 'data'=>$airInfo]);
//            return response()->json($airInfo);
        } catch (Exception $e) {
            broadcast(new Message('air', [
                "status" => 'failed',
                "message" => $e->getMessage()
            ]));
            dump(['type'=>'air', 'data'=>[
                "status" => 'failed',
                "message" => $e->getMessage()
            ]]);
//            return response()->json([
//                "status" => 'failed',
//                "message" => $e->getMessage()
//            ]);
        }
    }

    public function SendCalendar($feature)
    {
        $calendar = [];
        $provider = $feature->data['provider'];
        try {
            switch ($provider) {
                case 'microsoft':
                    $calendar = $this->getMicrosoftCalendar();
                    break;
                default:
                    break;
            }
            broadcast(new Message('calendar', $calendar));
            dump(['type'=>'calendar', 'data'=>$calendar]);
//            return response()->json($calendar);
        } catch (\Exception $e) {
            broadcast(new Message('calendar', [
                "status" => 'failed',
                "message" => $e->getMessage()
            ]));
            dump(['type'=>'calendar', 'data'=>[
                "status" => 'failed',
                "message" => $e->getMessage()
            ]]);
//            return response()->json([
//                "status" => 'failed',
//                "message" => $e->getMessage()
//            ]);
        }
    }

    public function SendNews($feature)
    {
        $feed = Feeds::make($feature->data['rss'], 5, true); // if RSS Feed has invalid mime types, force to read
        $data = array(
            'title' => $feed->get_title(),
            'permalink' => $feed->get_permalink(),
            'items' => $feed->get_items(),
        );
        foreach ($data['items'] as $key => $item) {
            $title = preg_replace('/\s+/S', " ", $item->get_title());
            $description = ltrim(preg_replace('/\s+/S', " ", strip_tags($item->get_description())));
            $content = preg_replace('/\s+/S', " ", $item->get_content());
            $data['prepared_items'][] =
                [
                    "date" => $item->get_date('Y-m-d H:i:s'),
                    "id" => $item->get_id(),
                    "title" => $title,
                    "description" => $description,
                    "content" => $content,
                ];
            if ($key > 5) {
                break;
            }
        }
        $data['items'] = $data['prepared_items'];
        unset($data['prepared_items']);
        broadcast(new Message('news', $data));
        dump(['type'=>'news', 'data'=>$data]);
//        return response()->json($data);
    }

    public function SendTasks($feature)
    {
        $provider = $feature->data['provider'];
        $tasks = [];
        try {
            switch ($provider) {
                case 'microsoft':
                    $tasks = $this->getMicrosoftTasks($feature);
                    break;
                default:
                    break;
            }
            broadcast(new Message('tasks', $tasks));
            dump(['type'=>'tasks', 'data'=>$tasks]);
//            return response()->json($tasks);
        } catch (\Exception $e) {
            broadcast(new Message('tasks', [
                "status" => 'failed',
                "message" => $e->getMessage()
            ]));
            dump(['type'=>'tasks', 'data'=>[
                "status" => 'failed',
                "message" => $e->getMessage()
            ]]);
//            return response()->json([
//                "status" => 'failed',
//                "message" => $e->getMessage()
//            ]);
        }
    }

    public function SendWeather($feature)
    {
        $client = new Client();
        $city = $feature->data['city'];
        $key = env('WEATHER_KEY');
        $response = $client->request('GET',
            'http://api.openweathermap.org/data/2.5/weather?units=metric&lang=pl&id=' . $city . '&appid=' . $key);
        $data = json_decode($response->getBody()->getContents());
        $weatherInfo = [
            'city' => $data->name,
            'temperature' => $data->main->temp,
            'pressure' => $data->main->pressure,
            'humidity' => $data->main->humidity,
            'wind_speed' => $data->wind->speed,
            'wind_deg' => $data->wind->deg ?? false,
            'wind_gust' => $data->wind->gust ?? false,
            'clouds' => $data->clouds->all,
            'sunrise' => $data->sys->sunrise,
            'sunset' => $data->sys->sunset,
            'description' => $data->weather[0]->description,
            'icon' => $data->weather[0]->icon,
            'time' => Carbon::parse($data->dt)->format('Y-m-d H:i:s'),
        ];
        broadcast(new Message('current_weather', $weatherInfo));
        dump(['type'=>'current_weather', 'data'=>$weatherInfo]);
//        return response()->json($weatherInfo);
    }

    public function SendCovid($feature)
    {
        $client = new Client();
        $response = $client->request('GET',
            'https://api.covid19api.com/summary');
        $data = json_decode($response->getBody()->getContents());
        $collection = collect($data->Countries);

        $total_confirmed = 0;
        $total_deaths = 0;
        $total_recovered = 0;
        foreach($collection as $country) {
            $total_confirmed += (int)$country->TotalConfirmed;
            $total_deaths += (int)$country->TotalDeaths;
            $total_recovered += (int)$country->TotalRecovered;
        }
        $poland = $collection->where('Country', 'Poland')->first();

        $covidInfo = [];
        if($feature->data['type'] == 1 || $feature->data['type'] == 3) {
            $covidInfo['global'] = [
                'confirmed' => $total_confirmed,
                'deaths' => $total_deaths,
                'recovered' => $total_recovered,
            ];
        }
        if($feature->data['type'] == 2 || $feature->data['type'] == 3) {
            $covidInfo['poland'] = [
                'confirmed' => $poland->TotalConfirmed,
                'deaths' => $poland->TotalDeaths,
                'recovered' => $poland->TotalRecovered,
            ];
        }
        broadcast(new Message('covid', $covidInfo));
        dump(['type'=>'covid', 'data'=>$covidInfo]);
//        return response()->json($covidInfo);
    }

    public function SendTime($feature)
    {
        $timeInfo = [
            'timestamp' => Carbon::now()->setTimezone($feature->data['timezone'])->timestamp,
            'timezone' => $feature->data['timezone'],
            'time_format' => $feature->data['time-format']
        ];
        broadcast(new Message('time', $timeInfo, 'mirror.1231'));
        dump(['type'=>'time', 'data'=>$timeInfo]);
//        return response()->json($timeInfo);
    }



    protected function getMicrosoftTasks($feature)
    {
        $directory = $feature->data['directory'];
        $graph = $this->initMicrosoftConnection();
        $queryParams = array(
            '$orderby' => 'importance DESC, createdDateTime DESC',
            '$top' => 20,
            '$filter' => "status ne 'completed'"
        );
        $getEventsUrl = '/me/outlook/taskFolders/' . $directory . '/tasks?' . http_build_query($queryParams);

        $tasks = $graph->createRequest('GET', $getEventsUrl)
            ->setReturnType(Model\OutlookTask::class)
            ->execute();

        $formattedTasks = [];
        foreach ($tasks as $task) {
            $this_task = [
                'owner' => $task->getOwner(),
                'title' => $task->getSubject(),
                'description' => $task->getBody()->getContent(),
                'priority' => $task->getImportance()->value(),
                'deadline_at' => is_array($deadline_at = $task->getDueDateTime()->getProperties()) ?
                    Carbon::parse($deadline_at['dateTime'])->format('Y-m-d H:i') : null,
                'created_at' => Carbon::parse($task->getCreatedDateTime())->format('Y-m-d H:i'),
                'updated_at' => Carbon::parse($task->getLastModifiedDateTime())->format('Y-m-d H:i'),
            ];
            $formattedTasks[] = $this_task;
        }
        return $formattedTasks;
    }

    protected function getMicrosoftCalendar()
    {
        $graph = $this->initMicrosoftConnection();
        $calendars = $graph->createRequest('GET', '/me/calendars')
            ->setReturnType(Model\Calendar::class)
            ->execute();
        $all_events = [];
        $now = Carbon::parse(Carbon::now()->format('Y-m-d'))->format('Y-m-d\TH:i:s.000001');
        $two_weeks = Carbon::parse(Carbon::now()->format('Y-m-d'))->addDays(14)->format('Y-m-d\TH:i:s.000001');
        foreach ($calendars as $calendar) {
            $getEventsUrl = "/me/calendars/{$calendar->getId()}/calendarView?startDateTime={$now}&endDateTime={$two_weeks}";
            $events = $graph->createRequest('GET', $getEventsUrl)
                ->setReturnType(Model\Event::class)
                ->execute();
            if(!is_array($events)) continue;
            $all_events = array_merge($all_events, $events);
        }
        $formatedEvents = [];
        foreach ($all_events as $event) {
            $this_event = [
                'title' => $event->getSubject(),
                'allDay' => $event->getIsAllDay(),
                'full_start_date' => Carbon::parse($event->getStart()->getDateTime())->format('Y-m-d H:i:s'),
                'start' => Carbon::parse(Carbon::now()->format('Y-m-d'))
                    ->diffInDays(Carbon::parse($event->getStart()->getDateTime()), false),
                'hour' => $event->getIsAllDay() ? false : Carbon::parse($event->getStart()->getDateTime())
                    ->format('H:i')
            ];
            $formatedEvents[] = $this_event;
        }
        $formatedEvents = collect($formatedEvents)->sortBy('full_start_date')->values();
        if($formatedEvents->count() > 3){
            $endDate = $formatedEvents->get(3)['start'];
            $formatedEvents = $formatedEvents->where('start', '<=', $endDate);
        }
        return $formatedEvents;
    }

    private function initMicrosoftConnection()
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();
        $graph = new Graph();
        $graph->setApiVersion('beta');
        $graph->setAccessToken($accessToken);
        return $graph;
    }
}
