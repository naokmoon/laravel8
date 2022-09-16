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

    <a href="{{ route('posts.index') }}" class="btn btn-primary mt-4">Go back</a>
@endsection
