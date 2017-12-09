<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Request $request, Category $category, Topic $topic, User $user)
    {
        $topics = $topic->where('category_id', $category->id)
            ->withOrder($request->order)
            ->paginate(20);

        $active_users = $user->getActiveUsers();

        return view('topics.index', compact('topics', 'category', 'active_users'));
    }
}
