@extends('headerfooter')

@section('title', 'Order Status | FLEUR')

@section('content')
<div class="order-page">
    <div class="order-hero">
        <div>
            <h1>Track Your Orders</h1>
            <p>Review order details, shipment status, and delivery progress for all purchases.</p>
        </div>
        <a href="{{ route('product') }}" class="order-cta">Continue Shopping</a>
    </div>

    @if (session('success'))
        <div class="order-flash">
            {{ session('success') }}
        </div>
    @endif

    <div class="order-filters">
        <div class="filter-buttons">
            <a href="{{ route('order', ['status' => null]) }}" class="filter-pill {{ empty(request('status')) ? 'active' : '' }}">All</a>
            @foreach(\App\Models\Order::statuses() as $status => $label)
                <a href="{{ route('order', ['status' => $status]) }}" class="filter-pill {{ request('status') === $status ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>

    @if ($orders->count() > 0)
        @foreach($orders as $order)
            <div class="order-card order-full-card">
                <div class="order-card-grid">
                    <section class="order-section order-items-card">
                        <h2>Order items</h2>
                        <div class="order-items">
                            @foreach($order->items as $item)
                                <div class="order-item">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}" class="order-item-image">
                                    <div>
                                        <div class="order-item-title">{{ $item->product_name }}</div>
                                        <div class="order-item-qty">Qty: {{ $item->qty }}</div>
                                    </div>
                                    <div class="order-item-price">₱ {{ number_format($item->price * $item->qty, 2) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <aside class="order-section order-sidebar-card">
                        <h2>Shipping details</h2>
                        <div class="order-shipping-details">
                            <div><strong>Name:</strong> {{ $order->full_name }}</div>
                            <div><strong>Phone:</strong> {{ $order->phone }}</div>
                            <div><strong>Address:</strong> {{ $order->address }}</div>
                            @if ($order->notes)
                                <div><strong>Notes:</strong> {{ $order->notes }}</div>
                            @endif
                        </div>

                        <div class="order-totals">
                            <div class="order-total-row"><span>Subtotal</span><span>₱ {{ number_format($order->subtotal, 2) }}</span></div>
                            <div class="order-total-row"><span>Shipping</span><span>₱ {{ number_format($order->shipping_cost, 2) }}</span></div>
                            <div class="order-total-row total"><span>Total</span><span>₱ {{ number_format($order->total, 2) }}</span></div>
                        </div>

                        @if($order->status === 'delivered')
                            <form method="post" action="{{ route('order.received', $order) }}" class="received-form">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Mark as Received</button>
                            </form>
                        @endif
                    </aside>
                </div>

                @if($order->status === 'completed')
                    <div class="order-section order-rating-card">
                    <h2>Rate completed products</h2>
                    <div class="rating-card-group">
                        @foreach($order->items as $item)
                            @php
                                $product = $productsByName[$item->product_name] ?? null;
                                $alreadyRated = $product && in_array($item->id, $ratedOrderItemIds);
                            @endphp
                            <div class="rating-card">
                                <div class="rating-card-header">
                                    <div class="order-item">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}" class="order-item-image">
                                        <div>
                                            <div class="order-item-title">{{ $item->product_name }}</div>
                                            <div class="order-item-qty">Qty: {{ $item->qty }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rating-card-body">
                                    @if($product)
                                        @if($alreadyRated)
                                            <div class="rating-status">You already rated this product.</div>
                                        @else
                                            <form action="{{ route('order.rate', $order) }}" method="post" class="rating-form">
                                                @csrf
                                                <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                                                <div class="rating-control">
                                                    <label for="rating-{{ $item->id }}">Rating</label>
                                                    <select name="rating" id="rating-{{ $item->id }}" required>
                                                        <option value="">Choose</option>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="rating-control">
                                                    <label for="review-{{ $item->id }}">Review (optional)</label>
                                                    <textarea id="review-{{ $item->id }}" name="review" rows="3" placeholder="Share your thoughts..."></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit Rating</button>
                                            </form>
                                        @endif
                                    @else
                                        <div class="rating-status">This product is no longer available for rating.</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="order-card order-empty-card">
            <h2>No orders found</h2>
            <p>You haven’t placed an order yet. When you place one, it will appear here with tracking status and shipment details.</p>
            <a class="order-cta" href="{{ route('product') }}">Browse products</a>
        </div>
    @endif
</div>

<style>
    .order-filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin: 24px 0 8px;
    }

    .filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        border-radius: 999px;
        background: #f4eded;
        color: #5b3f43;
        text-decoration: none;
        font-weight: 600;
        border: 1px solid transparent;
        transition: background 0.2s ease, border-color 0.2s ease;
    }

    .filter-pill.active,
    .filter-pill:hover {
        background: #8d5660;
        color: #fff;
        border-color: #8d5660;
    }

    .filter-sort {
        min-width: 170px;
    }

    .order-full-card {
        padding: 0;
        border-radius: 30px;
        overflow: hidden;
    }

    .order-card-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 24px;
        padding: 2rem;
        background: #fff;
        border-bottom: 1px solid #f3e6e3;
    }

    .order-section {
        background: #fff8f6;
        border: 1px solid #f1e4df;
        border-radius: 24px;
        padding: 1.5rem;
    }

    .order-section h2 {
        margin-top: 0;
        margin-bottom: 1.2rem;
    }

    .order-sidebar-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .order-rating-card {
        background: #fff7f5;
        border: 1px solid #f1dedc;
        border-radius: 28px;
        padding: 26px;
        box-shadow: 0 16px 40px rgba(144, 107, 106, 0.08);
        margin-top: 24px;
    }

    .rating-card-group {
        display: grid;
        gap: 18px;
    }

    .rating-card {
        background: #ffffff;
        border: 1px solid #f1e2df;
        border-radius: 24px;
        overflow: hidden;
    }

    .rating-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #f2e3e0;
        background: #fffaf7;
    }

    .rating-card-body {
        padding: 20px 22px 22px;
    }

    .rating-form {
        display: grid;
        gap: 16px;
    }

    .rating-control {
        display: grid;
        gap: 8px;
    }

    .rating-control label {
        font-size: 0.95rem;
        color: #4f3b39;
        font-weight: 600;
    }

    .rating-control select,
    .rating-control textarea {
        width: 100%;
        border: 1px solid #e3d4cf;
        border-radius: 16px;
        background: #fbf5f3;
        color: #4f3b39;
        padding: 14px 16px;
        font-size: 0.98rem;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .rating-control select:focus,
    .rating-control textarea:focus {
        border-color: #caa9a5;
        box-shadow: 0 0 0 4px rgba(230, 202, 196, 0.3);
    }

    .rating-control textarea {
        min-height: 110px;
        resize: vertical;
    }

    .rating-status {
        color: #865657;
        background: #fff1f0;
        border: 1px solid #f2d8d7;
        border-radius: 18px;
        padding: 18px 20px;
        font-weight: 600;
    }

    .rating-card .btn-primary {
        width: fit-content;
        min-width: 160px;
        padding: 12px 22px;
        border-radius: 999px;
    }

    @media (max-width: 900px) {
        .order-card-grid {
            grid-template-columns: 1fr;
        }

        .order-card-grid,
        .order-section {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }

    @media (max-width: 760px) {
        .order-rating-card {
            padding: 20px;
        }

        .rating-card-header,
        .rating-card-body {
            padding-left: 16px;
            padding-right: 16px;
        }
    }
</style>
@endsection
