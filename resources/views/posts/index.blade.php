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
                        @if ($post->trashed())
                            <del>
                        @endif

                        <a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>

                        @if ($post->trashed())
                            </del>
                        @endif
                    </h3>

                    {{-- <p class="text-muted">
                        Added {{ $post->created_at->diffForHumans() }}
                        by {{ $post->user->name }}
                    </p> --}}

                    @updated(['date' => $post->created_at, 'by' => $post->user->name])
                    @endupdated

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
                            @if ($post->trashed())
                                {{-- TODO add a restore button with confirm JS --}}
                                {{-- <form method="POST" class="fm-inline ml-2"
                                    action="{{ route('posts.restore', ['post' => $post->id]) }}">
                                    @csrf

                                    <input type="submit" onclick="confirmRestore()" value="Restore" class="btn btn-sm btn-success"/>
                                </form> --}}
                            @else
                                <form method="POST" class="fm-inline ml-2"
                                    action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <input type="submit" onclick="confirmDelete()" value="Delete" class="btn btn-sm btn-danger"/>
                                </form>
                            @endif
                        @endcan
                    </div>
                </p>
            @empty
                <p>No blog posts yet!</p>
            @endforelse
        </div>
        <div class="col-4">
            <div class="container">
                <div class="row">
                    @card(['title' => 'Most Commented',
                           'subtitle' => 'What people are currently talking about'])
                        @slot('items')
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        @endslot
                    @endcard
                </div>

                <div class="row mt-4">
                    @card(['title' => 'Most Active Users',
                           'subtitle' => 'Users with most posts written',
                           'items' => collect($mostActiveUsers)->pluck('name')])
                    @endcard
                </div>

                <div class="row mt-4">
                    @card(['title' => 'Most Active Users Last Month',
                           'subtitle' => 'Users with most posts written since last month',
                           'items' => collect($mostActiveUsersLastMonth)->pluck('name')])
                    @endcard
                </div>
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



