<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function repliesToJson($replies) {
    $replyList = $replies->map(function ($reply) {
        return replyToResponse($reply);
    });

    return json_encode($replyList);
}

function replyToResponse($reply, $user = null) {
    $result = [];
    $result['id'] = $reply['id'];
    $result['can_reply'] = Auth::check();
    $result['content'] = $reply['content'];
    $result['topic_id'] = $reply['topic_id'];
    $result['reply_url'] = route('replies.store');
    $result['user_id'] = $reply['user_id'];
    $result['username'] = $user ? $user->name : $reply['user']['name'];
    $result['avatar'] = $user ? $user->avatar : $reply['user']['avatar'];
    $result['user_url'] = route('users.show', $reply['user_id']);
    $result['number'] = $reply['number'];
    $result['created_at'] = (new Carbon($reply['created_at']))->diffForHumans();
    if (Auth::user()->can('destroy', $reply)) {
        $result['remove_url'] = route('replies.destroy', $reply['id']);
    }
    if ($reply['to_reply']) {
        $result['to_reply'] = $reply['to_reply'];
        $result['to_user_url'] = route('users.show', $reply['to_user_id']);
        $result['to_username'] = $reply['to_username'];
        $result['to_number'] = $reply['to_number'];
    }
    return $result;
}