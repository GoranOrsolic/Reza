<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class SeasonsViewModel extends ViewModel
{
    public $seasons;

    public function __construct($seasons)
    {
        $this->seasons = $seasons;
    }
}
