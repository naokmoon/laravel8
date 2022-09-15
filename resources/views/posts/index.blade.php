@extends('layouts.app')

@section('title',  'Blog Posts')

@section('content')
    <h2>Liste des posts</h2>

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-2">Add a blog post</a>

    <table class="table table-sm table-striped">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Content</th>
            <th></th>
            <th></th>
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

<script>
    function confirmDelete() {
        if (!confirm("Are you sure to delete this?")) {
            event.preventDefault();
        }
    }
</script>

