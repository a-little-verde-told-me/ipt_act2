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
            <input type="hidden" name="selected_items" id="selectedItemsInput" value="[]">
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

@php
    $userData = $user ?? null;
@endphp

<script>
    const userData = JSON.parse('@json($userData)');
</script>

<script>
    const selectedItemsKey = 'fleur_selected_items';
    const subtotalEl = document.getElementById('checkoutSubtotal');
    const shippingEl = document.getElementById('checkoutShipping');
    const totalEl = document.getElementById('checkoutTotal');
    const fullNameInput = document.getElementById('fullName');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    const notesInput = document.getElementById('notes');
    const selectedItemsInput = document.getElementById('selectedItemsInput');
    const checkoutForm = document.querySelector('.checkout-form');

    function loadSelectedItems() {
        try {
            return JSON.parse(localStorage.getItem(selectedItemsKey)) || [];
        } catch (e) {
            return [];
        }
    }

    function saveSelectedItems(items) {
        if (items.length > 0) {
            localStorage.setItem(selectedItemsKey, JSON.stringify(items));
        } else {
            localStorage.removeItem(selectedItemsKey);
        }
    }

    function formatPrice(value) {
        return `₱ ${value.toFixed(2)}`;
    }

    function refreshCartCount() {
        fetch('{{ route("api.cart.count") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cartCount');
            if (!badge) return;
            badge.textContent = data.count || 0;
            badge.style.display = (data.count || 0) > 0 ? 'inline-flex' : 'none';
        })
        .catch(() => {});
    }

    window.addEventListener('cart-updated', refreshCartCount);
    window.addEventListener('DOMContentLoaded', refreshCartCount);
    setTimeout(refreshCartCount, 100);
    setTimeout(refreshCartCount, 300);
    setTimeout(() => {
        if (window.refreshCartCount) {
            window.refreshCartCount();
        }
        refreshCartCount();
    }, 500);

    function fetchCart() {
        if (!userData || !userData.id) {
            return Promise.resolve([]);
        }

        return fetch('{{ route("api.cart.get") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.ok ? response.json() : [])
        .catch(() => []);
    }

    function updateSummary(cart) {
        const selectedItems = loadSelectedItems();
        let subtotal = 0;

        cart.forEach(item => {
            if (selectedItems.includes(item.id)) {
                subtotal += item.price * item.qty;
            }
        });

        const shipping = subtotal > 0 ? 150 : 0;
        subtotalEl.textContent = formatPrice(subtotal);
        shippingEl.textContent = formatPrice(shipping);
        totalEl.textContent = formatPrice(subtotal + shipping);
    }

    function ensureSelection(cart) {
        let selectedItems = loadSelectedItems();
        selectedItems = selectedItems.filter(id => cart.some(item => item.id === id));

        if (cart.length > 0 && selectedItems.length === 0) {
            selectedItems = cart.map(item => item.id);
        }

        saveSelectedItems(selectedItems);
    }

    function prefillUserDetails() {
        if (userData && userData.id) {
            if (userData.name && !fullNameInput.value) fullNameInput.value = userData.name;
            if (userData.mobile && !phoneInput.value) phoneInput.value = userData.mobile;
            if (userData.address && !addressInput.value) addressInput.value = userData.address;
        }
    }

    window.addEventListener('load', () => {
        prefillUserDetails();
        refreshCartCount();
        setTimeout(refreshCartCount, 200);

        fetchCart().then(cart => {
            ensureSelection(cart);
            updateSummary(cart);
        });
    });

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function() {
            const selectedItems = loadSelectedItems();
            if (selectedItemsInput) {
                selectedItemsInput.value = JSON.stringify(selectedItems);
            }
            saveSelectedItems([]);
        });
    }
</script>
@endsection
