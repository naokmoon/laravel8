@forelse ($comments as $comment)
    <p class="m-1">
        {{ $comment->content }}
    </p>

    @tags(['tags' => $comment->tags])
    @endtags

    @updated(['date' => $comment->created_at, 'by' => $comment->user->name, 'userId' => $comment->user->id])
    @endupdated
@empty
    <p>No comments yet!</p>
@endforelse
