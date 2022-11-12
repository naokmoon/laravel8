@extends('layouts.app')

@section('title', 'Post ' . $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    {{-- <p>Added {{ $post->created_at->diffForHumans() }}</p> --}}
    @updated(['date' => $post->created_at, 'by' => $post->user->name])
    @endupdated

    @updated(['date' => $post->updated_at])
        Updated
    @endupdated

    @badge(['show' => now()->diffInMinutes($post->created_at) < 30])
        New!
    @endbadge

    <h4>Comments</h4>

    @forelse ($post->comments as $comment)
        <p class="m-1">{{ $comment->content }}</p>
        {{-- <p class="text-muted">added {{ $comment->created_at->diffForHumans() }}</p> --}}
        @updated(['date' => $comment->created_at])
        @endupdated
    @empty
        <p>No comments yet!</p>
    @endforelse

    <a href="{{ route('posts.index') }}" class="btn btn-primary mt-4">Go back</a>
@endsection
