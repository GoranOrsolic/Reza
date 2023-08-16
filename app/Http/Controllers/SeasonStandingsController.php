<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SeasonStandingsController extends Controller
{
    public function show($tournamentId)
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
        ])->get('https://sofasport.p.rapidapi.com/v1/unique-tournaments/seasons?unique_tournament_id=' . $tournamentId);

        $seasons = $response->json()['data'];

        if (!empty($seasons)) {
            $seasonId = $seasons[0]['id'];

            $standings = Http::withHeaders([
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            ])->get('https://sofasport.p.rapidapi.com/v1/seasons/standings?standing_type=total&seasons_id=' . $seasonId . '&unique_tournament_id=' . $tournamentId)
                ->json()['data'];
        } else {
            $standings = [];
        }

        $client = new Client();
        $tournamentLogoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/unique-tournaments/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'unique_tournament_id' =>  $tournamentId]
        ]);
        $logo = base64_encode($tournamentLogoResponse->getBody()->getContents());

        $teamIds = [];
        foreach ($standings[0]['rows'] as $row) {
            $teamIds[] = $row['team']['id'];
        }

        // Dohvat i obrada timskih logotipa
        $teamLogos = [];
        foreach ($teamIds as $teamId) {
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
            $teamBase64Logo = 'data:image/png;base64,' . base64_encode($teamLogoData);

            $teamLogos[$teamId] = $teamBase64Logo;
        }

        foreach ($standings as $index => $data) {

            foreach ($data as $dat) {

                $nextEvents = Http::withHeaders([
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
                ])
                    ->get('https://sofasport.p.rapidapi.com/v1/tournaments/events?course_events=next&page=0&tournament_id=' . $dat['id'])
                    ->json()['data'];
                $pastEvents = Http::withHeaders([
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
                ])
                    ->get('https://sofasport.p.rapidapi.com/v1/tournaments/events?course_events=last&page=0&tournament_id=' . $dat['id'])
                    ->json()['data'];


                return view('standings', [
                    'standings' => $standings,
                    'nextEvents' => $nextEvents,
                    'pastEvents' => $pastEvents,
                    'tournamentLogo' => $logo,
                    'teamLogos' => $teamLogos
                ]);
            }
        }
    }
}
