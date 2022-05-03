<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PollExample extends Component
{
    public $revenue;

    public function mount()
    {
        $this->revenue = $this->getRevenue();

        //You could just called the getRevenue() method in your mount() method
        //$this->getRevenue();
        //That would run that method and assign the revenue property without having to return anything.
    }

    public function getRevenue()
    {
        $this->revenue = DB::table('orders')->sum('price');

        return $this->revenue;
    }

    public function render()
    {
        return view('livewire.poll-example');
    }
}
