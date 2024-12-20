<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class BasketballStandings extends Component
{
    public $data = [];
    public $selectedKey = null;
    public $selectedData = null;
    public $loading = true;
    public $error = null;

    public $seasonId;
    public $tournamentId;

    public function mount($seasonId, $tournamentId)
    {
        // Kreiranje Guzzle klijenta
        $client = new Client();
        $logoCache = []; // Keš za logotipe timova
        $maxRetries = 3; // Maksimalan broj ponovljenih pokušaja

        try {
            // API poziv za osnovne podatke
            $response = Http::withHeaders([
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ])->get('https://sofasport.p.rapidapi.com/v1/seasons/standings', [
                'standing_type' => 'total',
                'seasons_id' => $seasonId,
                'unique_tournament_id' => $tournamentId
            ]);

            if ($response->successful()) {
                $this->data = $response->json()['data'];

                // Proveri da li $this->data ima bar jedan element i da je rows niz
                if (isset($this->data[0]['rows']) && is_array($this->data[0]['rows'])) {
                    // Prolazimo kroz svaki tim i dodajemo logo ako je dostupan
                    foreach ($this->data[0]['rows'] as &$row) {
                        $teamId = $row['team']['id'];

                        // Proveri keš pre nego što pozoveš API
                        if (isset($logoCache[$teamId])) {
                            $row['team']['logo_url'] = $logoCache[$teamId];
                            continue; // Preskoči API poziv ako je logo već u kešu
                        }

                        $retryCount = 0;
                        $logoRetrieved = false;

                        // Pokušaj da dohvatiš logo tim-a
                        while ($retryCount < $maxRetries && !$logoRetrieved) {
                            try {
                                $teamLogoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
                                    'headers' => [
                                        'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                                        'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                                    ],
                                    'query' => [
                                        'team_id' => $teamId,
                                    ]
                                ]);

                                // Dobijanje sadržaja logotipa
                                if ($teamLogoResponse->getStatusCode() == 200) {
                                    $holderLogo = $teamLogoResponse->getBody()->getContents();
                                    $row['team']['logo_url'] = 'data:image/png;base64,' . base64_encode($holderLogo);

                                    // Sačuvaj logo u keš
                                    $logoCache[$teamId] = $row['team']['logo_url'];
                                    $logoRetrieved = true; // Postavi flag da je logo uspešno preuzet
                                } elseif ($teamLogoResponse->getStatusCode() == 429) {
                                    // Ako dobijemo 429 grešku, pričekaj i pokušaj ponovo
                                    sleep(2); // Pričekaj 2 sekunde pre ponovnog pokušaja
                                    $retryCount++;
                                } else {
                                    $row['team']['logo_url'] = null; // Ako poziv nije uspeo, postavi na null
                                    $logoRetrieved = true; // Ipak nastavi dalje
                                }
                            } catch (\Exception $e) {
                                $row['team']['logo_url'] = null; // Ako dođe do greške, postavi logo na null
                                $logoRetrieved = true; // Ipak nastavi dalje
                            }
                        }
                    }

                    // Postavi odabrane podatke
                    $this->selectedKey = $this->data[0]['name'];
                    $this->selectedData = $this->data[0];
                } else {
                    $this->error = 'Nema dostupnih timova.';
                }
            } else {
                $this->error = 'Greška pri dohvaćanju osnovnih podataka: ' . $response->status() . ' - ' . $response->body();
            }
        } catch (\Exception $e) {
            $this->error = 'Došlo je do greške: ' . $e->getMessage();
        }

        $this->loading = false;
    }

    public function updatedSelectedKey($value)
    {
        // Ažuriranje odabranih podataka na osnovu odabranog ključa
        $this->selectedData = collect($this->data)->firstWhere('name', $value);

        // Ažuriranje logotipa za izabrane timove
        if (isset($this->selectedData['rows'])) {
            foreach ($this->selectedData['rows'] as &$row) {
                $teamId = $row['team']['id'];

                try {
                    $client = new Client();
                    $teamLogoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
                        'headers' => [
                            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                        ],
                        'query' => [
                            'team_id' => $teamId,
                        ]
                    ]);

                    if ($teamLogoResponse->getStatusCode() == 200) {
                        $holderLogo = $teamLogoResponse->getBody()->getContents();
                        $row['team']['logo_url'] = 'data:image/png;base64,' . base64_encode($holderLogo);
                    } else {
                        $row['team']['logo_url'] = null; // Ako poziv nije uspeo, postavi na null
                    }
                } catch (\Exception $e) {
                    $row['team']['logo_url'] = null; // Ako dođe do greške, postavi na null
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.basketball-standings');
    }
}
