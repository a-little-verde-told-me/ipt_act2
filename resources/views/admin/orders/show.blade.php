@extends('admin.layout')

@section('title', 'Order Details | FLEUR')

@section('content')
<div class="admin-page">
    <div class="admin-header">
        <div>
            <h1>Order #{{ $order->id }}</h1>
            <p class="admin-page-header">Order details and management</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>

    <div class="order-details">
        <div class="order-info">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->full_name }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            @if($order->notes)
                <p><strong>Notes:</strong> {{ $order->notes }}</p>
            @endif
        </div>

        <div class="order-status">
            <h3>Order Status</h3>
            <p><strong>Status:</strong>
                <span class="status-badge status-{{ $order->status }}">
                    {{ $order->statusLabel() }}
                </span>
            </p>
            <p><strong>Ordered on:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
            <p><strong>Last updated:</strong> {{ $order->updated_at->format('M d, Y H:i') }}</p>
        </div>

        <div class="order-items">
            <h3>Order Items</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if($item->image_url)
                                    <img src="{{ asset('images/' . $item->image_url) }}" alt="{{ $item->product_name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                @endif
                                {{ $item->product_name }}
                            </td>
                            <td>&#8369;{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>&#8369;{{ number_format($item->price * $item->qty, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="order-totals">
            <h3>Order Summary</h3>
            <p><strong>Subtotal:</strong> &#8369;{{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Shipping:</strong> &#8369;{{ number_format($order->shipping_cost, 2) }}</p>
            <p><strong>Total:</strong> &#8369;{{ number_format($order->total, 2) }}</p>
        </div>

        <div class="order-actions">
            <h3>Update Status</h3>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        @foreach(\App\Models\Order::statuses() as $key => $label)
                            <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection