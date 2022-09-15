        {{-- @break($key == 2) --}}
        {{-- @continue($key == 1) --}}


{{--
    @if($loop->even)
        <div>
    @else
        <div style="background-color: silver;">
    @endif --}}

    <tr>
        <td>{{ $post->id }}</td>
        <td>{{ $post->title }}</td>
        <td>{{ $post->content }}</td>
        <td>
            <div>
                <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete">
                </form>
            </div>
        </td>
    </tr>

    {{-- </div> --}}
