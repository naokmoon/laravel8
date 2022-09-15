@extends('layouts.app')

@section('title', 'Create post')

@section('content')
    <h2>Create Blog Post</h2>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        @include('posts.partials.form')
        <div>
            <input type="submit" value="Create">
        </div>
    </form>
@endsection
