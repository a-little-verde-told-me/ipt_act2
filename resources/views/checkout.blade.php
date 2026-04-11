@extends('headerfooter')

@section('title', 'Checkout | FLEUR')

@section('content')
<div class="checkout-page">
    <h1 class="page-title">CHECKOUT</h1>

    <div class="checkout-header">
        <a href="{{ route('cart') }}" class="back-to-cart-btn">← Back to Cart</a>
    </div>

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
        </aside>
    </div>

    @if(!empty($success))
        <div class="success-overlay" id="successOverlay">
            <div class="success-card">
                <div class="success-icon">✓</div>
                <h2>Order Placed Successfully!</h2>
                <p>Thank you for your purchase. Your order has been confirmed.</p>
                <div class="success-actions">
                    <a href="{{ route('home') }}" class="success-btn btn-primary">Go to Home</a>
                    <a href="{{ route('product') }}" class="success-btn btn-secondary">Continue Browsing</a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    const userId = @json(auth()->id());
    const itemsUrl = @json(route('cart.items'));
    const subtotalEl = document.getElementById('checkoutSubtotal');
    const shippingEl = document.getElementById('checkoutShipping');
    const totalEl = document.getElementById('checkoutTotal');
    const fullNameInput = document.getElementById('fullName');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');

    function getCart() {
        try {
            return JSON.parse(localStorage.getItem(cartKey)) || [];
        } catch (e) {
            return [];
        }
    }

    function getSelectedItems() {
        try {
            return JSON.parse(localStorage.getItem('fleur_selected_items')) || [];
        } catch (e) {
            return [];
        }
    }

    function formatPrice(value) {
        return `₱ ${value.toFixed(2)}`;
    }

    function updateSummary() {
        const cart = getCart();
        const selectedItems = getSelectedItems();
        
        let subtotal = 0;
        cart.forEach((item, index) => {
            if (selectedItems.includes(index)) {
                subtotal += item.price * item.qty;
            }
        });
        
        const shipping = subtotal > 0 ? 150 : 0;
        subtotalEl.textContent = formatPrice(subtotal);
        shippingEl.textContent = formatPrice(shipping);
        totalEl.textContent = formatPrice(subtotal + shipping);
    }

    function prefillUserDetails() {
        const userData = @json($user);
        if (userData && userData.id) {
            if (userData.name && !fullNameInput.value) fullNameInput.value = userData.name;
            if (userData.mobile && !phoneInput.value) phoneInput.value = userData.mobile;
            if (userData.address && !addressInput.value) addressInput.value = userData.address;
        }
    }

    prefillUserDetails();
    updateSummary();

    // Handle form submission to remove ordered items from cart
    const checkoutForm = document.querySelector('.checkout-form');
    const successOverlay = document.getElementById('successOverlay');
    
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get current cart and selected items
            const cart = getCart();
            const selectedItems = getSelectedItems();
            
            // Remove selected items from cart (in reverse order to maintain indices)
            for (let i = selectedItems.length - 1; i >= 0; i--) {
                const index = selectedItems[i];
                if (cart[index]) {
                    cart.splice(index, 1);
                }
            }
            
            // Save updated cart and clear selected items
            localStorage.setItem(cartKey, JSON.stringify(cart));
            localStorage.removeItem('fleur_selected_items');
            
            // Submit the form
            this.submit();
        });
    }
</script>
@endsection
