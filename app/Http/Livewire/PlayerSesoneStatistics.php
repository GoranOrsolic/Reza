<?php

namespace App\Http\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class PlayerSesoneStatistics extends Component
{
    public $playerStatistics;
    public $selectedKey;
    public $teamId;
    public $seasonId;
    public $tournamentId;

    public function mount($teamId, $seasonId, $tournamentId)
    {
        $this->teamId = $teamId;
        $this->seasonId = $seasonId;
        $this->tournamentId = $tournamentId;
        $this->selectedKey = 'rating';
        $this->refresh(); // Dohvaćanje podataka pri montiranju komponente
    }

    public function refresh()
    {
        $client = new Client();

        $response = $client->get('https://sofasport.p.rapidapi.com/v1/teams/player-statistics/result', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ],
            'query' => [
                'unique_tournament_id' => $this->seasonId,
                'season_id' =>  $this->tournamentId,
                'team_id' => $this->teamId,
            ],
        ]);

        $players = json_decode($response->getBody()->getContents(), true);

        // Izdvajanje ID-eva igrača
        $playerIds = $this->extractPlayerIds($players['data']);

        // Dohvaćanje slika igrača i spremanje u cache
        $playerPhotos = [];
        foreach ($playerIds as $playerId) {
            $playerPhotos[$playerId] = Cache::remember("player_photos_{$playerId}", now()->addDay(), function () use ($client, $playerId) {
                $playerPhotoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/players/photo', [
                    'headers' => [
                        'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                        'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                    ],
                    'query' => [
                        'player_id' => $playerId,
                    ],
                ]);

                $playerPhotoData = $playerPhotoResponse->getBody()->getContents();
                $playerPhoto = 'data:image/png;base64,' . base64_encode($playerPhotoData);

                return $playerPhoto;
            });
        }

        $this->playerStatistics = $players;
        $this->playerPhotos = $playerPhotos;
    }

    // Rekurzivna funkcija za izdvajanje ID-eva igrača
    private function extractPlayerIds($data)
    {
        $playerIds = [];

        foreach ($data as $key => $value) {
            // Ako ključ ima 'player' podključ, to znači da sadrži podatke o igraču
            if (isset($value['player']['id'])) {
                $playerIds[] = $value['player']['id'];
            } elseif (is_array($value)) {
                // Ako je podatak u obliku niza, rekurzivno pretražujemo taj niz
                $playerIds = array_merge($playerIds, $this->extractPlayerIds($value));
            }
        }

        return $playerIds;
    }

    public function selectKey($key)
    {
        $this->selectedKey = $key;
        // Nema potrebe za ručnim ažuriranjem sučelja jer se koristi wire:model
    }

    public function render()
    {
        return view('livewire.player-sesone-statistics', [
            'playerStatistics' => $this->playerStatistics,
            'playerPhotos' => $this->playerPhotos,
        ]);
    }
}
