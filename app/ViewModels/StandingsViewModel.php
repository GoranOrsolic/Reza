<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class StandingsViewModel extends ViewModel
{
    public $standings;
    public $nextEvents;
    public $pastEvents;
    public $base64;

    public function __construct($standings, $nextEvents, $pastEvents, $base64)
    {
        $this->standings = $standings;
        $this->nextEvents = $nextEvents;
        $this->pastEvents = $pastEvents;
        $this->base64 = $base64;

    }
}
