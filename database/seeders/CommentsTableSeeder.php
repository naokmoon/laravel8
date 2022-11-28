<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = \App\Models\BlogPost::all();
        $users = \App\Models\User::all();

        if ($posts->count() === 0 || $users->count() === 0) {
            $this->command->info('There are no blog posts or users, so no comments will be added');
            return;
        }

        $commentsCount = (int)$this->command->ask('How many comments would you like?', 150);

        \App\Models\Comment::factory($commentsCount)->make()->each(function ($comment) use ($posts, $users) {
            $comment->commentable_id = $posts->random()->id; // Pige un post random et recupere son ID
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $users->random()->id; // Pige un user random et recupere son ID
            $comment->save();
        });

        \App\Models\Comment::factory($commentsCount)->make()->each(function ($comment) use ($users) {
            $comment->commentable_id = $users->random()->id; // Pige un post random et recupere son ID
            $comment->commentable_type = User::class;
            $comment->user_id = $users->random()->id; // Pige un user random et recupere son ID
            $comment->save();
        });
    }
}
