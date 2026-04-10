@extends('headerfooter')

@section('title', 'Checkout | FLEUR')

@section('content')
<div class="checkout-page">
    <h1>CHECKOUT</h1>

    <div class="checkout-layout">
        <form class="checkout-form" action="{{ route('checkout.submit') }}" method="post">
            @csrf
            <h3>Shipping Details</h3>

            <label for="fullName">Full Name</label>
            <input id="fullName" type="text" required>

            <label for="phone">Mobile Number</label>
            <input id="phone" type="text" required>

            <label for="address">Address</label>
            <textarea id="address" rows="3" required></textarea>

            <label for="notes">Order Notes</label>
            <textarea id="notes" rows="3"></textarea>

            <button type="submit" class="submit-btn">Place Order</button>
        </form>

        <aside class="checkout-summary">
            <h3>Order Summary</h3>
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="checkoutSubtotal">₱ 0.00</span>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span id="checkoutShipping">₱ 0.00</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="checkoutTotal">₱ 0.00</span>
            </div>
            <a href="{{ route('cart') }}" class="continue-link">Back to Cart</a>
        </aside>
    </div>

    @if(!empty($success))
        <p style="margin-top:16px; text-align:center;">Order submitted successfully.</p>
    @endif
</div>

<script>
    const userId = @json(auth()->id());
    const itemsUrl = @json(route('cart.items'));
    const subtotalEl = document.getElementById('checkoutSubtotal');
    const shippingEl = document.getElementById('checkoutShipping');
    const totalEl = document.getElementById('checkoutTotal');

    function formatPrice(value) {
        return `₱ ${value.toFixed(2)}`;
    }

    function updateSummary(data) {
        subtotalEl.textContent = formatPrice(data.subtotal || 0);
        shippingEl.textContent = formatPrice(data.shipping || 0);
        totalEl.textContent = formatPrice(data.total || 0);
    }

    if (userId) {
        fetch(itemsUrl, { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(updateSummary)
            .catch(() => updateSummary({}));
    } else {
        updateSummary({});
    }
</script>
@endsection
