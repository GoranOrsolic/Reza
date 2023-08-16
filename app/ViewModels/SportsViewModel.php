<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use Carbon\Carbon;

class SportsViewModel extends ViewModel
{
    public $sports;
    public $categories;

    public function __construct($sports, $categories)
    {
        $this->sports = $sports;
        $this->categories = $categories;

    }

    public function sports()
    {
        return $this->sports;
    }
/*
    public function categories()
    {
        $cats = collect($this->categories)->sortBy('name');
        return collect($cats);

    }*/
}
