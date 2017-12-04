<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class ReplyPolicy extends Policy
{
    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
