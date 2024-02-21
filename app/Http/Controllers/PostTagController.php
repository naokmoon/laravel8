<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    
    /**
     * Retrieves and displays a list of blog posts associated with a specific tag.
     *
     * @param int $tag The ID of the tag.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the tag is not found.
     * @return \Illuminate\View\View The view that displays the list of blog posts.
     */
    public function index($tag)
    {
        $tag = Tag::findOrFail($tag);

        return view('posts.index', ['posts' => $tag->blogPosts->latestWithRelations()->get()]);
    }
}
