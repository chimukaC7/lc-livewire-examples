<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DataTables extends Component
{
    use WithPagination;

    public $active = true;
    public $search;
    public $sortField;
    public $sortAsc = true;

    //the states that you want to keep track of in the query string
    //protected $queryString = ['search', 'active', 'sortAsc', 'sortField'];

    //Won't show 'search' in the query string if it is equal to '', and won't show active is if is equal to true.
    //what you want to keep track and share in a link
    public $queryString = [
        'search' => ['except' => ''],
        'active' => ['except' => true],
        'sortAsc',
        'sortField'
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {//if the same field is clicked on the second time(twice)
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;//reset sort asc to true
        }

        $this->sortField = $field;//set the sort field
    }

    //resetting the pagination as we search
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.data-tables', [
            //(A or B) and C
            'users' => User::where(function ($query) {//using a callback
                //searching
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })->where('active', $this->active)
                //sorting
                ->when($this->sortField, function ($query) {
                    $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                })->paginate(10),
        ]);
    }

    // public function paginationView()
    // {
    //     return 'livewire.custom-pagination-links-view';
    // }
}
