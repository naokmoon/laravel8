<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(CommentRequest $request, BlogPost $post)
    {
        //Comment::create()
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        Mail::to($post->user)->send(
            new CommentPostedMarkdown($comment)
        );

        return redirect()->back()->with('status', 'Comment was created!');
    }
}
