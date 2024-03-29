<tr>
    <td>{{ $post->id }}</td>
    <td>{{ $post->title }}</td>
    <td>{{ $post->content }}</td>
    <td>{{ $post->comments_count }}</td>
    <td>{{ $post->created_at->diffForHumans() }}</td>
    <td>
        <div>
            <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn btn-light"><i class="fa fa-eye" title="View"></i></a>
        </div>
    </td>
    <td>
        <div>
            @can('update', $post)
                <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary"><i class="fa fa-pencil" title="Edit"></i></a>
            @endcan
        </div>
    </td>
    <td>
        <div>
            {{-- @cannot('delete', $post)
                <p>You can't delete this post</p>
            @endcannot --}}

            @can('delete', $post)
                <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="confirmDelete()" class="btn btn-danger"><i class="fa fa-trash-o" title="Delete"></i></button>
                </form>
            @endcan
        </div>
    </td>
</tr>
