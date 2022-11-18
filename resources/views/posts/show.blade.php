@extends('layouts.app')

@section('title', 'Post ' . $post->title)

@section('content')
    <div class="row">
        <div class="col-8">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->content }}</p>
            {{-- <p>Added {{ $post->created_at->diffForHumans() }}</p> --}}
            @updated(['date' => $post->created_at, 'by' => $post->user->name])
            @endupdated

            @updated(['date' => $post->updated_at])
                Updated
            @endupdated

            @tags(['tags' => $post->tags])
            @endtags

            @badge(['show' => now()->diffInMinutes($post->created_at) < 30])
                New!
            @endbadge

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
@endsection
