@extends('layouts.app')

@section('title', 'Update post')

@section('content')
    <h2>Update Blog Post</h2>

    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
        @csrf
        {{-- Use PUT for updating --}}
        @method('PUT')

        @include('posts.partials.form')

        <div class="d-flex mt-2">
            <input type="submit" value="Save" class="btn btn-primary">
            <div class="ml-2">
                <a href="{{ route('posts.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </div>
    </form>
@endsection
