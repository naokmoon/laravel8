<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //########## NOTES #####################################################
        // MAGIC WAY !!!
        // 1. Run cmd: "php artisan make:policy BlogPostPolicy --model=BlogPost"
        // 2. Add this to $policies array:
        //       'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy'
        //
        // 3. Config. BlogPostPolicy.php for each functions needed to use a policy.
        // ex: Allow logged user to delete only his own blog posts
        //     --------------------------------------------------------------
        //      public function delete(User $user, BlogPost $blogPost)
        //      {
        //          return $user->id == $blogPost->user_id;
        //      }
        //
        // 4. In BlogPostController.php, simply call $this->authorize($post) like this example:
        //      public function destroy($id)
        //      {
        //          $post = BlogPost::findOrFail($id);
        //          $this->authorize($post); //<--- Check user autorization MAGIC-WAY!
        //          $post->delete();
        //          session()->flash('status', 'The blog post #' . $id . ' was deleted!');
        //          return redirect()->route('posts.index');
        //      }
        //######################################################################

        //-------------- BASIC WAY to define a Gate -------------------------------------------------
        Gate::define('home.secret', function ($user) {
            return $user->is_admin;
        });

        // Gate::define('module.paysafe.admin', function ($user) {
        //     return $user->role->id == 1;
        // });

        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        // Gate::define('delete-post', function ($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        //------------- ANOTHER WAY USING php artisan make:policy --model=BlogPost ---------------
        // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');
        // Gate::resource('posts', 'App\Policies\BlogPostPolicy'); // posts.create, posts.view,
                                                                   // posts.update, posts.delete

        /**
         * This function is called before checkup of a Gate Definition.
         */
        Gate::before(function ($user, $ability) {
            // Admin users are autorized to ByPass these specific Gate abilities by returning true.
            if ($user->is_admin && in_array($ability, ['update', 'delete'])) {
                return true;
            }
        });

        // /**
        //  * This function is called after checkup of a Gate Definition.
        //  */
        // Gate::after(function ($user, $ability, $result) {
        //     //
        // });
    }
}
