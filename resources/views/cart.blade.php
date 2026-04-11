@extends('headerfooter')

@section('title', 'Cart | FLEUR')

@section('content')
<div class="cart-page">
    <div class="cart-header">
        <h1>MY CART</h1>
        <a class="continue-link" href="{{ route('product') }}">← Continue Browsing</a>
    </div>

    <div class="cart-layout">
        <div class="cart-list">
            <div id="cartRows"></div>
            <p class="empty-cart" id="emptyCart" style="text-align: center; padding: 40px 20px; color: #999;">Your cart is empty.</p>
        </div>

        <aside class="cart-summary">
            <div class="summary-box">
                <h3>Order Summary</h3>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="cartSubtotal">₱0.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span id="cartShipping">₱0.00</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="cartTotal">₱0.00</span>
                </div>
                
                <a href="{{ route('checkout') }}" class="checkout-btn" id="checkoutBtn">Proceed to Checkout</a>
            </div>
        </aside>
    </div>
</div>

<!-- Login Required Modal -->
<div class="login-modal" id="loginModal">
    <div class="login-card">
        <h2>Login Required</h2>
        <p>You need to log in first to proceed with checkout.</p>
        <div class="modal-actions">
            <a href="{{ route('login') }}" class="modal-btn btn-primary">Login</a>
            <button type="button" class="modal-btn btn-secondary" id="cancelBtn">Cancel</button>
        </div>
    </div>
</div>

<script>
    const rowsEl = document.getElementById('cartRows');
    const emptyEl = document.getElementById('emptyCart');
    const subtotalEl = document.getElementById('cartSubtotal');
    const shippingEl = document.getElementById('cartShipping');
    const totalEl = document.getElementById('cartTotal');
    const cartKey = 'fleur_cart';

    function normalizeCartItem(item) {
        const idValue = Number(item.id || item.product_id);

        return {
            id: Number.isFinite(idValue) && idValue > 0 ? idValue : Date.now() + Math.floor(Math.random() * 1000),
            product_name: item.product_name || item.name || 'Unnamed product',
            price: Number(item.price || item.unit_price || 0),
            image_url: item.image_url || item.image || '{{ asset("images/placeholder.jpg") }}',
            qty: Number(item.qty || item.quantity || 1),
        };
    }

    function loadCart() {
        try {
            const saved = JSON.parse(localStorage.getItem(cartKey)) || [];
            return saved.map(normalizeCartItem);
        } catch (e) {
            return [];
        }
    }

    function saveCart(cart) {
        const normalized = cart.map(normalizeCartItem);
        localStorage.setItem(cartKey, JSON.stringify(normalized));
        window.dispatchEvent(new Event('cart-updated'));
    }

    function getSelectedItems() {
        try {
            const items = JSON.parse(localStorage.getItem('fleur_selected_items')) || [];
            return items.map(id => Number(id)).filter(id => Number.isFinite(id));
        } catch (e) {
            return [];
        }
    }

    function hasStoredSelection() {
        return localStorage.getItem('fleur_selected_items') !== null;
    }

    function saveSelectedItems(selected) {
        const normalized = selected.map(id => Number(id)).filter(id => Number.isFinite(id));
        localStorage.setItem('fleur_selected_items', JSON.stringify(normalized));
    }

    function formatPrice(value) {
        return `₱${value.toFixed(2)}`;
    }

    function renderCart() {
        const cart = loadCart();
        rowsEl.innerHTML = '';

        if (cart.length === 0) {
            emptyEl.style.display = 'block';
        } else {
            emptyEl.style.display = 'none';
        }

        let selectedItems = getSelectedItems();
        if (cart.length > 0 && selectedItems.length === 0 && !hasStoredSelection()) {
            selectedItems = cart.map(item => item.id);
            saveSelectedItems(selectedItems);
        }

        let subtotal = 0;

        cart.forEach(item => {
            const itemTotal = item.price * item.qty;
            if (selectedItems.includes(item.id)) {
                subtotal += itemTotal;
            }

            const isSelected = selectedItems.includes(item.id);

            const row = document.createElement('div');
            row.className = 'cart-item';
            row.innerHTML = `
                <input type="checkbox" class="item-checkbox" data-id="${item.id}" ${isSelected ? 'checked' : ''}>
                <div class="item-image">
                    <img src="${item.image_url}" alt="${item.product_name}">
                </div>
                <div class="item-details">
                    <h4>${item.product_name}</h4>
                    <p>₱${Number(item.price).toFixed(2)} each</p>
                </div>
                <div class="item-qty">
                    <button type="button" class="qty-btn" data-action="dec" data-id="${item.id}" ${item.qty === 1 ? 'disabled' : ''}>−</button>
                    <span>${item.qty}</span>
                    <button type="button" class="qty-btn" data-action="inc" data-id="${item.id}">+</button>
                </div>
                <div class="item-total">${formatPrice(itemTotal)}</div>
                <button type="button" class="remove-btn" data-id="${item.id}" title="Remove">✕</button>
            `;
            rowsEl.appendChild(row);
        });

        const shipping = subtotal > 0 ? 150 : 0;
        subtotalEl.textContent = formatPrice(subtotal);
        shippingEl.textContent = formatPrice(shipping);
        totalEl.textContent = formatPrice(subtotal + shipping);
        updateCheckoutButton();
    }

    function updateCheckoutButton() {
        const checkoutBtn = document.getElementById('checkoutBtn');
        const selectedItems = getSelectedItems();
        const hasItems = selectedItems.length > 0;
        if (checkoutBtn) {
            checkoutBtn.dataset.disabled = !hasItems;
            checkoutBtn.style.opacity = hasItems ? '1' : '0.5';
            checkoutBtn.style.cursor = hasItems ? 'pointer' : 'not-allowed';
            checkoutBtn.style.pointerEvents = hasItems ? 'auto' : 'none';
        }
    }

    rowsEl.addEventListener('click', (e) => {
        const checkbox = e.target.closest('.item-checkbox');
        if (checkbox) {
            const itemId = parseInt(checkbox.dataset.id, 10);
            let selectedItems = getSelectedItems();

            if (checkbox.checked) {
                if (!selectedItems.includes(itemId)) {
                    selectedItems.push(itemId);
                }
            } else {
                selectedItems = selectedItems.filter(id => id !== itemId);
            }

            saveSelectedItems(selectedItems);
            renderCart();
            return;
        }

        const qtyBtn = e.target.closest('.qty-btn');
        if (qtyBtn) {
            const itemId = parseInt(qtyBtn.dataset.id, 10);
            const action = qtyBtn.dataset.action;
            const cart = loadCart();
            const item = cart.find(i => i.id === itemId);
            if (!item) return;

            item.qty = action === 'inc' ? item.qty + 1 : item.qty - 1;
            if (item.qty < 1) item.qty = 1;
            saveCart(cart);
            renderCart();
            return;
        }

        const removeBtn = e.target.closest('.remove-btn');
        if (removeBtn) {
            const itemId = parseInt(removeBtn.dataset.id, 10);
            let cart = loadCart();
            cart = cart.filter(item => item.id !== itemId);
            saveCart(cart);

            const selectedItems = getSelectedItems().filter(id => id !== itemId);
            saveSelectedItems(selectedItems);
            renderCart();
        }
    });

    const checkoutBtn = document.getElementById('checkoutBtn');

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', (e) => {
            const cart = loadCart();
            if (cart.length === 0) {
                e.preventDefault();
            }
        });
    }

    window.addEventListener('load', renderCart);
</script>
@endsection
