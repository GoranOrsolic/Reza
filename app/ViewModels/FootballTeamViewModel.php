<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class FootballTeamViewModel extends ViewModel
{
    public $dat;
    public $base64;
    public $transfers;
    public $tournaments;
    public $players;
    public $eventsNext;
    public $eventsLast;
    public $standings;
    public $teamLogos;
    public $tournamentId;
    public $seasonId;
    public $page;
    public $id;
    public $nextMatch;
    public $homeTeamLogoImg;
    public $awayTeamLogoImg;
    public $headTwoHeadStats;
    public $matchInfo;
    public $averageAge;
    public $logos;
    public  $playerPhotos;
    public $seasonStats;
    public $teamId;

    public function __construct($dat, $base64, $transfers, $tournaments, $players, $eventsNext, $eventsLast,
                                $standings, $teamLogos, $tournamentId, $seasonId, $page, $id, $nextMatch, $homeTeamLogoImg, $awayTeamLogoImg,
                                $headTwoHeadStats, $matchInfo, $averageAge, $logos, $playerPhotos, $seasonStats, $teamId)
    {
        $this->dat = $dat;
        $this->base64 = $base64;
        $this->transfers = $transfers;
        $this->tournaments = $tournaments;
        $this->players = $players;
        $this->eventsNext = $eventsNext;
        $this->eventsLast = $eventsLast;
        $this->standings = $standings;
        $this->teamLogos = $teamLogos;
        $this->tournamentId = $tournamentId;
        $this->seasonId = $seasonId;
        $this->page = $page;
        $this->id = $id;
        $this->nextMatch = $nextMatch;
        $this->homeTeamLogoImg = $homeTeamLogoImg;
        $this->awayTeamLogoImg = $awayTeamLogoImg;
        $this->headTwoHeadStats = $headTwoHeadStats;
        $this->matchInfo = $matchInfo;
        $this->averageAge = $averageAge;
        $this->logos = $logos;
        $this->playerPhotos = $playerPhotos;
        $this->seasonStats = $seasonStats;
        $this->teamId = $teamId;
    }

}
