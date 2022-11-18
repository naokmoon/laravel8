@extends('layouts.app')

@section('title', 'Create post')

@section('content')
    <h2>Create Blog Post</h2>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        @include('posts._form')

        <div class="d-flex">
            <input type="submit" value="Create" class="btn btn-success btn-xs-block">
            {{-- <div class="ml-2">
                <a href="{{ route('posts.index') }}" class="btn btn-light">Cancel</a>
            </div> --}}
        </div>
    </form>
@endsection
