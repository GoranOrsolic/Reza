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
    public $page;

    public function __construct($dat, $base64, $transfers, $tournaments, $players, $eventsNext, $eventsLast, $page)
    {
        $this->dat = $dat;
        $this->base64 = $base64;
        $this->transfers = $transfers;
        $this->tournaments = $tournaments;
        $this->players = $players;
        $this->eventsNext = $eventsNext;
        $this->eventsLast = $eventsLast;
        $this->page = $page;
    }


    public function previous()
    {
        return $this->page > 0 ? $this->page - 1 : null;
    }

    public function next()
    {
        return $this->page < 50 ? $this->page + 1 : null;
    }
}
