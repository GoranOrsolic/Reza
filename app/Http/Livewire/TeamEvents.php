<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use Illuminate\Support\Facades\Http;


class TeamEvents extends Component
{
    public $teamId;
    public $page = 1;
    public $updating = false;

    public function mount($teamId)
    {
        $this->teamId = $teamId;
    }

    public function changePage($newPage)
    {
        $this->updating = true;
        $this->page = $newPage;
    }

    public function next()
    {
        $this->page++;
    }

    public function previous()
    {
        $this->page--;
    }

    public function render()
    {
        $nextEventsResponse = $this->sendRequestWithRetry(function () {
            return Http::withHeaders([
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
            ])->get('https://sofasport.p.rapidapi.com/v1/teams/events', [
                'team_id' => $this->teamId,
                'page' => 0,
                'course_events' => 'next',
            ]);
        });

        if (isset($nextEventsResponse->json()['data']['events'])) {
            $nextEventsData = $nextEventsResponse->json()['data']['events'];
        }

        $pastEventsResponse = $this->sendRequestWithRetry(function () {
            return Http::withHeaders([
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
            ])->get('https://sofasport.p.rapidapi.com/v1/teams/events', [
                'team_id' => $this->teamId,
                'page' => $this->page, // Ispravljeno ovde
                'course_events' => 'last',
            ]);
        });
        if (isset($pastEventsResponse->json()['data']['events'])) {
            $pastEventsData = $pastEventsResponse->json()['data']['events'];
        }

        // Sortiranje događaja po startTimestampu
        if (isset($nextEventsData) && is_array($nextEventsData)) {
            usort($nextEventsData, function($a, $b) {
                return $a['startTimestamp'] - $b['startTimestamp'];
            });
        }

        if (isset($pastEventsData) && is_array($pastEventsData)) {
            usort($pastEventsData, function($a, $b) {
                return $a['startTimestamp'] - $b['startTimestamp'];
            });
        }

        // Datum trenutnog vremena
        $currentTime = time();

        // Razdvajanje događaja na prošle i buduće
        $pastEvents = [];
        $futureEvents = [];

        foreach ($pastEventsData as $event) {
            if ($event['startTimestamp'] < $currentTime) {
                $pastEvents[] = $event;
            }
        }

        foreach ($nextEventsData as $event) {
            if ($event['startTimestamp'] >= $currentTime) {
                $futureEvents[] = $event;
            }
        }

        $perPage = 10;
        $allEvents = $this->page <= ceil(count($pastEvents) / $perPage)
            ? array_slice($pastEvents, ($this->page - 1) * $perPage, $perPage)
            : array_slice($futureEvents, ($this->page - ceil(count($pastEvents) / $perPage) - 1) * $perPage, $perPage);

        $allEventsCount = count($pastEvents) + count($futureEvents);
        $allEventsPages = ceil($allEventsCount / $perPage);

        $this->updating = false;

        return view('livewire.team-events', [
            'allEvents' => $allEvents,
            'allEventsPages' => $allEventsPages,
            'currentPage' => $this->page,
            'updating' => $this->updating
        ]);
    }
    private function sendRequestWithRetry($requestFunction)
    {
        $maxRetries = 3; // Maksimalan broj ponovnih pokušaja
        $retryDelay = 2; // Pauza u sekundama između ponovnih pokušaja

        $retryCount = 0;

        while ($retryCount < $maxRetries) {
            try {
                return $requestFunction();
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                if ($e->getResponse()->getStatusCode() == 429) {
                    // Pauza prije ponovnog pokušaja
                    sleep($retryDelay);
                    $retryCount++;
                } else {
                    throw $e; // Ako je greška nešto drugo, prekini pokušaje
                }
            }
        }

        // Ako se nakon maksimalnog broja pokušaja i dalje dobija greška 429, možete dodati daljnju obradu ili prekinuti izvođenje.
        throw new \Exception('Nije moguće dobiti odgovor nakon ponovnih pokušaja.');
    }
}

