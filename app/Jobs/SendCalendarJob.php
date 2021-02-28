<?php

namespace App\Jobs;

use App\Events\Message;
use App\TokenStore\TokenCache;
use Beta\Microsoft\Graph\Model\Calendar;
use Beta\Microsoft\Graph\Model\Event;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Microsoft\Graph\Beta\Model;
use Microsoft\Graph\Graph;

class SendCalendarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tasks;
    private $provider;
    private $directory;
    private $channel_name;

    /**
     * Create a new job instance.
     *
     * @param $feature_config
     * @param $channel_name
     */
    public function __construct($feature_config, $channel_name)
    {
        $this->provider = $feature_config->data['provider'];
        $this->channel_name = $channel_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            switch ($this->provider) {
                case 'microsoft':
                    $this->tasks = $this->getMicrosoftCalendar();
                    break;
                default:
                    break;
            }
            broadcast(new Message('calendar', $this->tasks, $this->channel_name));
        } catch (Exception $e) {
            broadcast(new Message('calendar', [
                "status" => 'failed',
                "message" => $e->getMessage()
            ], $this->channel_name));
        }
    }

    protected function getMicrosoftCalendar()
    {
        $graph = $this->initMicrosoftConnection();
        $calendars = $graph->createRequest('GET', '/me/calendars')
            ->setReturnType(Calendar::class)
            ->execute();
        $all_events = [];
        $now = Carbon::parse(Carbon::now()->format('Y-m-d'))->format('Y-m-d\TH:i:s.000001');
        $two_weeks = Carbon::parse(Carbon::now()->format('Y-m-d'))->addDays(14)->format('Y-m-d\TH:i:s.000001');
        foreach ($calendars as $calendar) {
            $getEventsUrl = "/me/calendars/{$calendar->getId()}/calendarView?startDateTime={$now}&endDateTime={$two_weeks}";
            $events = $graph->createRequest('GET', $getEventsUrl)
                ->setReturnType(Event::class)
                ->execute();
            if(!is_array($events)) continue;
            $all_events = array_merge($all_events, $events);
        }
        $formattedEvents = [];
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
            $formattedEvents[] = $this_event;
        }
        $formattedEvents = collect($formattedEvents)->sortBy('full_start_date')->values();
        if ($formattedEvents->count() > 3) {
            $endDate = $formattedEvents->get(3)['start'];
            $formattedEvents = $formattedEvents->where('start', '<=', $endDate);
        }
        return $formattedEvents;
    }

    private function initMicrosoftConnection(): Graph
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();
        $graph = new Graph();
        $graph->setApiVersion('beta');
        $graph->setAccessToken($accessToken);

        return $graph;
    }
}
