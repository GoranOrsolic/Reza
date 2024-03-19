<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;

class DropdownStatistics extends Component
{
    public $options;
    public $seasonStats;
    public $teamId;
    public $seasonId;
    public $tournamentId;
    public $selectedCategory;
    public $isOpen = false; // Dodana varijabla za praćenje stanja

    public function mount($teamId, $seasonId, $tournamentId)
    {
        $client = new Client();

        $seasonStatistics = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/statistics/result', [
            'headers' => [
                'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'],
            'query' => [
                'team_id' =>  $teamId,
                'season_id' => $tournamentId,
                'unique_tournament_id' => $seasonId,
                'team_stat_type' => 'overall']
        ]);

        $this->seasonStats = json_decode($seasonStatistics->getBody()->getContents(), true);

        $this->selectedCategory = 'Summary';
        $this->isOpen = true;

        // Organizirajte podatke u kategorije
        $this->options = [
            'Summary' => ['matches', 'goalsScored', 'goalsConceded', 'assists'],
            'Attacking' => ['penaltyGoals', 'freeKickGoals', 'goalsFromInsideTheBox', 'goalsFromOutsideTheBox', 'leftFootGoals', 'rightFootGoals', 'headedGoals', 'hitWoodwork'],
            'Passes' => ['averageBallPossession', 'accuratePassesPercentage', 'accurateOwnHalfPassesPercentage', 'accurateOppositionHalfPassesPercentage', 'accurateLongBallsPercentage', 'accurateCrossesPercentage'],
            'Defending' => ['cleanSheets', 'errorsLeadingToShot', 'errorsLeadingToGoal', 'penaltiesCommited', 'penaltyGoalsConceded', 'clearancesOffLine', 'lastManTackles'],
            'Other' => ['yellowCards', 'redCards'],
        ];

    }

    public function render()
    {
        return view('livewire.dropdown-statistics', [
            'selectedOptions' => $this->options[$this->selectedCategory],
        ]);
    }

    public function selectCategory($category)
    {
        // Ako je trenutna kategorija otvorena, zatvori je; inače otvori
        $this->isOpen = $this->selectedCategory === $category ? !$this->isOpen : true;
        $this->selectedCategory = $category;
    }
}
