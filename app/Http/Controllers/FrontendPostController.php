<?php

namespace App\Http\Controllers;

use App\Models\Post;

class FrontendPostController extends Controller
{
    //

    public function show(Post $post)
    {
        $post->load(['comments' => function ($query) {
            $query->whereNull('parent_id')
                ->with(['user', 'children.user', 'children.parent.user', 'children.children.user', 'children.children.parent.user']);
        }]);

        return view('frontend.post', compact('post'));
    }
}
