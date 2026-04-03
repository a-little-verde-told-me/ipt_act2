@extends('headerfooter')

@section('title', 'Cart | FLEUR')

@section('content')
<div class="cart-page">
    <div class="cart-header">
        <h1>MY CART</h1>
        <a class="continue-link" href="{{ route('product') }}">Continue Browsing &gt;</a>
    </div>

    <div class="cart-layout">
        <div class="cart-list">
            <div class="cart-head">
                <span>Product</span>
                <span>Price</span>
                <span>Quantity</span>
                <span>Total</span>
            </div>
            <div id="cartRows"></div>
            <p class="empty-cart" id="emptyCart">Your cart is empty.</p>
        </div>

        <aside class="cart-side">
            <div class="address-box">
                <h3>Delivery address</h3>
                <p id="deliveryAddress">001 Alvear St., Lingayen</p>
                <button class="change-btn" type="button" id="changeAddressBtn">Change</button>
            </div>

            <div class="summary-box">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="cartSubtotal">₱ 0.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span id="cartShipping">₱ 0.00</span>
                </div>
                <div class="summary-row">
                    <span>Coupon Code</span>
                    <input type="text">
                </div>
                <div class="summary-row">
                    <span>Add a note</span>
                    <textarea rows="3"></textarea>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="cartTotal">₱ 0.00</span>
                </div>
                <a href="{{ route('checkout') }}" class="checkout-btn">Checkout</a>
            </div>
        </aside>
    </div>
</div>

<script>
    const cartKey = 'fleur_cart';
    const rowsEl = document.getElementById('cartRows');
    const emptyEl = document.getElementById('emptyCart');
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

    function formatPrice(value) {
        return `₱ ${value.toFixed(2)}`;
    }

    function renderCart() {
        const cart = getCart();
        rowsEl.innerHTML = '';

        if (cart.length === 0) {
            emptyEl.style.display = 'block';
        } else {
            emptyEl.style.display = 'none';
        }

        let subtotal = 0;
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;

            const row = document.createElement('div');
            row.className = 'cart-row';
            row.innerHTML = `
                <label class="check-cell">
                    <input type="checkbox" checked>
                </label>
                <div class="product-cell">
                    <div class="thumb"><img src="${item.image}" alt="${item.name}"></div>
                    <div class="product-text">
                        <strong>${item.name}</strong>
                        <span>color</span>
                    </div>
                </div>
                <div class="price-cell">${formatPrice(item.price)}</div>
                <div class="qty-cell">
                    <button type="button" class="qty-btn" data-action="dec" data-index="${index}">−</button>
                    <span class="qty-value">${item.qty}</span>
                    <button type="button" class="qty-btn" data-action="inc" data-index="${index}">+</button>
                </div>
                <div class="total-cell">${formatPrice(itemTotal)}</div>
            `;
            rowsEl.appendChild(row);
        });

        const shipping = cart.length ? 150 : 0;
        subtotalEl.textContent = formatPrice(subtotal);
        shippingEl.textContent = formatPrice(shipping);
        totalEl.textContent = formatPrice(subtotal + shipping);
    }

    rowsEl.addEventListener('click', (e) => {
        const btn = e.target.closest('.qty-btn');
        if (!btn) return;

        const index = parseInt(btn.dataset.index, 10);
        const action = btn.dataset.action;
        const cart = getCart();

        if (!cart[index]) return;

        if (action === 'inc') {
            cart[index].qty += 1;
        } else if (action === 'dec') {
            cart[index].qty -= 1;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
        }

        saveCart(cart);
        renderCart();
    });

    renderCart();

    const addressEl = document.getElementById('deliveryAddress');
    const changeBtn = document.getElementById('changeAddressBtn');
    changeBtn.addEventListener('click', () => {
        const current = addressEl.textContent.trim();
        const next = prompt('Enter new delivery address:', current);
        if (next && next.trim()) {
            addressEl.textContent = next.trim();
        }
    });
</script>
@endsection
