<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class PlayerStatistics extends Component
{
    public $data;
    public $selectedKey = 'rating';
    public $additionalData = [];
    public $selectedData = [];

    public function mount($seasonId, $tournamentId)
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
        ])->get('https://sofasport.p.rapidapi.com/v1/seasons/players-statistics/result', [
            'seasons_statistics_type' => 'overall',
            'seasons_id' => $seasonId,
            'unique_tournament_id' => $tournamentId,
        ]);

        $this->data = $response->json();

        $this->selectedKey = 'rating';
        $this->selectedData = $this->getDataBySelectedKey($this->selectedKey);

        $additionalData = [];

        // Iterirajte kroz igrače i dohvatite podatke za svakog igrača
        foreach ($this->data as $item) {
            foreach ($item[$this->selectedKey] as $playerData) {
                $playerId = $playerData['player']['id'];

                // Drugi API poziv s $playerId
                $stats = Http::withHeaders([
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                ])->get('https://sofasport.p.rapidapi.com/v1/players/statistics/result', [
                    'player_stat_type' => 'overall',
                    'seasons_id' => $seasonId,
                    'unique_tournament_id' => $tournamentId,
                    'player_id' => $playerId,
                ]);

                $additionalStats = $stats->json();
                $additionalData[$playerId] = $additionalStats;
            }
        }

        // Spremite dodatne podatke u svoju svojstvo
        $this->additionalData = $additionalData;
/*            dd($additionalData);*/
    }

    public function selectKey($key)
    {
        $this->selectedKey = $key;
        $this->selectedData = $this->getDataBySelectedKey($key);
    }

    public function getDataBySelectedKey($key)
    {
        // Implementirajte logiku dohvaćanja podataka na temelju odabranog ključa
        // Koristite istu logiku koju ste koristili prije za dohvaćanje podataka
        // Možete prilagoditi kako želite prikazivati podatke
        // Vratite podatke koji će se prikazati u tablici
        return $this->additionalData[$key] ?? [];
    }

    public function render()
    {
        return view('livewire.player-statistics');
    }
}
