<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    public $search = '';
    private $users;

    public function render()
    {
        $this->users = User::withCount(['posts', 'followers', 'followings'])
                    ->when($this->search, function ($query) {
                        $query->where('username', 'like', '%' . $this->search . '%');
                    })
                    ->latest()
                    ->paginate(10);

        return view('livewire.users.index', [
            'users' => $this->users,
        ]);
    }
}
