<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\Upvote;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic, User $user, Link $link)
	{
		$topics = $topic->withOrder($request->order)->paginate(30);
		$active_users = $user->getActiveUsers();
		$links = $link->getAllCached();
		return view('topics.index', compact('topics', 'active_users', 'links'));
	}

    public function show(Request $request, Topic $topic)
    {
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        Topic::where('id', $topic->id)->update(['view_count' => $topic->view_count + 1]);
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
	    $topic->fill($request->all());
	    $topic->user_id = Auth::id();
	    $topic->save();
		return redirect()->to($topic->link())->with('success', '成功创建新话题！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
	    $this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功！');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $data = [
            'errno' => -1,
            'data' => [],
        ];

        if ($file = $request->upload_images) {
            $files = $request->file('upload_images');

            foreach($files as $file) {
                $result = $uploader->save($file, 'topics', Auth::id(), 1024);

                if ($result) {
                    array_push($data['data'], [$result['path']]);
                } else {
                    return [
                        'errno' => -1,
                    ];
                }
            }
            $data['errno'] = 0;
        }
        return $data;
	}

    public function vote(Request $request, Topic $topic)
    {
        $user = Auth::user();
        $action = $request->action;
        $hasVote = Upvote::where('topic_id', $topic->id)->where('user_id', $user->id)->first() != null;
        if ($action == 'upvote' && !$hasVote) {
//            Topic::find($topic->id)->update(['upvote_count' => $topic->upvote_count + 1]);
            $topic->upvote_count++;
            $topic->save();
            Upvote::create([
                'topic_id' => $topic->id,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'err' => 0,
            ]);
        } else if ($action == 'unvote' && $hasVote) {
            $topic->upvote_count--;
            $topic->save();
            Upvote::where('topic_id', $topic->id)->where('user_id', $user->id)->delete();

            return response()->json([
                'err' => 0,
            ]);
        } else {
            return response()->json([
                'err' => 1,
                'msg' => 'user ' . ($hasVote ? 'has voted' : 'has not vote') . ' this topic',
            ]);
        }
	}
}