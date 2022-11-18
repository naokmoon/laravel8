<div class="mb-2 mt-2">
    @auth
        <form method="POST" action="{{ route('posts.comments.store', ['post' => $post->id]) }}">
            @csrf

            <div class="form-group">
                <textarea type="text" name="content" class="form-control"></textarea>
            </div>

            <div class="d-flex">
                <input type="submit" value="Add comment" class="btn btn-success btn-xs-block">
                {{-- <div class="ml-2">
                    <a href="{{ route('posts.index') }}" class="btn btn-light">Cancel</a>
                </div> --}}
            </div>
        </form>
    @else
        <a href="{{ route('login') }}">Sign-in</a> to post comments!
    @endauth
</div>
<hr/>

@errors @enderrors
