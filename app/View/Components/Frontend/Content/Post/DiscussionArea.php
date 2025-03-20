<?php

namespace App\View\Components\Frontend\Content\Post;

use App\Models\Post;
use Illuminate\View\Component;

class DiscussionArea extends Component
{
    public function __construct(
        public Post $post
    ) {}

    public function render()
    {
        return view('components.frontend.content.post.discussion-area');
    }
}
