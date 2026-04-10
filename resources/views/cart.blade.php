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
                
                <a href="{{ route('checkout') }}" class="checkout-btn">Proceed to Checkout</a>
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
        return `₱${value.toFixed(2)}`;
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
            row.className = 'cart-item';
            row.innerHTML = `
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

        const shipping = cart.length ? 150 : 0;
        subtotalEl.textContent = formatPrice(subtotal);
        shippingEl.textContent = formatPrice(shipping);
        totalEl.textContent = formatPrice(subtotal + shipping);
    }

    rowsEl.addEventListener('click', (e) => {
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
            saveCart(cart);
            renderCart();
            window.dispatchEvent(new Event('cart-updated'));
        }
    });

    renderCart();
</script>
@endsection
