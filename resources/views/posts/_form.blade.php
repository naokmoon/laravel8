<div class="form-group">
    <label for="title">Title:</label>
    <input class="form-control" type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}" autofocus>
    {{-- @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror --}}
</div>

<div class="form-group">
    <label for="content">Content:</label>
    <textarea class="form-control" id="content" name="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>

<div class="form-group">
    <label for="thumbnail">Thumbnail:</label>
    <input class="form-control-file" type="file" name="thumbnail">
</div>

@errors @enderrors
