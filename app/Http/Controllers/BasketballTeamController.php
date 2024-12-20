<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BasketballTeamController extends Controller
{
    public $seasonId;
    public $tournamentId;
    public $id;

    public function showTeamInfo($id, Request $request, $page = 0)
    {
        $seasonId = $request->query('seasonId'); // Dohvaća ID sezone iz query stringa
        $tournamentId = $request->query('tournamentId'); // Dohvaća ID turnira iz query stringa

        $logo = $this->getTeamLogo($id);
        $info = $this->getTeamInfo($id);
        $nextMatch = $this->teamNextMatch($id);
        $homeTeamLogoImg = isset($nextMatch['data']['nextEvent']['homeTeam']['id']) ? $this->getTeamLogoById($nextMatch['data']['nextEvent']['homeTeam']['id']) : null;
        $awayTeamLogoImg = isset($nextMatch['data']['nextEvent']['awayTeam']['id']) ? $this->getTeamLogoById($nextMatch['data']['nextEvent']['awayTeam']['id']) : null;
        $headTwoHeadStats = isset($nextMatch['data']['nextEvent']['id']) ? $this->headTwoHeadStats($nextMatch['data']['nextEvent']['id']) : null;
        $matchInfo = isset($nextMatch['data']['nextEvent']['id']) ? $this->matchInfo($nextMatch['data']['nextEvent']['id']) : null;
        $playersData = $this->teamPlayers($id);
        $transfers = $this->teamTransfers($id);

        return view('team.basketball-team', [
            'teamLogo' => $logo,
            'teamInfo' => $info,
            'seasonId' => $seasonId,
            'tournamentId' => $tournamentId,
            'id' => $id,
            'page' => $page,
            'nextMatch' => $nextMatch,
            'homeTeamLogoImg' => $homeTeamLogoImg,
            'awayTeamLogoImg' => $awayTeamLogoImg,
            'headTwoHeadStats' => $headTwoHeadStats,
            'matchInfo' => $matchInfo,
            'players' => $playersData['players'],  // Prosljeđivanje igrača u pogled
            'averageAge' => $playersData['averageAge'],
            'transfers' => $transfers,





        ]);
    }

    private function getTeamLogo ($id){

        $client = new Client();
        $teamLogo =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $logo = base64_encode($teamLogo->getBody()->getContents());
        return $logo;

    }

    private function getTeamInfo($id) {

        $client = new Client();
        $teamInfo =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/data', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);

        $info = json_decode($teamInfo->getBody()->getContents(), true);
        return $info;
    }

    private function teamNextMatch($id){

        $client = new Client();
        $teamNextEvent =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/near-events', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $nextMatch = json_decode($teamNextEvent->getBody()->getContents(), true);

        return $nextMatch;

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

    private function headTwoHeadStats($eventId)
    {
        $client = new Client();
        $headTwoHead =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/events/h2h-stats', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'event_id' =>  $eventId]
        ]);
        $headTwoHeadStats = json_decode($headTwoHead->getBody()->getContents(), true);
        return $headTwoHeadStats;
    }

    private function matchInfo($eventId)
    {
        $client = new Client();
        $matchData = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/events/data', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'event_id' =>  $eventId]
        ]);
        $matchInfo  = json_decode($matchData->getBody()->getContents(), true);
        return $matchInfo;
    }

    private function teamPlayers($id)
    {
        $client = new Client();
        $teamPlayers = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/players', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
            ],
            'query' => [
                'team_id' => $id
            ]
        ]);

        $players = json_decode($teamPlayers->getBody()->getContents(), true);

        // Računanje prosječne dobi
        $ages = [];
        foreach ($players['data']['players'] as $playerData) {
            $dob = new \DateTime(date('Y-m-d', $playerData['player']['dateOfBirthTimestamp']));
            $now = new \DateTime();
            $age = $now->diff($dob)->y;
            $ages[] = $age;
        }

        // Izračun prosječne dobi
        $averageAge = count($ages) > 0 ? array_sum($ages) / count($ages) : 0;

        // Možete vratiti ili cijelu listu igrača, ili prosječnu dob
        return [
            'players' => $players, // Povratak cijelog niza igrača
            'averageAge' => $averageAge,  // Povratak prosječne dobi
        ];
    }

    private function teamTransfers($id)
    {
        $client = new Client();
        $teamTransfers =  $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/transfers', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $id]
        ]);
        $transfers = json_decode($teamTransfers->getBody()->getContents(), true);
        return $transfers;
    }


}
