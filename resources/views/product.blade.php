@extends('headerfooter')

@section('title', 'Products | FLEUR')

@section('content')
<div class="products-page">
    <h1>PRODUCTS</h1>

    <div class="search-section">
        <form method="GET" action="{{ route('product') }}" class="product-filters">
            <div class="product-search-row">
                <div class="search-bar">
                    <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" placeholder="Search products..." value="{{ $activeSearch ?? '' }}">
                </div>
            </div>
            <div class="filters-row">
                <div class="filters-right">
                    <select name="category" class="filter-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ ($activeCategory ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>

                    <select name="sort" class="filter-select">
                        <option value="default" {{ ($activeSort ?? 'default') === 'default' ? 'selected' : '' }}>Sort by</option>
                        <option value="price_low" {{ ($activeSort ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ ($activeSort ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>

                    <button type="submit" class="product-filter-btn">Filter</button>
                    <a href="{{ route('product') }}" class="product-filter-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card" data-name="{{ strtolower($product->name) }}">
                @php
                    $productImage = $product->image_url
                        ? (str_starts_with($product->image_url, 'http') ? $product->image_url : asset('images/'.$product->image_url))
                        : asset('images/placeholder.jpg');
                @endphp
                <div class="product-image">
                    <img src="{{ $productImage }}" alt="{{ $product->name }}">
                </div>
                <div class="product-info">
                    <h3>{{ $product->name }}</h3>
                    <p class="product-price">₱{{ number_format($product->price, 2) }}</p>
                    <button
                        class="product-btn add-to-cart"
                        type="button"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        data-image="{{ $product->image_url ?? '' }}"
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
    const userId = @json(auth()->id());
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const addToCartUrl = @json(route('cart.items.store'));
    const buttons = document.querySelectorAll('.add-to-cart');

    function parsePrice(priceText) {
        const numeric = String(priceText).replace(/[^0-9.]/g, '');
        return numeric ? parseFloat(numeric) : 0;
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (!userId) {
                alert('Please log in to save items in your cart.');
                window.location.href = @json(route('login'));
                return;
            }

            const name = btn.dataset.name;
            const price = parsePrice(btn.dataset.price || '0');
            const image = btn.dataset.image;
            const productId = btn.dataset.id ? parseInt(btn.dataset.id, 10) : null;

            fetch(addToCartUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    product_id: productId,
                    name,
                    price,
                    image_url: image || null,
                    quantity: 1,
                }),
            }).then(() => {
                const original = btn.textContent;
                btn.textContent = 'Added';
                setTimeout(() => { btn.textContent = original; }, 900);
            }).catch(() => {
                alert('Unable to add item. Please try again.');
            });
        });
    });
</script>
@endsection
