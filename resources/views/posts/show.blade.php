@extends('layouts.app')

@section('title', 'Post ' . $post->title)

@section('content')
    <style>
        #formImageDelete {
            position: absolute;
            top: 0;
            right: 0;
            margin-right: 15px;
            /* z-index: 1; */
        }
    </style>

    <div class="row">
        <div class="col-8">
            @if ($post->image)
            <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment:fixed;">
                <h1 style="padding-top: 100px; text-shadow: 1px 2px #000;">
            @else
                <h1>
            @endif

            <h1>
                {{ $post->title }}
                @badge(['show' => now()->diffInMinutes($post->created_at) < 30])
                    Brand new Post!
                @endbadge
            </h1>

            @if ($post->image)
                </h1>

                @can('delete', $post->image)
                    <form id="formImageDelete" action="{{ route('posts.image.destroy', ['post' => $post->id, 'image' => $post->image->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="confirmDelete()" class="btn btn-danger"><i class="fa fa-trash-o" title="Delete"></i></button>
                    </form>
                @endcan
            </div>
            @else
                </h1>
            @endif

            <p>{{ $post->content }}</p>

            {{-- <img src="{{ $post->image->url() }}" /> --}}

            {{-- <p>Added {{ $post->created_at->diffForHumans() }}</p> --}}
            @updated(['date' => $post->created_at, 'by' => $post->user->name])
            @endupdated

            @updated(['date' => $post->updated_at])
                Updated
            @endupdated

            @tags(['tags' => $post->tags])
            @endtags



            <p>Currently read by {{ $counter }} people</p>

            <h4>Comments</h4>

            @include('comments._form')

            @forelse ($post->comments as $comment)
                <p class="m-1">{{ $comment->content }}</p>
                {{-- <p class="text-muted">added {{ $comment->created_at->diffForHumans() }}</p> --}}
                @updated(['date' => $comment->created_at, 'by' => $comment->user->name])
                @endupdated
            @empty
                <p>No comments yet!</p>
            @endforelse
        </div>

        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>


    <a href="{{ route('posts.index') }}" class="btn btn-primary mt-4">Go back</a>

    <script>
        function confirmDelete() {
            if (!confirm("Are you sure to delete this?")) {
                event.preventDefault();
            }
        }
    </script>
@endsection
