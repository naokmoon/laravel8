@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url() : '' }}"
                 class="img-thumbnail avatar" />
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>

            <p>{{ trans_choice('messages.people.reading', $counter) }}</p>

            @errors @enderrors

            {{-- Add comment to user profile --}}
            @commentForm(['route' => route('users.comments.store', ['user' => $user->id])])
            @endcommentForm()
            {{-- Show list of comments --}}
            @commentList(['comments' => $user->commentsOn])
            @endcommentList
        </div>
    </div>
@endsection
