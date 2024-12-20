<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\ViewModels\FootballTeamViewModel;
/*use App\ViewModels\SeasonsViewModel;
use App\ViewModels\StandingsViewModel;
use App\ViewModels\LogoViewModel;
use Illuminate\Support\Collection;*/
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use App\Http\Livewire\DropdownStatistics;

class FootballController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        /*$tournaments = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
        ])
            ->get('https://sofasport.p.rapidapi.com/v1/unique-tournaments?category_id='.$id)
            ->json()['data'];

        //dd($categories);
       /* foreach ($categories as $logo) {
            //dd($logo);

            $logoId = $logo['id'];

            //dd($logoId);

            $logo = Http::withHeaders([
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.co',
            ])
                ->get('https://sofasport.p.rapidapi.com/v1/unique-tournaments/logo?unique_tournament_id='.$logoId)
                ->json()['data'];



            dd($logo);
            }*/

        /* $viewModel = new LogoViewModel($tournaments);


         return view('football.tournaments', $viewModel);*/

    }

    /**
     * standings the form for creating a new resource.
     *  @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function standings($ide, $url)
    {
        /*$standings = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
        ])
            ->get('https://sofasport.p.rapidapi.com/v1/seasons/standings?standing_type=total&seasons_id='.$ide.'&unique_tournament_id='.$url)
            ->json()['data'];

        $client = new Client();
        $tournamentLogo =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/unique-tournaments/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'unique_tournament_id' =>  $url]
        ]);
        $dat = $tournamentLogo->getBody()->getContents();
        $base64 = 'data:image/png;base64,' . base64_encode($dat);

        foreach($standings as $index => $data) {

            foreach ($data as $dat) {
                //dd($dat);

                $nextEvents = Http::withHeaders([
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
                ])
                    ->get('https://sofasport.p.rapidapi.com/v1/tournaments/events?course_events=next&page=0&tournament_id='.$dat['id'])
                    ->json()['data'];
                $pastEvents = Http::withHeaders([
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
                ])
                    ->get('https://sofasport.p.rapidapi.com/v1/tournaments/events?course_events=last&page=0&tournament_id='.$dat['id'])
                    ->json()['data'];
                //dd($pastEvents);
               /* $flattened = collect($data['rows']);
                $arrayOfIds = $flattened->flatten()->pluck('id')->all();
                dd($arrayOfIds);


                dd($flattened->all());
                foreach ($data['rows'] as $teamId){
               dd($data['rows']);
                //dump($logo = $teamId['team']['id']);

                $client = new Client();
                $teamLogo = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
                    'headers' => [
                        'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                        'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
                    'query' => [
                        'team_id' => $logo]
                ]);
                $dat = $teamLogo->getBody()->getContents();
                $base64 = 'data:image/png;base64,' . base64_encode($dat);
                //dd($base64);*/
        /*                $teamLogo->getHeader('content-type')[0];*/

        /* $viewModel = new StandingsViewModel($standings, $nextEvents, $pastEvents, $base64);


         return view('standings', $viewModel);*/

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,int $id)

    {

        /*$seasons = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
        ])
            ->get('https://sofasport.p.rapidapi.com/v1/unique-tournaments/seasons?unique_tournament_id='.$id)
            ->json()['data'];

        $url = $request->route('id');
            //dd($url);

        $viewModel = new SeasonsViewModel($seasons);


        return view('seasons', $viewModel, compact('url'));*/

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function footballTeam($id, $page = 0)
    {
        //// Next match
        $client = new Client();
        $teamNextEvent =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/near-events', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $nextMatch = json_decode($teamNextEvent->getBody()->getContents(), true);

        ///Home team logo
        $client = new Client();
        $homeTeamLogo =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $nextMatch['data']['nextEvent']['homeTeam']['id']]
        ]);

        $homeTLogo = $homeTeamLogo->getBody()->getContents();
        $homeTeamLogoImg = 'data:image/png;base64,' . base64_encode($homeTLogo);

        ///// Away team logo
        $client = new Client();
        $awayTeamLogo =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $nextMatch['data']['nextEvent']['awayTeam']['id']]
        ]);

        $awayTLogo = $awayTeamLogo->getBody()->getContents();
        $awayTeamLogoImg = 'data:image/png;base64,' . base64_encode($awayTLogo);

        ///// H2H info
        $client = new Client();
        $headTwoHead =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/events/h2h-stats', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'event_id' =>  $nextMatch['data']['nextEvent']['id']]
        ]);
        $headTwoHeadStats = json_decode($headTwoHead->getBody()->getContents(), true);

        //// Team standings
        $seasonId = session('seasonId');
        $tournamentId = session('tournamentId');
        $standings = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
        ])->get('https://sofasport.p.rapidapi.com/v1/seasons/standings?standing_type=total&seasons_id=' . $seasonId . '&unique_tournament_id=' . $tournamentId)
            ->json()['data'];


        $teamIds = [];
        foreach ($standings[0]['rows'] as $row) {
            $teamIds[] = $row['team']['id'];
        }

        ////Team statistics
        $client = new Client();

        try {
            $response = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/statistics/result', [
                'headers' => [
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
                ],
                'query' => [
                    'team_id' =>  $id,
                    'season_id' => $seasonId,
                    'unique_tournament_id' => $tournamentId,
                    'team_stat_type' => 'overall'
                ]
            ]);

            $seasonStats = json_decode($response->getBody()->getContents(), true);

            if (empty($seasonStats)) {
                // API odgovor je prazan, poduzmi odgovarajuće mjere
                $seasonStats = ['message' => 'Trenutno nema podataka za ovu sezonu.'];
            }

        } catch (RequestException $e) {
            // Obradi grešku API poziva
            $seasonStats = ['error' => 'Greška pri dohvaćanju podataka: ' . $e->getMessage()];
        }

        ///// Team logo
        $teamLogos = [];
        $client = new Client();
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

        //teamInfo
        $client = new Client();
        $teamInfo =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/data', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $dat = json_decode($teamInfo->getBody()->getContents(), true);
        ////////////////

        //teamLogo
        $client = new Client();
        $teamLogo =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $data = $teamLogo->getBody()->getContents();
        $base64 = 'data:image/png;base64,' . base64_encode($data);
        ///////////////

        //team Transfers
        $client = new Client();
        $teamTransfers =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/transfers', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $transfers = json_decode($teamTransfers->getBody()->getContents(), true);
        ////////////////

        ////Current team tournaments
        $client = new Client();
        $teamTournaments = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/current-tournaments', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' => $id]
        ]);
        $tournaments = json_decode($teamTournaments->getBody()->getContents(), true);

        /////////// Logo turnira
        $logos = [];

        foreach ($tournaments['data'] as $turnir) {
            $turnirId = $turnir['id'];

            // Dodatno kašnjenje između zahtjeva
            sleep(2); // Pauza od 1 sekunde

            // Drugi API poziv za dohvaćanje loga za trenutni turnir
            $tournamentLogo = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/unique-tournaments/logo', [
                'headers' => [
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
                'query' => [
                    'unique_tournament_id' => $turnirId]
            ]);

            $turLogo = $tournamentLogo->getBody()->getContents();
            $turnirLogo = 'data:image/png;base64,' . base64_encode($turLogo);

            // Dodajte logo u niz s ključem koji odgovara id-u turnira
            $logos[$turnirId] = $turnirLogo;
        }

        ///Players of team
        $client = new Client();
        $teamPlayers =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/players', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $players  = json_decode($teamPlayers->getBody()->getContents(), true);

        $ages = [];
        foreach ($players['data']['players'] as $playerData) {
            $dob = new \DateTime(date('Y-m-d', $playerData['player']['dateOfBirthTimestamp']));
            $now = new \DateTime();
            $age = $now->diff($dob)->y;
            $ages[] = $age;
        }

        // Izračunajte prosječnu dob
        $averageAge = count($ages) > 0 ? array_sum($ages) / count($ages) : 0;

        ///////// Photo of players
        $playerPhotos = [];

        foreach ($players['data']['players'] as $playerDataId) {
            $playerId = $playerDataId['player']['id'];

            $playerPhotos[$playerId] = Cache::remember("player_photos_{$playerId}", now()->addHours(24), function () use ($client, $playerId) {
                try {
                    $playerPhotoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/players/photo', [
                        'headers' => [
                            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                        ],
                        'query' => [
                            'player_id' => $playerId,
                        ],
                    ]);

                    // Provjerite status odgovora
                    if ($playerPhotoResponse->getStatusCode() === 200) {
                        $playerPhotoData = $playerPhotoResponse->getBody()->getContents();
                        $playerPhoto = 'data:image/png;base64,' . base64_encode($playerPhotoData);
                    } else {
                        // Ako je status neuspješan, postavite defaultnu sliku ili neku drugu obradu
                        $playerPhoto = 'default-player-photo.png';
                    }
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    // Uhvatite iznimku u slučaju greške 404 ili druge greške
                    if ($e->getResponse()->getStatusCode() === 404) {
                        // Slika igrača nije pronađena, postavite defaultnu sliku ili neku drugu obradu
                        $playerPhoto = 'default-player-photo.png';
                    } else {
                        // Obrada ostalih mogućih iznimki
                        // Možete logirati grešku ili obraditi prema potrebi
                        $playerPhoto = 'default-player-photo.png';
                    }
                }

                return $playerPhoto;
            });
        }


        ///Team events next
        $client = new Client();
        $nextEvents =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/events', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id,
                'page' => '0',
                'course_events' => 'next']
        ]);
        $eventsNext  = json_decode($nextEvents->getBody()->getContents(), true);
        //////////////////

        ///Team events last
        $client = new Client();
        $lastEvents =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/events', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id,
                'page' => $page,
                'course_events' => 'last']
        ]);
        $eventsLast  = json_decode($lastEvents->getBody()->getContents(), true);

        ///// Match data
        $client = new Client();
        $matchData = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/events/data', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'event_id' =>  $nextMatch['data']['nextEvent']['id']]
        ]);
        $matchInfo  = json_decode($matchData->getBody()->getContents(), true);

        ///Media

        $client = new Client();
        $media = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/news-feed', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $mediaInfo  = json_decode($media->getBody()->getContents(), true);


        $viewModel = new FootballTeamViewModel($dat, $base64, $transfers, $tournaments, $players, $eventsNext,
            $eventsLast, $standings, $teamLogos, $seasonId, $tournamentId,
            $page, $id, $nextMatch, $homeTeamLogoImg, $awayTeamLogoImg, $headTwoHeadStats, $matchInfo, $averageAge, $logos, $playerPhotos, $seasonStats, $teamId, $mediaInfo);


        return view('team.football', $viewModel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       /* $client = new Client();
        $playerStatistics =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/player-statistics/result', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'unique_tournament_id' => $tournamentId,
                'season_id' => $seasonId,
                'team_id' =>  $id,
            ]
        ]);
        $seasonPlayerStats = json_decode($seasonStatistics->getBody()->getContents(), true);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
