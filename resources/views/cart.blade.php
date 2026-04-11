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
    const userId = @json(auth()->id());
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const itemsUrl = @json(route('cart.items'));
    const updateBase = @json(url('/cart/items'));
    const imageBase = @json(asset('images/'));
    const rowsEl = document.getElementById('cartRows');
    const emptyEl = document.getElementById('emptyCart');
    const loginNotice = document.getElementById('loginNotice');
    const subtotalEl = document.getElementById('cartSubtotal');
    const shippingEl = document.getElementById('cartShipping');
    const totalEl = document.getElementById('cartTotal');

    function getCart() {
        try {
            return JSON.parse(localStorage.getItem(cartKey)) || [];
        } catch (e) {
            return [];
        }
    }

    function saveCart(cart) {
        localStorage.setItem(cartKey, JSON.stringify(cart));
    }

    function getSelectedItems() {
        try {
            return JSON.parse(localStorage.getItem('fleur_selected_items')) || [];
        } catch (e) {
            return [];
        }
    }

    function saveSelectedItems(selected) {
        localStorage.setItem('fleur_selected_items', JSON.stringify(selected));
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

    function formatPrice(value) {
        return `₱${value.toFixed(2)}`;
    }

    async function fetchCart() {
        const res = await fetch(itemsUrl, { headers: { 'Accept': 'application/json' } });
        if (!res.ok) throw new Error('Failed');
        return res.json();
    }

    function renderCart(items, totals) {
        rowsEl.innerHTML = '';

        if (!userId) {
            loginNotice.style.display = 'block';
            emptyEl.style.display = 'none';
            subtotalEl.textContent = formatPrice(0);
            shippingEl.textContent = formatPrice(0);
            totalEl.textContent = formatPrice(0);
            return;
        }

        loginNotice.style.display = 'none';
        if (items.length === 0) {
            emptyEl.style.display = 'block';
        } else {
            emptyEl.style.display = 'none';
        }

        const selectedItems = getSelectedItems();
        let subtotal = 0;
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.qty;
            if (selectedItems.includes(index)) {
                subtotal += itemTotal;
            }

            const isSelected = selectedItems.includes(index);

            const row = document.createElement('div');
            row.className = 'cart-item';
            row.innerHTML = `
                <input type="checkbox" class="item-checkbox" data-index="${index}" ${isSelected ? 'checked' : ''}>
                <div class="item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="item-details">
                    <h4>${item.name}</h4>
                    <p>₱${Number(item.price).toFixed(2)} each</p>
                </div>
                <div class="item-qty">
                    <button type="button" class="qty-btn" data-action="dec" data-index="${index}" ${item.qty === 1 ? 'disabled' : ''}>−</button>
                    <span>${item.qty}</span>
                    <button type="button" class="qty-btn" data-action="inc" data-index="${index}">+</button>
                </div>
                <div class="item-total">${formatPrice(itemTotal)}</div>
                <button type="button" class="remove-btn" data-index="${index}" title="Remove">✕</button>
            `;
            rowsEl.appendChild(row);
        });

        const shipping = subtotal > 0 ? 150 : 0;
        subtotalEl.textContent = formatPrice(subtotal);
        shippingEl.textContent = formatPrice(shipping);
        totalEl.textContent = formatPrice(subtotal + shipping);
        updateCheckoutButton();
    }

    rowsEl.addEventListener('click', (e) => {
        const checkbox = e.target.closest('.item-checkbox');
        if (checkbox) {
            const index = parseInt(checkbox.dataset.index, 10);
            let selectedItems = getSelectedItems();
            
            if (checkbox.checked) {
                if (!selectedItems.includes(index)) {
                    selectedItems.push(index);
                }
            } else {
                selectedItems = selectedItems.filter(i => i !== index);
            }
            
            saveSelectedItems(selectedItems);
            renderCart();
            return;
        }

        const qtyBtn = e.target.closest('.qty-btn');
        if (qtyBtn) {
            if (qtyBtn.disabled) return;
            
            const index = parseInt(qtyBtn.dataset.index, 10);
            const action = qtyBtn.dataset.action;
            const cart = getCart();

            if (!cart[index]) return;

            if (action === 'inc') {
                cart[index].qty += 1;
            } else if (action === 'dec') {
                cart[index].qty -= 1;
                if (cart[index].qty <= 0) {
                    cart.splice(index, 1);
                    let selectedItems = getSelectedItems();
                    saveSelectedItems(selectedItems.filter(i => i !== index));
                }
            }

            saveCart(cart);
            renderCart();
            window.dispatchEvent(new Event('cart-updated'));
            return;
        }

        const removeBtn = e.target.closest('.remove-btn');
        if (removeBtn) {
            const index = parseInt(removeBtn.dataset.index, 10);
            const cart = getCart();
            cart.splice(index, 1);
            let selectedItems = getSelectedItems();
            saveSelectedItems(selectedItems.filter(i => i !== index));
            saveCart(cart);
            renderCart();
            window.dispatchEvent(new Event('cart-updated'));
        }
    });

    window.addEventListener('load', updateCheckoutButton);

    // Handle checkout button click
    const checkoutBtn = document.getElementById('checkoutBtn');
    const loginModal = document.getElementById('loginModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const isAuthenticated = "{{ Auth::check() }}" === "1";

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', (e) => {
            if (!isAuthenticated) {
                e.preventDefault();
                e.stopPropagation();
                loginModal.style.display = 'flex';
            }
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            loginModal.style.display = 'none';
        });
    }

    // Close modal when clicking outside of it
    if (loginModal) {
        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                loginModal.style.display = 'none';
            }
        });
    }

    renderCart();
</script>
@endsection
