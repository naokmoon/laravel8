@extends('layouts.app')

@section('title', 'Create post')

@section('content')
    <h2>Create Blog Post</h2>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        @include('posts.partials.form')
        <div class="d-flex">
            <input type="submit" value="Create" class="btn btn-success btn-xs-block">
            <div class="ml-2">
                <a href="{{ route('posts.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </div>
    </form>
@endsection
