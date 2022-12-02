<?php

namespace App\Http\Controllers;

use App\Events\BlogPostPosted;
use App\Facades\CounterFacade;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

// Mapping of Controller method and Policy name used for user authorization when using $this->authorize($post)
// [
//     'show' => 'view',
//     'create' => 'create',
//     'store' => 'create',
//     'edit' => 'update',
//     'update' => 'update',
//     'destroy' => 'delete',
// ]
class PostController extends Controller
{
    private $counter;

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
        // $this->middleware('locale'); // Not required, because this middleware is public to all Web Route in Kernel
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();
        // dd(DB::getQueryLog());

        return view('posts.index',
        [
            'posts' => BlogPost::latestWithRelations()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create'); // Using Gate::resource ... Could be activated...
        // $this->authorize('create'); // Simplifier ability name using registerPolicies()
        // $this->authorize($post); // Magic way using registerPolicies()
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // $this->authorize('posts.create'); // Using Gate::resource ... Could be activated...
        // $this->authorize('create'); // Simplifier ability name using registerPolicies()
        // $this->authorize($post); // Magic way using registerPolicies()

        // Validation from basic Request class object
        //
        //--- Basic way
        // $request->validate([
        //     'title' => 'bail|required|min:5|max:100',
        //     'content' => 'required|min:10'
        // ]);
        // $post = new BlogPost();  // * Can also use BlogPost::make();
        // $post->title = $request->input('title');
        // $post->content = $request->input('content');
        // $post->save();
        //--- Lazy way
        // $model = $request->validate([
        //     'title' => 'bail|required|min:5|max:100',
        //     'content' => 'required|min:10'
        // ]);
        // $post = BlogPost::create($model); // * Easier, but requires $fillable property to be setted

        // Validation from a new make:request PostRequest class object with a rules() function
        //
        $model = $request->validated();
        $model['user_id'] = $request->user()->id;

        //--- Basic way without $fillable property
        // $post = new BlogPost();
        // $post->title = $model['title'];
        // $post->content = $model['content'];
        // $post->save();
        //--- Lazy way
        $post = BlogPost::create($model); // * Easier, but requires $fillable property to be setted

        // Save thumbnail file
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->save(
                Image::make(['path' => $path])
            );
        }

        event(new BlogPostPosted($post));

        $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_if(!isset($this->posts[$id]), 404);

        // return view('posts.show', [
        //     'post' => BlogPost::with(['comments' => function ($query) {
        //         return $query->latest();
        //      }])->findOrFail($id)
        // ]);

        $blogPost = Cache::remember("blog-post-{$id}", 60, function() use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'image', 'comments.user')
                ->findOrFail($id);
        });

        // $counter = resolve(Counter::class);

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => CounterFacade::increment("blog-post-{$id}", ['blog-post']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post!");
        // }
        // $this->authorize('update-post', $post);
        // $this->authorize('posts.update', $post);
        // $this->authorize('update', $post); // Simplifier ability name using registerPolicies()
        $this->authorize($post); // Magic way using registerPolicies()

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post!");
        // }
        // $this->authorize('posts.update', $post);
        // $this->authorize('update', $post); // Simplifier ability name using registerPolicies()
        $this->authorize($post); // Simplest magic way using registerPolicies(), passing Model
                                 // guessing which policy to call and which method

        $model = $request->validated();
        $post->fill($model);

        // Save thumbnail file
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path; // Set new path to Model
                $post->image->save(); // Save new path into DB
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }

        $post->save();

        $request->session()->flash('status', 'The blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't delete this blog post!");
        // }
        // $this->authorize('posts.delete', $post);
        // $this->authorize('delete', $post); // Simplifier ability name using registerPolicies()
        $this->authorize($post); // Magic way using registerPolicies()

        $post->delete();

        session()->flash('status', 'The blog post #' . $id . ' was deleted!');

        return redirect()->route('posts.index');

        // SHORT-HAND WAY! ->with('flash message');
        //
        // return redirect()->route('posts.index')->with('status', 'The blog post #' . $id . ' was deleted!');
    }

    /**
     * Restore the specified blog post (Manually added by jddumas)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post); // TO TEST with dd() with restore() method from BlogPostPolicy

        $post->restore();

        session()->flash('status', 'The blog post #' . $id . ' has been restored!');

        return redirect()->route('posts.index');
    }
}
