<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Chat $chat)
    {
        return $chat->user1_id === $user->id || $chat->user2_id === $user->id;
    }
}
