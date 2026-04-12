@extends('admin.layout')

@section('title', 'Admin Event Management | FLEUR')

@section('content')
<div class="admin-page">
    <div class="admin-header">
        <h1>Admin Event Management</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Add Event</a>
    </div>

    @if(session('success'))
        <div class="form-success">{{ session('success') }}</div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Slug</th>
                <th>Image URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->category }}</td>
                    <td>{{ $event->slug }}</td>
                    <td>{{ $event->image ?? '—' }}</td>
                    <td class="admin-actions">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="post" onsubmit="return confirm('Delete this event?');" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No events found. Use Add Event to create a new entry.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection