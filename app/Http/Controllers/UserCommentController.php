<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }


    /**
     * Store a new comment.
     *
     * @param CommentRequest $request The request object containing the comment details.
     * @param User $user The user who is creating the comment.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with a success message.
     */
    public function store(CommentRequest $request, User $user)
    {
        //Comment::create()
        $user->commentsOn()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        return redirect()->back()
            ->withStatus('Comment was created!');
    }
}
