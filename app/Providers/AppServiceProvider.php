<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use App\Services\Counter;
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

        // View Composers
        // view()->composer('*', ActivityComposer::class); // Can pass to all view
        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);

        // Observers
        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);

        // Service Containers / Dependency Injections (for Controller Constructors by example)
        $this->app->singleton(Counter::class, function ($app) {
            return new Counter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                env('COUNTER_TIMEOUT')
            );
        });
            // or ->bind for new Instance() every time it's called

        $this->app->bind(
            'App\Contracts\CounterContract',
            Counter::class
        );

        // $this->app->when(Counter::class)
        //     ->needs('$timeout')
        //     ->give(env('COUNTER_TIMEOUT'));

        // Schema::defaultStringLength(191);
    }
}
