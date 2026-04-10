@extends('headerfooter')

@section('title', 'Add Product | FLEUR Admin')

@section('content')
<div class="admin-form-page">
    <div class="admin-header">
        <h1>Add Product</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    @if($errors->any())
        <div class="form-error">Please fix the errors below.</div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="post" class="admin-form">
        @csrf

        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
        @error('name') <p class="field-error">{{ $message }}</p> @enderror

        <label for="category">Category</label>
        <input id="category" name="category" type="text" value="{{ old('category') }}" required>
        @error('category') <p class="field-error">{{ $message }}</p> @enderror

        <label for="price">Price</label>
        <input id="price" name="price" type="number" step="0.01" value="{{ old('price') }}" required>
        @error('price') <p class="field-error">{{ $message }}</p> @enderror

        <label for="image_url">Image URL</label>
        <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}">
        @error('image_url') <p class="field-error">{{ $message }}</p> @enderror

        <label for="description">Description</label>
        <textarea id="description" name="description">{{ old('description') }}</textarea>
        @error('description') <p class="field-error">{{ $message }}</p> @enderror

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>
@endsection
