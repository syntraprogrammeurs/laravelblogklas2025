<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // Create 3-5 main comments for each post
            Comment::factory(rand(3, 5))
                ->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ])
                ->each(function ($comment) use ($users) {
                    // Create 1-3 replies for each main comment
                    Comment::factory(rand(1, 3))
                        ->create([
                            'post_id' => $comment->post_id,
                            'user_id' => $users->random()->id,
                            'parent_id' => $comment->id,
                        ]);
                });
        }
    }
}
