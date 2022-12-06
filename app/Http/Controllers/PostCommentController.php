<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\CommentRequest;
use App\Models\BlogPost;
use App\Http\Resources\Comment as CommentResource;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post)
    {
        return CommentResource::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();
    }

    public function store(CommentRequest $request, BlogPost $post)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        event(new CommentPosted($comment));

        // MOVED TO Listener "NotifyUsersAboutComment" instead
            // Mail::to($post->user)->send(
            //     new CommentPostedMarkdown($comment)
            // );
            // Mail::to($post->user)->queue(
            //     new CommentPostedMarkdown($comment)
            // );

            // ThrottledMail::dispatch(new CommentPostedMarkdown($comment), $post->user)
            //     ->onQueue('high');

            // NotifyUsersPostWasCommented::dispatch($comment)
            //     ->onQueue('low');

        // $when = now()->addMinutes(1);
        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );

        return redirect()->back()->with('status', 'Comment was created!');
    }
}
