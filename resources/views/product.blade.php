@extends('headerfooter')

@section('title', 'Products | FLEUR')

@section('content')
<div class="products-page">
    <h1>PRODUCTS</h1>

    <div class="search-section">
        <form method="GET" action="{{ route('product') }}" class="product-filters">
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-bottom: 20px;">
                <!-- Search Bar -->
                <div class="search-bar" style="flex: 1; min-width: 250px;">
                    <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" placeholder="Search products..." value="{{ $activeSearch ?? '' }}">
                </div>

                <!-- Category Filter -->
                <select name="category" style="padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ ($activeCategory ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Sort Dropdown -->
                <select name="sort" style="padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                    <option value="default" {{ ($activeSort ?? 'default') === 'default' ? 'selected' : '' }}>Sort by</option>
                    <option value="price_low" {{ ($activeSort ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ ($activeSort ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>

                <!-- Submit Button -->
                <button type="submit" style="padding: 10px 16px; background: var(--accent-rose); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Filter</button>

                <!-- Reset Button -->
                <a href="{{ route('product') }}" style="padding: 10px 16px; background: #666; color: white; text-decoration: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: inline-block;">Reset</a>
            </div>
        </form>
    </div>

    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card" data-name="{{ strtolower($product->name) }}">
                <div class="product-image">
                    <img src="{{ $product->image_url ? asset('images/'.$product->image_url) : asset('images/placeholder.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="product-info">
                    <h3>{{ $product->name }}</h3>
                    <p class="product-price">₱{{ number_format($product->price, 2) }}</p>
                    <button
                        class="product-btn add-to-cart"
                        type="button"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        data-image="{{ $product->image_url ? asset('images/'.$product->image_url) : asset('images/placeholder.jpg') }}"
                    >Add to Cart</button>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                <p style="font-size: 1.1rem; margin: 0;">No results found or data is insufficient</p>
                <p style="font-size: 0.9rem; margin-top: 8px;">Try adjusting your filters or search terms.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    const cartKey = 'fleur_cart';
    const buttons = document.querySelectorAll('.add-to-cart');

    function parsePrice(priceText) {
        const numeric = String(priceText).replace(/[^0-9.]/g, '');
        return numeric ? parseFloat(numeric) : 0;
    }

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

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const name = btn.dataset.name;
            const price = parsePrice(btn.dataset.price || '0');
            const image = btn.dataset.image;
            const cart = getCart();
            const existing = cart.find(item => item.name === name);
            if (existing) {
                existing.qty += 1;
            } else {
                cart.push({ name, price, image, qty: 1 });
            }
            saveCart(cart);
            const original = btn.textContent;
            btn.textContent = 'Added';
            setTimeout(() => { btn.textContent = original; }, 900);
        });
    });
</script>
@endsection
