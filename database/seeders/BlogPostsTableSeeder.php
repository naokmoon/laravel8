<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postsCount = (int)$this->command->ask('How many blog posts would you like?', 50);
        $users = \App\Models\User::all();

        \App\Models\BlogPost::factory($postsCount)->make()->each(function($post) use ($users) {
            $post->user_id = $users->random()->id; // Pige un user random et recupere son ID
            $post->save();
        });
    }
}

