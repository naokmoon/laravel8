@extends('layouts.app')

@section('title',  'Blog Posts')

@section('content')
    <h2>Posts</h2>

    <a href="{{ route('posts.create') }}" class="btn btn-success mb-2"><i class="fa fa-plus"></i> Create post</a>

    <div class="row">
        {{-- <div class="col-8">
            @if (count($posts) > 0)
            <table class="table table-sm table-striped">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Content</th>
                <th>Nb. Comments</th>
                <th>Created at</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            @each('posts.partials.post', $posts, 'post')
            </table>
        @else
            <br>No blog posts yet!
        @endif
        </div> --}}

        <div class="col-8">
            @forelse ($posts as $post)
                <p>
                    <h3>
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                    </h3>

                    <p class="text-muted">
                        Added {{ $post->created_at->diffForHumans() }}
                        by {{ $post->user->name }}
                    </p>

                    @if($post->comments_count)
                        <p>{{ $post->comments_count }} comments</p>
                    @else
                        <p>No comments yet!</p>
                    @endif

                    <div class="d-flex">
                        @can('update', $post)
                            <a href="{{ route('posts.edit', ['post' => $post->id]) }}"
                                class="btn btn-sm btn-primary">
                                Edit
                            </a>
                        @endcan

                        {{-- @cannot('delete', $post)
                            <p>You can't delete this post</p>
                        @endcannot --}}

                        @can('delete', $post)
                            <form method="POST" class="fm-inline ml-2"
                                action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                @csrf
                                @method('DELETE')

                                <input type="submit" onclick="confirmDelete()" value="Delete" class="btn btn-sm btn-danger"/>
                            </form>
                        @endcan
                    </div>
                </p>
            @empty
                <p>No blog posts yet!</p>
            @endforelse
        </div>
        <div class="col-4">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Most Commented</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        What people are currently talking about
                    </h6>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($mostCommented as $post)
                        <li class="list-group-item">
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                {{ $post->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>



        {{-- @forelse ($posts as $key => $post)
            @include('posts.partials.post')
        @empty
            No blog posts yet!
        @endforelse --}}

    </div>
    {{-- JS --}}
    <script>
        function confirmDelete() {
            if (!confirm("Are you sure to delete this?")) {
                event.preventDefault();
            }
        }
    </script>
@endsection



