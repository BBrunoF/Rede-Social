<?php

namespace App\Http\Livewire\Profile;

use App\Models\Follower;
use App\Models\User;
use App\Models\Report;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ProfilePage extends Component
{
    public $user;
    public $followers;
    public $followersCount;
    public $followings;
    public $followingsCount;
    public $posts;
    public $isOpenReportModal = false;  // Ensure this is set to false initially
    public $postsCount;
    public $report;

    public function mount()
    {
        $this->postsCount = $this->user->posts_count;
        $this->followersCount = $this->user->followers_count;
        $this->followingsCount = $this->user->followings_count;
    }

    public function render()
    {
        return view('livewire.profile.profile-page');
    }

    public function incrementFollow(User $user)
    {
        Gate::authorize('is-not-user-profile', $this->user);

        $follow = Follower::where('following_id', Auth::id())
            ->where('follower_id', $user->id);

        if (! $follow->count()) {
            Follower::create([
                'following_id' => Auth::id(),
                'follower_id' => $user->id,
            ]);
        } else {
            $follow->delete();
        }

        return redirect()->route('profile', ['username' => $user->username]);
    }

    public function createReport($userId)
    {   
        $validatedData = Validator::make(
            ['report' => $this->report],
            ['report' => 'required|max:5000']
        )->validate();

        Report::create([
            'reporter_id' => Auth::id(),
            'reported_id' => $userId,
            'report_reason' => $validatedData['report'],
        ]);

        session()->flash('success', 'Report sent successfully');
    
        $this->report = '';

        $this->isOpenReportModal = false;
        
        return redirect()->back();
    }
}


