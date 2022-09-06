@extends('layouts.app')

@section('title', 'Create post')

@section('content')
    <h2>Create Blog Post</h2>

    <form action="{{ route('posts.store') }}" method="POST">
        <div>
            Title:
            <input type="text" name="title">
        </div>
        <div>
            Content:
            <textarea name="content"></textarea>
        </div>
        <div>
            <input type="submit" value="Create">
        </div>
    </form>
@endsection
