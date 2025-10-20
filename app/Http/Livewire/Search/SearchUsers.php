<?php

namespace App\Http\Livewire\Search;

use Livewire\Component;
use App\Models\User;

class SearchUsers extends Component
{
    public $term;
    public $users;
    public function updatedTerm(){
        $this->users = User::where('name', 'like', '%' . $this->term . '%')
            ->whereNotIn('role_id', [3])
            ->get()
            ->toArray();
    }
    public function render()
    {
        return view('livewire.search.search-users');
    }
}
