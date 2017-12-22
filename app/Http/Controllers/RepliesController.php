<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


	public function store(ReplyRequest $request, Reply $reply)
	{
	    $user = Auth::user();
	    $reply->content = $request->body;
	    $reply->user_id = $user->id;
	    $reply->topic_id = $request->topic_id;

	    if ($request->to_reply) {
	        $toReply = Reply::find($request->to_reply);
	        if (!$toReply) {
	            return response()->json([
	                'err' => 1,
                    'msg' => 'reply id not exist',
                ]);
            }

            $reply->to_reply = $request->to_reply;
            $reply->to_user_id = $toReply->user_id;
            $reply->to_username = User::find($toReply->user_id)->name;
            $reply->to_number = $toReply->number;
        }
	    $reply->save();
	    $data = replyToResponse($reply, $user);

		return response()->json([
		    'err' => 0,
            'reply' => $data,
        ]);
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return response()->json([
		    'err' => 0,
        ]);
	}
}