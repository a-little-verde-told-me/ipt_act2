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
    const cartKey = 'fleur_cart';
    const subtotalEl = document.getElementById('checkoutSubtotal');
    const shippingEl = document.getElementById('checkoutShipping');
    const totalEl = document.getElementById('checkoutTotal');

    function getCart() {
        try {
            return JSON.parse(localStorage.getItem(cartKey)) || [];
        } catch (e) {
            return [];
        }
    }

    function formatPrice(value) {
        return `₱ ${value.toFixed(2)}`;
    }

    function updateSummary() {
        const cart = getCart();
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const shipping = cart.length ? 150 : 0;
        subtotalEl.textContent = formatPrice(subtotal);
        shippingEl.textContent = formatPrice(shipping);
        totalEl.textContent = formatPrice(subtotal + shipping);
    }

    updateSummary();
</script>
@endsection
