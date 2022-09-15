@extends('layouts.app')

@section('title', 'Update post')

@section('content')
    <h2>Update Blog Post</h2>

    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
        @csrf
        {{-- Use PUT for updating --}}
        @method('PUT')

        @include('posts.partials.form')
        <div>
            <input type="submit" value="Save">
        </div>
    </form>
@endsection
