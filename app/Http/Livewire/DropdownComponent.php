<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class DropdownComponent extends Component
{
    public $categories;
    public $selectedCategories = [];
    public $tournaments = [];

    public function mount()
    {
        $this->categories = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
            'sport_id' => 1,
        ])->get('https://sofasport.p.rapidapi.com/v1/categories?sport_id=1')->json('data');

    }

    public function selectCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            $this->selectedCategories[] = $categoryId;
            $this->loadTournaments($categoryId);
        }
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            $this->selectedCategories[] = $categoryId;
            $this->loadTournaments($categoryId);
        }
    }

    public function loadTournaments($categoryId)
    {
        $tournaments = Http::withHeaders([
            'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
            'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com'
        ])->get('https://sofasport.p.rapidapi.com/v1/unique-tournaments?category_id=' . $categoryId)->json()['data'];

        $this->tournaments[$categoryId] = $tournaments;
    }

    public function render()
    {
        // Sortiranje $categories po abecednom redu
        usort($this->categories, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return view('livewire.dropdown-component');
    }
}
