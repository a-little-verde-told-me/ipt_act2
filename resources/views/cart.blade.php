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
            <div class="cart-head">
                <span>Product</span>
                <span>Price</span>
                <span>Quantity</span>
                <span>Total</span>
            </div>
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

        items.forEach((item) => {
            const itemTotal = parseFloat(item.price) * item.quantity;
            const imageUrl = item.image_url
                ? (item.image_url.startsWith('http') ? item.image_url : `${imageBase}${item.image_url}`)
                : `${imageBase}placeholder.jpg`;

            const row = document.createElement('div');
            row.className = 'cart-item';
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
                <div class="item-total">${formatPrice(itemTotal)}</div>
                <button type="button" class="remove-btn" data-index="${index}" title="Remove">✕</button>
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
