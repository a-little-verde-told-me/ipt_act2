@extends('headerfooter')

@section('title', 'Edit Product | FLEUR Admin')

@section('content')
<div class="admin-form-page">
    <div class="admin-header">
        <h1>Edit Product</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    @if($errors->any())
        <div class="form-error">Please fix the errors below.</div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="post" class="admin-form">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required>
        @error('name') <p class="field-error">{{ $message }}</p> @enderror

        <label for="category">Category</label>
        <input id="category" name="category" type="text" value="{{ old('category', $product->category) }}" required>
        @error('category') <p class="field-error">{{ $message }}</p> @enderror

        <label for="price">Price</label>
        <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" required>
        @error('price') <p class="field-error">{{ $message }}</p> @enderror

        <label for="image_url">Image URL</label>
        <input id="image_url" name="image_url" type="url" value="{{ old('image_url', $product->image_url) }}">
        @error('image_url') <p class="field-error">{{ $message }}</p> @enderror

        <label for="description">Description</label>
        <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
        @error('description') <p class="field-error">{{ $message }}</p> @enderror

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
