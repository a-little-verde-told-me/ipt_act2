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
            <p class="empty-cart" id="loginNotice" style="display:none;">Please log in to view your saved cart.</p>
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

    function formatPrice(value) {
        return `₱ ${value.toFixed(2)}`;
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

        items.forEach((item) => {
            const itemTotal = parseFloat(item.price) * item.quantity;
            const imageUrl = item.image_url
                ? (item.image_url.startsWith('http') ? item.image_url : `${imageBase}${item.image_url}`)
                : `${imageBase}placeholder.jpg`;

            const row = document.createElement('div');
            row.className = 'cart-row';
            row.innerHTML = `
                <label class="check-cell">
                    <input type="checkbox" checked>
                </label>
                <div class="product-cell">
                    <div class="thumb"><img src="${imageUrl}" alt="${item.name}"></div>
                    <div class="product-text">
                        <strong>${item.name}</strong>
                        <span>custom bouquet</span>
                    </div>
                </div>
                <div class="price-cell">${formatPrice(parseFloat(item.price))}</div>
                <div class="qty-cell">
                    <button type="button" class="qty-btn" data-action="dec" data-id="${item.id}" data-qty="${item.quantity}">−</button>
                    <span class="qty-value">${item.quantity}</span>
                    <button type="button" class="qty-btn" data-action="inc" data-id="${item.id}" data-qty="${item.quantity}">+</button>
                </div>
                <div class="total-cell">${formatPrice(itemTotal)}</div>
            `;
            rowsEl.appendChild(row);
        });

        subtotalEl.textContent = formatPrice(totals.subtotal);
        shippingEl.textContent = formatPrice(totals.shipping);
        totalEl.textContent = formatPrice(totals.total);
    }

    async function updateItem(id, quantity) {
        await fetch(`${updateBase}/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ quantity }),
        });
    }

    rowsEl.addEventListener('click', async (e) => {
        const btn = e.target.closest('.qty-btn');
        if (!btn) return;

        const id = parseInt(btn.dataset.id, 10);
        const currentQty = parseInt(btn.dataset.qty, 10);
        const action = btn.dataset.action;
        const nextQty = action === 'inc' ? currentQty + 1 : currentQty - 1;

        if (nextQty < 0) return;

        try {
            await updateItem(id, nextQty);
            const data = await fetchCart();
            renderCart(data.items, data);
        } catch (e) {
            alert('Unable to update cart.');
        }
    });

    if (userId) {
        fetchCart().then(data => renderCart(data.items, data)).catch(() => {
            renderCart([], { subtotal: 0, shipping: 0, total: 0 });
        });
    } else {
        renderCart([], { subtotal: 0, shipping: 0, total: 0 });
    }

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
