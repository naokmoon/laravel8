@extends('layouts.app')

@section('title', 'Create post')

@section('content')
    <h2>Create Blog Post</h2>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div>
            Title:
            <input type="text" name="title" value="{{ old('title') }}" autofocus>
            @error('title')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            Content:
            <textarea name="content">{{ old('content') }}</textarea>
        </div>
        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <input type="submit" value="Create">
        </div>
    </form>
@endsection
