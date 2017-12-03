<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Request $request, Category $category, Topic $topic)
    {
        $topics = $topic->where('category_id', $category->id)
            ->withOrder($request->order)
            ->paginate(20);

        return view('topics.index', compact('topics', 'category'));
    }
}
