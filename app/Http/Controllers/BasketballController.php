<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BasketballController extends Controller
{
    public function show (){
        return view('basketball');
    }

    public function showStandings ($tournamentId, $page = 1){

        list($seasonId, $standings) = $this->getSeasonAndStandings($tournamentId);

        $logo = $this->getTournamentLogo($tournamentId);

        $dataFeaturedEvents = $this->getFeaturedEvents($tournamentId);

        $homeTeamLogoImg = isset($dataFeaturedEvents['data'][0]['homeTeam']['id']) ? $this->getTeamLogoById($dataFeaturedEvents['data'][0]['homeTeam']['id']) : null;

        // Provjeri postojanje ključa 'data' prije pristupa
        $awayTeamLogoImg = isset($dataFeaturedEvents['data'][0]['awayTeam']['id']) ? $this->getTeamLogoById($dataFeaturedEvents['data'][0]['awayTeam']['id']) : null;

        $headTwoHeadStats = $this->getH2Hstats($dataFeaturedEvents);

        $matchInfo = $this->getMatchInfo($dataFeaturedEvents);

        $dataTournament = $this->getTournamentData($tournamentId);

        $teamCurrHolderImg = isset($dataTournament['data']['titleHolder']['id']) ? $this->getTeamLogoById($dataTournament['data']['titleHolder']['id']) : null;

        $teamMostImg = isset($dataTournament['data']['mostTitlesTeams'][0]['id']) ? $this->getTeamLogoById($dataTournament['data']['mostTitlesTeams'][0]['id']) : null;

        return view('basketball-standings', [
            'standings' => $standings,
            'seasonId' => $seasonId,
            'tournamentId' => $tournamentId,
            'currentPage' => $page,
            'dataFeaturedEvents' => $dataFeaturedEvents,
            'tournamentLogo' => $logo,
            'homeTeamLogoImg' => $homeTeamLogoImg,
            'awayTeamLogoImg' => $awayTeamLogoImg,
            'headTwoHeadStats' => $headTwoHeadStats,
            'matchInfo' => $matchInfo,
            'dataTournament' => $dataTournament,
            'teamCurrHolderImg' => $teamCurrHolderImg,
            'teamMostImg' => $teamMostImg,

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

    private function getH2Hstats($dataFeaturedEvents){

        $client = new Client();
        $headTwoHead =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/events/h2h-stats', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'event_id' =>  $dataFeaturedEvents['data'][0]['id']]
        ]);
        $headTwoHeadStats = json_decode($headTwoHead->getBody()->getContents(), true);

        return $headTwoHeadStats;
    }

    private function getMatchInfo($dataFeaturedEvents){

        $client = new Client();
        $matchData = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/events/data', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'event_id' =>  $dataFeaturedEvents['data'][0]['id']]
        ]);
        $matchInfo  = json_decode($matchData->getBody()->getContents(), true);

        return $matchInfo;
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
}
