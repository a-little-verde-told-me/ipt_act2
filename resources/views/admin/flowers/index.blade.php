@extends('admin.layout')

@section('title', 'Admin Flower Management | FLEUR')

@section('content')
<div class="admin-page">
    <div class="admin-header">
        <div>
            <h1>Admin Flower Management</h1>
            <p class="admin-page-header">Maintain your flower collection with fast updates for names, colors, and image references.</p>
        </div>
        <a href="{{ route('admin.flowers.create') }}" class="btn btn-primary">Add Flower</a>
    </div>

    @if(session('success'))
        <div class="form-success">{{ session('success') }}</div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Color</th>
                <th>Image URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($flowers as $flower)
                <tr>
                    <td>{{ $flower->name }}</td>
                    <td>{{ $flower->color ?? '—' }}</td>
                    <td>{{ $flower->image ?? '—' }}</td>
                    <td class="admin-actions">
                        <a href="{{ route('admin.flowers.edit', $flower) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('admin.flowers.destroy', $flower) }}" method="post" onsubmit="return confirm('Delete this flower?');" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No flowers found. Use Add Flower to create a new entry.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection