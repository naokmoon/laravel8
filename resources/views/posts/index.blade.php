@extends('layouts.app')

@section('title',  'Blog Posts')

@section('content')
    <h2>Liste des posts</h2>

    <table class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Content</th>
            <th></th>
        </tr>
        @each('posts.partials.post', $posts, 'post')

        {{-- @forelse ($posts as $key => $post)
            @include('posts.partials.post')
        @empty
            No posts found!
        @endforelse --}}
    </table>
@endsection
