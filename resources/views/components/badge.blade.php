@if (!isset($show) || $show)
    <div class="badge badge-{{ $type ?? 'success' }}">
        {{ $slot }}
    </div>
@endif
