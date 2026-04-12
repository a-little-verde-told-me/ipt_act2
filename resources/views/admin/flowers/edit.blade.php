@extends('admin.layout')

@section('title', 'Edit Flower | FLEUR Admin')

@section('content')
<div class="admin-form-page">
    <div class="admin-header">
        <div>
            <h1>Edit Flower</h1>
            <p class="admin-subtext">Update the flower's display details and image to keep the collection fresh.</p>
        </div>
        <a href="{{ route('admin.flowers.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    @if($errors->any())
        <div class="form-error">Please fix the errors below.</div>
    @endif

    <form action="{{ route('admin.flowers.update', $flower) }}" method="post" class="admin-form">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $flower->name) }}" required>
        @error('name') <p class="field-error">{{ $message }}</p> @enderror

        <label for="color">Color</label>
        <input id="color" name="color" type="text" value="{{ old('color', $flower->color) }}">
        @error('color') <p class="field-error">{{ $message }}</p> @enderror

        <label for="image">Image URL</label>
        <input id="image" name="image" type="text" value="{{ old('image', $flower->image) }}" placeholder="e.g. flowers/red-tulips.jpg">
        @error('image') <p class="field-error">{{ $message }}</p> @enderror

        <button type="submit" class="btn btn-primary">Update Flower</button>
    </form>
</div>
@endsection