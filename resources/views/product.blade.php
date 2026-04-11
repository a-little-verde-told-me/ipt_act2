@extends('headerfooter')

@section('title', 'Products | FLEUR')

@section('content')
<style>
    .product-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .product-section h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2.5rem;
        color: #a63359;
    }

    .filter-container {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .product-filters {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .search-bar {
        position: relative;
        width: 100%;
    }

    .search-bar input {
        width: 100%;
        padding: 12px 14px 12px 40px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.95rem;
        box-sizing: border-box;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        pointer-events: none;
    }

    .filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto auto;
        gap: 10px;
        align-items: center;
    }

    .product-filters select {
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.95rem;
        background: white;
        cursor: pointer;
        box-sizing: border-box;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    .filter-actions button,
    .filter-actions a {
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .filter-actions button[type="submit"] {
        background: var(--accent-rose);
        color: white;
    }

    .filter-actions button[type="submit"]:hover {
        background: #8b2a47;
    }

    .filter-actions a {
        background: #666;
        color: white;
    }

    .filter-actions a:hover {
        background: #555;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .empty-state p:first-child {
        font-size: 1.3rem;
        margin: 0 0 10px 0;
        font-weight: 600;
    }

    .empty-state p:last-child {
        font-size: 0.95rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .filter-row {
            grid-template-columns: 1fr 1fr;
        }

        .filter-actions {
            grid-column: 1 / -1;
        }

        .filter-actions button,
        .filter-actions a {
            flex: 1;
        }

        .product-section h1 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .filter-row {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            grid-column: 1 / -1;
        }
    }
</style>

<div class="product-section">
    <h1>PRODUCTS</h1>

    <div class="filter-container">
        <form id="productFiltersForm" method="GET" action="{{ route('product') }}" class="product-filters">
            <div class="search-bar">
                <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input id="searchInput" type="text" name="search" placeholder="Search products..." value="{{ $activeSearch ?? '' }}">
            </div>

            <div class="filter-row">
                <select id="categorySelect" name="category" aria-label="Filter by category">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ ($activeCategory ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <select id="sortSelect" name="sort" aria-label="Sort products">
                    <option value="default" {{ ($activeSort ?? 'default') === 'default' ? 'selected' : '' }}>Sort by</option>
                    <option value="price_low" {{ ($activeSort ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ ($activeSort ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>

                <div class="filter-actions">
                    <button type="submit">Filter</button>
                    <a href="{{ route('product') }}">Reset</a>
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
                    <p>{{ \Illuminate\Support\Str::limit($product->description ?? 'Beautiful fresh flowers for every occasion.', 96) }}</p>
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
            <div class="empty-state">
                <p>No products found</p>
                <p>Try adjusting your filters or search terms.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    const cartKey = 'fleur_cart';

    function parsePrice(priceText) {
        const numeric = String(priceText).replace(/[^0-9.]/g, '');
        return numeric ? parseFloat(numeric) : 0;
    }

    function getCart() {
        try {
            return JSON.parse(localStorage.getItem(cartKey)) || [];
        } catch (e) {
            console.warn('Failed to parse cart:', e);
            return [];
        }
    }

    function saveCart(cart) {
        try {
            localStorage.setItem(cartKey, JSON.stringify(cart));
            window.dispatchEvent(new Event('cart-updated'));
        } catch (e) {
            console.error('Failed to save cart:', e);
        }
    }

    function addToCart(name, price, image) {
        if (!name) {
            console.warn('Product name is required');
            return;
        }
        const cart = getCart();
        const existing = cart.find(item => item.name === name);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ name, price, image, qty: 1 });
        }
        saveCart(cart);
    }

    function attachCartListeners() {
        const buttons = document.querySelectorAll('.add-to-cart');
        buttons.forEach(btn => {
            // Remove old listeners by cloning
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);
            
            newBtn.addEventListener('click', () => {
                const name = newBtn.dataset.name;
                const price = parsePrice(newBtn.dataset.price || '0');
                const image = newBtn.dataset.image;
                addToCart(name, price, image);
                
                const original = newBtn.textContent;
                newBtn.textContent = 'Added';
                newBtn.disabled = true;
                setTimeout(() => { 
                    newBtn.textContent = original;
                    newBtn.disabled = false;
                }, 900);
            });
        });
    }

    function applyFilters() {
        const form = document.getElementById('productFiltersForm');
        if (!form) return;
        
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        fetch(`{{ route('product') }}?${params.toString()}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newGrid = doc.querySelector('.products-grid');
            const currentGrid = document.querySelector('.products-grid');
            
            if (newGrid && currentGrid) {
                currentGrid.innerHTML = newGrid.innerHTML;
                attachCartListeners();
                window.history.replaceState({ page: 'product' }, '', `{{ route('product') }}?${params.toString()}`);
            }
        })
        .catch(error => console.error('Filter error:', error));
    }

    // Initialize
    let filterTimeout;
    attachCartListeners();

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(applyFilters, 500);
        });
    }

    const categorySelect = document.getElementById('categorySelect');
    if (categorySelect) {
        categorySelect.addEventListener('change', applyFilters);
    }

    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', applyFilters);
    }
</script>
@endsection
