<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class FootballViewModel extends ViewModel
{

    public $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
    }







}
