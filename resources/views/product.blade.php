@extends('headerfooter')

@section('title', 'Products | FLEUR')

@section('content')
<div class="products-page">
    <h1>PRODUCTS</h1>

    <div class="search-section">
        <form class="product-filters" id="productFilters">
            <!-- Search Bar -->
            <div class="search-bar">
                <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" id="searchInput" placeholder="Search products..." value="{{ $activeSearch ?? '' }}">
            </div>

            <!-- Filters Row -->
            <div class="filters-row">
                <!-- Category Filter -->
                <select name="category" id="categorySelect">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ ($activeCategory ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Sort Dropdown -->
                <select name="sort" id="sortSelect">
                    <option value="default" {{ ($activeSort ?? 'default') === 'default' ? 'selected' : '' }}>Sort by</option>
                    <option value="price_low" {{ ($activeSort ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ ($activeSort ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>

                <!-- Reset Button -->
                <a href="{{ route('product') }}" class="reset-btn">Reset</a>
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
                    <p>{{ \Illuminate\Support\Str::limit($product->description ?? 'Beautiful fresh flowers for every occasion.', 96) }}</p>
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

    @if ($products->hasPages())
        <div class="pagination-wrapper">
            {{ $products->links('pagination::custom') }}
        </div>
    @endif
</div>

<script>
    const buttons = document.querySelectorAll('.add-to-cart');
    const isAuthenticated = "{{ Auth::check() }}" === "1";

    function parsePrice(priceText) {
        const numeric = String(priceText).replace(/[^0-9.]/g, '');
        return numeric ? parseFloat(numeric) : 0;
    }

    function refreshCartCount() {
        if (!isAuthenticated) return;

        fetch('{{ route("api.cart.count") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cartCount');
            if (!badge) return;
            badge.textContent = data.count || 0;
            badge.style.display = (data.count || 0) > 0 ? 'inline-flex' : 'none';
        })
        .catch(() => {});
    }

    window.addEventListener('cart-updated', refreshCartCount);

    function showLoginRequiredOverlay() {
        const overlay = document.getElementById('loginRequiredOverlay');
        if (overlay) {
            overlay.style.display = 'flex';
        }
    }

    function hideLoginRequiredOverlay() {
        const overlay = document.getElementById('loginRequiredOverlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
    }

    function addToCart(name, price, image) {
        if (!isAuthenticated) {
            showLoginRequiredOverlay();
            return;
        }

        fetch('{{ route("api.cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_name: name,
                price: parseFloat(price),
                image_url: image,
                qty: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                window.dispatchEvent(new CustomEvent('cart-updated'));
                // Show success message
                const btn = document.querySelector(`[data-name="${name}"]`);
                const original = btn.textContent;
                btn.textContent = 'Added';
                setTimeout(() => { btn.textContent = original; }, 900);
            } else {
                alert('Failed to add to cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding to cart');
        });
    }

    function handleAddToCartClick(btn) {
        btn.addEventListener('click', () => {
            const name = btn.dataset.name;
            const price = parsePrice(btn.dataset.price || '0');
            const image = btn.dataset.image;

            addToCart(name, price, image);
        });
    }

    function attachCartButtons() {
        const newButtons = document.querySelectorAll('.add-to-cart');
        newButtons.forEach(handleAddToCartClick);
    }

    buttons.forEach(handleAddToCartClick);

    window.addEventListener('load', refreshCartCount);
    refreshCartCount();

    // Automatic filtering, searching, and sorting
    let filterTimeout;
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    const sortSelect = document.getElementById('sortSelect');
    const productFiltersForm = document.getElementById('productFilters');

    function applyFilters() {
        const formData = new FormData(productFiltersForm);
        const params = new URLSearchParams(formData);

        fetch(`{{ route('product') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.text())
        .then(html => {
            // Extract products grid and pagination from response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newGrid = doc.querySelector('.products-grid');
            const currentGrid = document.querySelector('.products-grid');
            const newPagination = doc.querySelector('.pagination-wrapper');
            const currentPagination = document.querySelector('.pagination-wrapper');
            
            if (newGrid && currentGrid) {
                currentGrid.innerHTML = newGrid.innerHTML;
            }
            
            if (newPagination && currentPagination) {
                currentPagination.innerHTML = newPagination.innerHTML;
            } else if (newPagination && !currentPagination) {
                const container = document.createElement('div');
                container.className = 'pagination-wrapper';
                container.innerHTML = newPagination.innerHTML;
                document.querySelector('.products-page').appendChild(container);
            }
            
            if (newGrid && currentGrid) {
                // Reattach event listeners to new buttons
                attachCartButtons();
            }
            
            // Update URL without page reload
            window.history.pushState({ page: 'product-filter' }, '', `{{ route('product') }}?${params.toString()}`);
        })
        .catch(error => console.error('Filter error:', error));
    }

    // Event listeners for automatic filtering
    searchInput.addEventListener('input', () => {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(applyFilters, 500); // Debounce for 500ms
    });

    categorySelect.addEventListener('change', applyFilters);
    sortSelect.addEventListener('change', applyFilters);

    // Login required overlay cancel button
    window.addEventListener('DOMContentLoaded', () => {
        const cancelLoginBtn = document.getElementById('cancelLoginBtn');
        if (cancelLoginBtn) {
            cancelLoginBtn.addEventListener('click', hideLoginRequiredOverlay);
        }
    });
</script>

<!-- Login Required Overlay -->
<div class="login-required-overlay" id="loginRequiredOverlay" style="display: none;">
    <div class="login-required-card">
        <div class="login-required-icon">🔒</div>
        <h2>Login Required</h2>
        <p>Please login to add items to your cart.</p>
        <div class="login-required-actions">
            <a href="{{ route('login') }}" class="login-required-btn btn-primary">Login</a>
            <button class="login-required-btn btn-secondary" id="cancelLoginBtn">Cancel</button>
        </div>
    </div>
</div>

@endsection
