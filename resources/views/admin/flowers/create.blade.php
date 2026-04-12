@extends('admin.layout')

@section('title', 'Add Flower | FLEUR Admin')

@section('content')
<div class="admin-form-page">
    <div class="admin-header">
        <h1>Add Flower</h1>
        <a href="{{ route('admin.flowers.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    @if($errors->any())
        <div class="form-error">Please fix the errors below.</div>
    @endif

    <form action="{{ route('admin.flowers.store') }}" method="post" class="admin-form">
        @csrf

        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
        @error('name') <p class="field-error">{{ $message }}</p> @enderror

        <label for="color">Color</label>
        <input id="color" name="color" type="text" value="{{ old('color') }}">
        @error('color') <p class="field-error">{{ $message }}</p> @enderror

        <label for="image">Image URL</label>
        <input id="image" name="image" type="url" value="{{ old('image') }}">
        @error('image') <p class="field-error">{{ $message }}</p> @enderror

        <button type="submit" class="btn btn-primary">Create Flower</button>
    </form>
</div>
@endsection