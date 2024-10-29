<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendTeamLogoRequest;

class SeasonStandingsController extends Controller
{
    public function show($tournamentId, $page = 1)
    {
        list($seasonId, $standings) = $this->getSeasonAndStandings($tournamentId);

        $logo = $this->getTournamentLogo($tournamentId);

        $teamIds = $this->getTeamIdsFromStandings($standings);

        $teamLogos = $this->getTeamLogos($teamIds);

        $dataTournament = $this->getTournamentData($tournamentId);

        // Provjeri postojanje ključa 'data' prije pristupa
        $teamHolderImg = isset($dataTournament['data']['titleHolder']['id']) ? $this->getTeamLogoById($dataTournament['data']['titleHolder']['id']) : null;

        // Provjeri postojanje ključa 'data' prije pristupa
        $teamMostImg = isset($dataTournament['data']['mostTitlesTeams'][0]['id']) ? $this->getTeamLogoById($dataTournament['data']['mostTitlesTeams'][0]['id']) : null;

        // Provjeri postojanje ključa 'data' prije pristupa
        $lowerDivisionImg = isset($dataTournament['data']['lowerDivisions'][0]['id']) ? $this->getLowerDivisionLogo($dataTournament['data']['lowerDivisions'][0]['id']) : null;

        $newcomersInfo = $this->getNewcomersInfo($seasonId, $tournamentId);

        // Provjeri postojanje ključa 'data' prije pristupa
        $newcomersLogoImg = isset($newcomersInfo['data']['newcomersLowerDivision'][0]['id']) ? $this->getTeamLogoById($newcomersInfo['data']['newcomersLowerDivision'][0]['id']) : null;

        $dataFeaturedEvents = $this->getFeaturedEvents($tournamentId);

        // Provjeri postojanje ključa 'data' prije pristupa
        $homeTeamLogoImg = isset($dataFeaturedEvents['data'][0]['homeTeam']['id']) ? $this->getTeamLogoById($dataFeaturedEvents['data'][0]['homeTeam']['id']) : null;

        // Provjeri postojanje ključa 'data' prije pristupa
        $awayTeamLogoImg = isset($dataFeaturedEvents['data'][0]['awayTeam']['id']) ? $this->getTeamLogoById($dataFeaturedEvents['data'][0]['awayTeam']['id']) : null;

        $topStatsPlayers = $this->getTopStatsPlayers($seasonId, $tournamentId);

        $playerPhotos = $this->getPlayerPhotos($topStatsPlayers['data']['rating'], 'player_id');

        $playerGoalsPhotos = $this->getPlayerPhotos($topStatsPlayers['data']['goals'], 'player_id');

        $teamLogoRating = $this->getTeamLogosFromPlayers($topStatsPlayers['data']['rating'], 'team_id');

        $teamLogoGoals = $this->getTeamLogosFromPlayers($topStatsPlayers['data']['goals'], 'team_id');

        return view('standings', [
            'standings' => $standings,
            'tournamentId' => $tournamentId,
            'currentPage' => $page,
            'tournamentLogo' => $logo,
            'teamLogos' => $teamLogos,
            'seasonId' => $seasonId,
            'dataTournament' => $dataTournament,
            'teamHolderImg' => $teamHolderImg,
            'teamMostImg' => $teamMostImg,
            'lowerDivisionImg' => $lowerDivisionImg,
            'newcomersInfo' => $newcomersInfo,
            'newcomersLogoImg' => $newcomersLogoImg,
            'dataFeaturedEvents' => $dataFeaturedEvents,
            'homeTeamLogoImg' => $homeTeamLogoImg,
            'awayTeamLogoImg' => $awayTeamLogoImg,
            'topStatsPlayers' => $topStatsPlayers,
            'playerPhotos' => $playerPhotos,
            'playerGoalsPhotos' => $playerGoalsPhotos,
            'teamLogoRating' => $teamLogoRating,
            'teamLogoGoals' => $teamLogoGoals,
        ]);
    }

