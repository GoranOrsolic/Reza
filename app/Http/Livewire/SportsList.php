<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SportsList extends Component
{
    public $sports;

    public function mount()
    {
        $this->fetchSports();
    }

    public function fetchSports()
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
        ])->get('https://sofasport.p.rapidapi.com/v1/sports')->json();

        // Provjera postojanja ključa "data" u odgovoru
        if (isset($response['data'])) {
            $this->sports = $response['data'];
        } else {
            // Dodajte odgovarajuće rukovanje pogreškama ili poruku korisnicima
            // ako ključ "data" nije prisutan u odgovoru.
        }
    }

    public function render()
    {
        if ($this->sports) {
            $topSports = array_slice($this->sports, 0, 15);
            $dropdownSports = array_slice($this->sports, 15);

            return view('livewire.sports-list', [
                'topSports' => $topSports,
                'dropdownSports' => $dropdownSports,
            ]);
        } else {
            // Dodajte odgovarajuće rukovanje pogreškama ili poruku korisnicima
            // ako $this->sports nije postavljen.
            return view('livewire.sports-list', [
                'topSports' => [],
                'dropdownSports' => [],
            ]);
        }
    }
}
