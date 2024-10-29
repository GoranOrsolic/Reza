<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class BasketballStandings extends Component
{
    public $data = [];
    public $selectedKey = null;
    public $selectedData = null;
    public $loading = true;
    public $error = null;

    public function mount($seasonId, $tournamentId)
    {
        // API poziv za dohvaćanje podataka
        try {
            $response = Http::withHeaders([
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ])->get('https://sofasport.p.rapidapi.com/v1/seasons/standings', [
                'standing_type' => 'total',
                'seasons_id' => $seasonId,
                'unique_tournament_id' => $tournamentId
            ]);

            if ($response->successful()) {
                $this->data = $response->json()['data'];  // Uzimamo podatke iz odgovora API-ja

                // Ako postoje podaci, postavljamo prvi element kao odabrani
                if (!empty($this->data)) {
                    $this->selectedKey = $this->data[0]['name'];
                    $this->selectedData = $this->data[0];
                }
            } else {
                $this->error = 'Neuspješno dohvaćanje podataka.';
            }
        } catch (\Exception $e) {
            $this->error = 'Došlo je do greške prilikom dohvaćanja podataka.';
        }

        $this->loading = false;
    }

    public function updatedSelectedKey($value)
    {
        // Ažuriranje odabranih podataka na osnovu odabranog ključa
        $this->selectedData = collect($this->data)->firstWhere('name', $value);
    }

    public function render()
    {
        return view('livewire.basketball-standings');
    }
}
