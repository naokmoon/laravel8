<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();

        if (0 === $tagCount) {
            $this->command->info('No tags found, skipping assigning tags to blog posts');
            return;
        }

        $howManyMin = (int)$this->command->ask('Minimum tags on blog post?', 0);
        $howManyMax = min((int)$this->command->ask('Maximum tags on blog post?', $tagCount), $tagCount);

        BlogPost::all()->each(function (BlogPost $post) use ($howManyMin, $howManyMax) {
            // Choose a random number of tags between Min/Max
            $take = random_int($howManyMin, $howManyMax);
            // Fetch Tags in Random Order and take the first X Tags found between a Min/Max value
            $tagIds = Tag::inRandomOrder()->take($take)->get()->pluck('id');
            // Attach from sync the Tag Ids found to the blog post
            $post->tags()->sync($tagIds);
        });
    }
}
