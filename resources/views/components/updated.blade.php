<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added ' : $slot }} {{ $date->diffForHumans() }}
    @if (isset($by))
        by {{ $by }}
    @endif
</p>