    private function getSeasonAndStandings($tournamentId)
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
        ])->get('https://sofasport.p.rapidapi.com/v1/unique-tournaments/seasons?unique_tournament_id=' . $tournamentId);

        $seasons = $response->json()['data'];

        if (!empty($seasons)) {
            $seasonId = $seasons[0]['id'];
            session(['seasonId' => $seasonId, 'tournamentId' => $tournamentId]);

            $standings = Http::withHeaders([
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ])->get('https://sofasport.p.rapidapi.com/v1/seasons/standings?standing_type=total&seasons_id=' . $seasonId . '&unique_tournament_id=' . $tournamentId)
                ->json()['data'];
        } else {
            $standings = [];
        }

        return [$seasonId, $standings];
    }

    private function getTournamentLogo($tournamentId)
    {
        $client = new Client();
        $tournamentLogoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/unique-tournaments/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ],
            'query' => [
                'unique_tournament_id' => $tournamentId]
        ]);
        $logo = base64_encode($tournamentLogoResponse->getBody()->getContents());

        return $logo;
    }

    private function getTeamIdsFromStandings($standings)
    {
        $teamIds = [];
        foreach ($standings[0]['rows'] as $row) {
            $teamIds[] = $row['team']['id'];
        }

        return $teamIds;
    }

    private function getTeamLogos($teamIds)
    {
        return Cache::remember('team_logos', now()->addHours(24), function () use ($teamIds) {
            $client = new Client();
            $teamLogos = [];

            foreach ($teamIds as $teamId) {
                $teamBase64Logo = Cache::remember('team_logo_' . $teamId, now()->addHours(24), function () use ($client, $teamId) {
                    $teamLogoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
                        'headers' => [
                            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                        ],
                        'query' => [
                            'team_id' => $teamId,
                        ],
                    ]);

                    $teamLogoData = $teamLogoResponse->getBody()->getContents();
                    return 'data:image/png;base64,' . base64_encode($teamLogoData);
                });

                $teamLogos[$teamId] = $teamBase64Logo;

                // Pauza između zahtjeva (npr. 2 sekunde)
                sleep(1);
            }

            return $teamLogos;
        });
    }

    private function getTournamentData($tournamentId)
    {
        $client = new Client();
        $tournamentData = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/unique-tournaments/data', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'unique_tournament_id' => $tournamentId]
        ]);
        $dataTournament = json_decode($tournamentData->getBody()->getContents(), true);

        return $dataTournament;
    }

    private function getTeamLogoById($teamId)
    {
        $client = new Client();
        $teamHolderLogo = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' => $teamId]
        ]);

        $holderLogo = $teamHolderLogo->getBody()->getContents();
        $teamHolderImg = 'data:image/png;base64,' . base64_encode($holderLogo);

        return $teamHolderImg;
    }

    private function getNewcomersInfo($seasonId, $tournamentId)
    {
        $client = new Client();

        try {
            $newcomersData = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/seasons/data', [
                'headers' => [
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
                ],
                'query' => [
                    'seasons_id' => $seasonId,
                    'unique_tournament_id' => $tournamentId
                ]
            ]);

            $newcomersInfo = json_decode($newcomersData->getBody()->getContents(), true);
            return $newcomersInfo;

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Provjera ako je greška 404
            if ($e->getResponse()->getStatusCode() == 404) {
                // Ako je 404 greška, vraćamo prazan niz ili null
                return [];
            } else {
                // Ako je neka druga greška, ponovno bacamo izuzetak
                throw $e;
            }
        }
    }

    private function getFeaturedEvents($tournamentId)
    {
        $client = new Client();
        $featuredEvents = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/unique-tournaments/featured-events', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'unique_tournament_id' => $tournamentId]
        ]);
        $dataFeaturedEvents = json_decode($featuredEvents->getBody()->getContents(), true);

        return $dataFeaturedEvents;
    }

    private function getPlayerPhotos($players, $key)
    {
        $client = new Client();
        $playerPhotos = [];

        foreach (array_slice($players, 0, 10) as $playerData) {
            $playerId = $playerData['player']['id'];

            try {
                $playerPhoto = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/players/photo', [
                    'headers' => [
                        'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                        'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                    ],
                    'query' => [
                        'player_id' => $playerId,
                    ],
                ]);
                if ($playerPhoto->getStatusCode() == 200) {
                    $playerPhotoData = $playerPhoto->getBody()->getContents();
                    $playerPhotos[] = 'data:image/png;base64,' . base64_encode($playerPhotoData);
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                sleep(5);
            }
        }

        return $playerPhotos;
    }

    private function getTeamLogosFromPlayers($players, $key)
    {
        $client = new Client();
        $teamLogos = [];

        foreach (array_slice($players, 0, 10) as $playerData) {
            $teamId = $playerData['team']['id'];

            try {
                $teamLogo = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
                    'headers' => [
                        'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                        'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                    ],
                    'query' => [
                        'team_id' => $teamId,
                    ],
                ]);

                $teamLogoData = $teamLogo->getBody()->getContents();
                $teamLogos[] = 'data:image/png;base64,' . base64_encode($teamLogoData);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                sleep(5);
            }
        }

        return $teamLogos;
    }

    private function getTopStatsPlayers($seasonId, $tournamentId)
    {
        $client = new Client();
        $topStatsPlayers = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/seasons/players-statistics/result', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ],
            'query' => [
                'seasons_statistics_type' => 'overall',
                'seasons_id' => $seasonId,
                'unique_tournament_id' => $tournamentId,
            ],
        ]);
        $topStatsPlayers = json_decode($topStatsPlayers->getBody()->getContents(), true);

        return $topStatsPlayers;
    }

    private function getLowerDivisionLogo($divisionId)
    {
        $client = new Client();
        $divisionLogo = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/unique-tournaments/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ],
            'query' => [
                'unique_tournament_id' => $divisionId,
            ],
        ]);

        $lowerDivisionLogo = $divisionLogo->getBody()->getContents();
        $lowerDivisionImg = 'data:image/png;base64,' . base64_encode($lowerDivisionLogo);

        return $lowerDivisionImg;
    }
}
