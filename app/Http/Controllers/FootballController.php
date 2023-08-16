<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ViewModels\FootballTeamViewModel;
use App\ViewModels\SeasonsViewModel;
use App\ViewModels\StandingsViewModel;
use App\ViewModels\LogoViewModel;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;

class FootballController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tournaments = Http::withHeaders([
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

        $viewModel = new LogoViewModel($tournaments);


        return view('football.tournaments', $viewModel);

    }

    /**
     * standings the form for creating a new resource.
     *  @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function standings($ide, $url)
    {
        $standings = Http::withHeaders([
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

        $viewModel = new StandingsViewModel($standings, $nextEvents, $pastEvents, $base64);


        return view('standings', $viewModel);
            }}
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
        $seasons = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
        ])
            ->get('https://sofasport.p.rapidapi.com/v1/unique-tournaments/seasons?unique_tournament_id='.$id)
            ->json()['data'];

        $url = $request->route('id');
            //dd($url);

        $viewModel = new SeasonsViewModel($seasons);


        return view('seasons', $viewModel, compact('url'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function footballTeam($id, $page = 0)
    {
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
        $teamTournaments =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/current-tournaments', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $tournaments = json_decode($teamTournaments->getBody()->getContents(), true);
        /////////////

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
        abort_if($page > 50, 204);
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
        //dd($eventsLast);
        ///////////////////


        $viewModel = new FootballTeamViewModel($dat, $base64, $transfers, $tournaments, $players, $eventsNext, $eventsLast, $page);


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
        //
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
