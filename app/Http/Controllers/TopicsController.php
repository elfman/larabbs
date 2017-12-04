<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
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

	public function index(Request $request, Topic $topic)
	{
		$topics = $topic->withOrder($request->order)->paginate(30);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
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
		return redirect()->route('topics.show', $topic->id)->with('success', '成功创建新话题！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('success', '更新成功！');
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
}