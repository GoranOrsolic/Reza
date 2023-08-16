<?php

namespace App\ViewModels;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Spatie\ViewModels\ViewModel;

class LogoViewModel extends ViewModel
{
    public $tournaments;
   // public $logo;

    public function __construct($tournaments)
    {
        $this->tournaments = $tournaments;

    }

    public function tournaments()
    {
        return $this->tournaments;
    }

    /*public function logo()
    {
        return $this->logo;
    }*/



    /*public function logo(){

        $cas = collect($this->categories)->pluck('uniqueId');


            $alo = Http::withHeaders([
                'X-RapidAPI-Key' => 'f32ac452fdmsh3b0417631c5f578p161c3djsnf2b70d6336d2',
                'X-RapidAPI-Host' => 'sofascores.p.rapidapi.com',
                'unique_tournament_id' => $cas,
            ])
                ->get('https://sofascores.p.rapidapi.com/v1/unique-tournaments/logo?unique_tournament_id='.$cas)
                ->json('data');
            dd($alo);

    }*/
}



    /*public function categories()
    {
        return $this->for($this->categories);
    }*/

    /*public function for()
    {
        $cas = collect($this->categories)->pluck('uniqueId');
        //dd($castMovies);
        foreach ($cas as $logo){
            //dd($logo);

        return collect($this->categories)->merge([

            'uniqueId' => 'https://sofascores.p.rapidapi.com/v1/unique-tournaments/logo?unique_tournament_id='.$logo
            ]);
        dump($logo);
        }
    }*/

