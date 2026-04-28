@extends('admin.layout')

@section('title', 'Admin Order Management | FLEUR')

@section('content')
<div class="admin-page">
    <div class="admin-header">
        <div>
            <h1>Admin Order Management</h1>
            <p class="admin-page-header">Manage incoming orders, update statuses, and track customer purchases.</p>
        </div>
    </div>

    <div class="admin-filters" style="margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 10px;">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary {{ request('status') ? '' : 'active' }}">All</a>
        @foreach(\App\Models\Order::statuses() as $status => $label)
            <a href="{{ route('admin.orders.index', ['status' => $status]) }}" class="btn btn-secondary {{ request('status') === $status ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    @if(session('success'))
        <div class="form-success">{{ session('success') }}</div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->full_name }} ({{ $order->user->email }})</td>
                    <td>{{ $order->phone }}</td>
                    <td>&#8369;{{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ $order->statusLabel() }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td class="admin-actions">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">View</a>
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="post" class="inline-form">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                @foreach(\App\Models\Order::statuses() as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection