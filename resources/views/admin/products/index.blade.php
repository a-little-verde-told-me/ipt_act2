@extends('admin.layout')

@section('title', 'Admin Product Management | FLEUR')

@section('content')
<div class="admin-page">
    <div class="admin-header">
        <h1>Admin Product Management</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
    </div>

    @if(session('success'))
        <div class="form-success">{{ session('success') }}</div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>&#8369;{{ number_format($product->price, 2) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($product->description, 60) }}</td>
                    <td>{{ $product->image_url ?? '—' }}</td>
                    <td class="admin-actions">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="post" onsubmit="return confirm('Delete this product?');" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No products found. Use Add Product to create your first item.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
