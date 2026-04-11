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
    const checkoutBtn = document.getElementById('checkoutBtn');
    const isAuthenticated = "{{ Auth::check() }}" === "1";
    const selectedItemsKey = 'fleur_selected_items';
    let cartItems = [];
    let selectedItems = [];

    function normalizeCartItem(item) {
        return {
            id: item.id,
            product_name: item.product_name,
            price: Number(item.price),
            image_url: item.image_url,
            qty: Number(item.qty),
        };
    }

    function loadSelectedItems() {
        try {
            return JSON.parse(localStorage.getItem(selectedItemsKey)) || [];
        } catch (error) {
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

    function ensureSelection() {
        selectedItems = loadSelectedItems();
        selectedItems = selectedItems.filter(id => cartItems.some(item => item.id === id));

        if (cartItems.length > 0 && selectedItems.length === 0) {
            selectedItems = cartItems.map(item => item.id);
        }

        saveSelectedItems(selectedItems);
    }

    function loadCart() {
        if (!isAuthenticated) {
            cartItems = [];
            selectedItems = [];
            renderCart();
            return;
        }

        fetch('{{ route("api.cart.get") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            cartItems = data.map(normalizeCartItem);
            ensureSelection();
            renderCart();
        })
        .catch(error => {
            console.error('Error loading cart:', error);
            cartItems = [];
            selectedItems = [];
            renderCart();
        });
    }

    function updateQty(itemId, newQty) {
        if (!isAuthenticated) return;

        fetch(`{{ url('/api/cart') }}/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ qty: newQty })
        })
        .then(response => response.json())
        .then(data => {
            loadCart();
            window.dispatchEvent(new CustomEvent('cart-updated'));
        })
        .catch(error => {
            console.error('Error updating qty:', error);
        });
    }

    function removeItem(itemId) {
        if (!isAuthenticated) return;

        fetch(`{{ url('/api/cart') }}/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            loadCart();
            window.dispatchEvent(new CustomEvent('cart-updated'));
        })
        .catch(error => {
            console.error('Error removing item:', error);
        });
    }

    function toggleSelection(itemId, isSelected) {
        if (isSelected) {
            if (!selectedItems.includes(itemId)) {
                selectedItems.push(itemId);
            }
        } else {
            selectedItems = selectedItems.filter(id => id !== itemId);
        }
        saveSelectedItems(selectedItems);
        renderCart();
    }

    function getSelectedSubtotal() {
        return cartItems.reduce((sum, item) => {
            return selectedItems.includes(item.id) ? sum + item.price * item.qty : sum;
        }, 0);
    }

    const cartCountBadge = document.getElementById('cartCount');

    function formatPrice(value) {
        return `₱${value.toFixed(2)}`;
    }

    function refreshCartCount() {
        if (!isAuthenticated || !cartCountBadge) return;

        fetch('{{ route("api.cart.count") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const count = Number(data.count || 0);
            cartCountBadge.textContent = count;
            cartCountBadge.style.display = count > 0 ? 'inline-flex' : 'none';
        })
        .catch(() => {
            if (cartCountBadge) {
                cartCountBadge.style.display = 'none';
            }
        });
    }

    function renderCart() {
        rowsEl.innerHTML = '';

        if (cartItems.length === 0) {
            emptyEl.style.display = 'block';
        } else {
            emptyEl.style.display = 'none';
        }

        let totalSelected = 0;

        cartItems.forEach(item => {
            const itemTotal = item.price * item.qty;
            const checked = selectedItems.includes(item.id);
            if (checked) totalSelected += itemTotal;

            const row = document.createElement('div');
            row.className = 'cart-item';
            row.innerHTML = `
                <div class="item-select">
                    <input type="checkbox" class="item-checkbox" data-id="${item.id}" ${checked ? 'checked' : ''}>
                </div>
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

        const shipping = totalSelected > 0 ? 150 : 0;
        subtotalEl.textContent = formatPrice(totalSelected);
        shippingEl.textContent = formatPrice(shipping);
        totalEl.textContent = formatPrice(totalSelected + shipping);
        updateCheckoutButton();
        refreshCartCount();
    }

    function updateCheckoutButton() {
        const hasSelectedItems = selectedItems.length > 0;
        if (checkoutBtn) {
            checkoutBtn.dataset.disabled = !hasSelectedItems;
            checkoutBtn.style.opacity = hasSelectedItems ? '1' : '0.5';
            checkoutBtn.style.cursor = hasSelectedItems ? 'pointer' : 'not-allowed';
            checkoutBtn.style.pointerEvents = hasSelectedItems ? 'auto' : 'none';
        }
    }

    rowsEl.addEventListener('click', (e) => {
        const qtyBtn = e.target.closest('.qty-btn');
        if (qtyBtn) {
            const itemId = parseInt(qtyBtn.dataset.id, 10);
            const action = qtyBtn.dataset.action;
            const item = cartItems.find(i => i.id === itemId);
            if (!item) return;

            const newQty = action === 'inc' ? item.qty + 1 : item.qty - 1;
            if (newQty < 1) return;
            updateQty(itemId, newQty);
            return;
        }

        const removeBtn = e.target.closest('.remove-btn');
        if (removeBtn) {
            const itemId = parseInt(removeBtn.dataset.id, 10);
            removeItem(itemId);
        }
    });

    rowsEl.addEventListener('change', (e) => {
        const checkbox = e.target.closest('input.item-checkbox');
        if (!checkbox) return;
        const itemId = parseInt(checkbox.dataset.id, 10);
        toggleSelection(itemId, checkbox.checked);
    });

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', (e) => {
            if (selectedItems.length === 0) {
                e.preventDefault();
            }
        });
    }

    window.addEventListener('load', loadCart);
</script>
@endsection
