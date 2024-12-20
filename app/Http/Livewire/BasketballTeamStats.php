<?php

namespace App\Http\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class BasketballTeamStats extends Component
{
    public $playerStatistics;
    public $selectedKey;
    public $seasonId;
    public $tournamentId;

    public function mount($seasonId, $tournamentId)
    {
        $this->seasonId = $seasonId;
        $this->tournamentId = $tournamentId;
        $this->selectedKey = 'points';
        $this->refresh(); // Dohvaćanje podataka pri montiranju komponente
    }

    public function refresh()
    {
        $client = new Client();

        $response = $client->get('https://sofasport.p.rapidapi.com/v1/seasons/teams-statistics/result', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ],
            'query' => [
                'seasons_statistics_type' => 'overall',
                'seasons_id' =>  $this->seasonId,
                'unique_tournament_id' => $this->tournamentId,
            ],
        ]);

        $players = json_decode($response->getBody()->getContents(), true);

        // Izdvajanje ID-eva igrača
        $playerIds = $this->extractPlayerIds($players['data']);

        // Dohvaćanje slika igrača i spremanje u cache
        $playerPhotos = [];
        foreach ($playerIds as $playerId) {
            $playerPhotos[$playerId] = Cache::remember("player_photos_{$playerId}", now()->addDay(), function () use ($client, $playerId) {
                try {
                    $playerPhotoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
                        'headers' => [
                            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                        ],
                        'query' => [
                            'team_id' => $playerId,
                        ],
                    ]);

                    if ($playerPhotoResponse->getStatusCode() == 200) {
                        $playerPhotoData = $playerPhotoResponse->getBody()->getContents();
                        $playerPhoto = 'data:image/png;base64,' . base64_encode($playerPhotoData);
                        return $playerPhoto;
                    }
                } catch (\Exception $e) {
                    // Ignoriraj greške 404 ili bilo koje druge
                    return null;
                }
            });
        }

        $this->playerStatistics = $players;
        $this->playerPhotos = array_filter($playerPhotos); // Filtriraj null vrijednosti
    }

    // Rekurzivna funkcija za izdvajanje ID-eva igrača
    private function extractPlayerIds($data)
    {
        $playerIds = [];

        foreach ($data as $key => $value) {
            // Ako ključ ima 'player' podključ, to znači da sadrži podatke o igraču
            if (isset($value['team']['id'])) {
                $playerIds[] = $value['team']['id'];
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
        return view('livewire.basketball-team-stats',[
        'playerStatistics' => $this->playerStatistics,
            'playerPhotos' => $this->playerPhotos,
        ]);
    }
}
