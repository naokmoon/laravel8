<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added ' : $slot }} {{ $date->diffForHumans() }}
    @if (isset($by))
        @if (isset($userId))
            by <a href="{{ route('users.show', ['user' => $userId]) }}">{{ $by }}</a>
        @else
            by {{ $by }}
        @endif
    @endif
</p>
