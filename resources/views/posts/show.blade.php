@extends('layouts.app')

@section('title', 'Post ' . $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>Added {{ $post->created_at->diffForHumans() }}</p>

    @if (now()->diffInMinutes($post->created_at) < 5)
        <div class="alert alert-info" role="alert">
            <strong>New!</strong>
        </div>
    @endif

    <h4>Comments</h4>

    @forelse ($post->comments as $comment)
        <p class="m-1">{{ $comment->content }}</p>
        <p class="text-muted">added {{ $post->created_at->diffForHumans() }}</p>
    @empty
        <p>No comments yet!</p>
    @endforelse

    <a href="{{ route('posts.index') }}" class="btn btn-primary mt-4">Go back</a>
@endsection
