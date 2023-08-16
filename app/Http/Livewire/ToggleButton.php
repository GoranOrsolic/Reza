<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use Carbon\Carbon;

class ToggleButton extends Component
{
    public $showContent1 = true;
    public $todayMatch;
    public $liveMatch;

    public function toggleView()
    {
        $this->showContent1 = !$this->showContent1;
    }


    public function fetchTodayFootball()
    {
        $date = Carbon::now();
        $date->timezone('Europe/Zagreb');
        $formattedDate = $date->format('Y-m-d');

        $client = new Client();
        $response = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/events/schedule/date', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
            ],
            'query' => [
                'date' => $formattedDate,
                'sport_id' => '1'
            ]
        ]);

        $this->todayMatch = json_decode($response->getBody()->getContents(), true);
    }

    public function fetchLiveFootball()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/events/schedule/live', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
            ],
            'query' => [
                'sport_id' => 1
            ]
        ]);

        $this->liveMatch = json_decode($response->getBody()->getContents(), true);
    }

    public function render()
    {
        // Pozivamo metode za dohvaćanje podataka prije nego što se prikaže pogled.
        $this->fetchTodayFootball();
        $this->fetchLiveFootball();

        return view('livewire.toggle-button');
    }
}
