<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\CommentRequest;
use App\Models\BlogPost;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }


    /**
     * Retrieves all comments for a given blog post.
     *
     * @param BlogPost $post The blog post object.
     * @return Illuminate\Database\Eloquent\Collection The collection of comments with user information.
     */
    public function index(BlogPost $post)
    {
        return $post->comments()->with('user')->get();
    }


    /**
     * Store a new comment for a blog post.
     *
     * @param CommentRequest $request The request object containing the comment data.
     * @param BlogPost $post The blog post the comment is for.
     * @return \Illuminate\Http\RedirectResponse The redirect response back to the previous page.
     */
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
