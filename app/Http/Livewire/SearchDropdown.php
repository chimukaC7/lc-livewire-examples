<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search;
    public $searchResults = [];

    //hook
    public function updatedSearch($newValue)
    {
        //don't want to make a request unless there are atleast three characters
        if (strlen($this->search) < 3) {
            $this->searchResults = [];

            return;
        }

        $response = Http::get('https://itunes.apple.com/search/?term=' . $this->search . '&limit=10');

        //dd($response->json());

        $this->searchResults = $response->json()['results'];
    }

    public function render()
    {
        return view('livewire.search-dropdown');
    }
}
