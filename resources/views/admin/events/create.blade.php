@extends('admin.layout')

@section('title', 'Add Event | FLEUR Admin')

@section('content')
<div class="admin-form-page">
    <div class="admin-header">
        <div>
            <h1>Add Event</h1>
            <p class="admin-subtext">Create a new event listing with category and image details for the event gallery.</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    @if($errors->any())
        <div class="form-error">Please fix the errors below.</div>
    @endif

    <form action="{{ route('admin.events.store') }}" method="post" class="admin-form">
        @csrf

        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
        @error('name') <p class="field-error">{{ $message }}</p> @enderror

        <label for="category">Category</label>
        <input id="category" name="category" type="text" value="{{ old('category') }}" required>
        @error('category') <p class="field-error">{{ $message }}</p> @enderror

        <label for="image">Image URL</label>
        <input id="image" name="image" type="text" value="{{ old('image') }}" placeholder="e.g. products/pink-love-bouquet.webp">
        @error('image') <p class="field-error">{{ $message }}</p> @enderror

        <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
</div>
@endsection