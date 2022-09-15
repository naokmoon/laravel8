<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index', ['posts' => BlogPost::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
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

        // Validation from a new make:request StorePost class object with a rules() function
        //
        $model = $request->validated();
        //--- Basic way without $fillable property
        // $post = new BlogPost();
        // $post->title = $model['title'];
        // $post->content = $model['content'];
        // $post->save();
        //--- Lazy way
        $post = BlogPost::create($model); // * Easier, but requires $fillable property to be setted

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

        return view('posts.show', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $model = $request->validated();
        $post->fill($model);
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
        $post->delete();

        session()->flash('status', 'The blog post #' . $id . ' was deleted!');

        return redirect()->route('posts.index');
    }
}
