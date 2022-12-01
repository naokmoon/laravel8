<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Components
        Blade::aliasComponent('components.badge', 'badge');
        Blade::aliasComponent('components.updated', 'updated');
        Blade::aliasComponent('components.card', 'card');
        Blade::aliasComponent('components.tags', 'tags');
        Blade::aliasComponent('components.errors', 'errors');
        Blade::aliasComponent('components.comment_form', 'commentForm');
        Blade::aliasComponent('components.comment_list', 'commentList');

        // ViewComposers
        // view()->composer('*', ActivityComposer::class); // Can pass to all view
        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);

        // Observers
        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);

        // Schema::defaultStringLength(191);
    }
}
