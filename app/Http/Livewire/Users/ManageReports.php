<?php

namespace App\Http\Livewire\Users;

use App\Models\Report;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;

class ManageReports extends Component
{
    use WithPagination;

    public function mount()
    {

    }

    public function render()
    {
        $reports = Report::with(['reporter', 'reported' => function ($query) {
            $query->select(['id', 'name', 'username', 'email', 'profile_photo_path','role_id']);
        },
        ])->where('solved', false)->latest()->paginate(10);

        return view('livewire.users.manage-reports', [
            'reports' => $reports,
        ]);
    }
    public function solveReport($reportId)
    {
        $report = Report::findOrFail($reportId);
        $report->update(['solved' => true]);
    }

    public function banUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['role_id' => 3]);
    }

    public function unbanUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['role_id' => 1]);
    }
}
