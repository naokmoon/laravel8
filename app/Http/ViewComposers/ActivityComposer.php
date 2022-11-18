<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\Models\BlogPost;
use App\Models\User;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('mostCommented', 60, function () {
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActiveUsers = Cache::remember('mostActiveUsers', 60, function () {
            return User::withMostBlogPosts()->take(5)->get();
        });
        $mostActiveUsersLastMonth = Cache::remember('mostActiveUsersLastMonth', 60, function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('mostCommented', $mostCommented);
        $view->with('mostActiveUsers', $mostActiveUsers);
        $view->with('mostActiveUsersLastMonth', $mostActiveUsersLastMonth);
    }
}
