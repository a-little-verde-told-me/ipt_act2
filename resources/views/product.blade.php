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

    .product-image-link {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        width: 100%;
        margin: 0;
        transition: transform 0.2s ease;
    }

    .product-image-link:hover {
        transform: scale(1.02);
    }

    .product-image-link:focus {
        outline: 2px solid var(--accent-rose);
        outline-offset: 2px;
    }

    .product-image-img {
        display: block;
        width: 100%;
        height: 100%;
    }
</style>

<div class="product-section">
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
                <button class="product-image-link" type="button" data-image="{{ $productImage }}" data-title="{{ $product->name }}">
                    <div class="product-image">
                        <img class="product-image-img" src="{{ $productImage }}" alt="{{ $product->name }}">
                    </div>
                </button>
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
    // Lightbox functionality
    const lightbox = document.getElementById('productLightbox');
    const lightboxImage = document.getElementById('productLightboxImage');
    const lightboxTitle = document.getElementById('productLightboxTitle');
    const closeBtn = lightbox.querySelector('.lightbox-close');

    document.querySelectorAll('.product-image-link').forEach(btn => {
        btn.addEventListener('click', () => {
            lightboxImage.src = btn.dataset.image;
            lightboxImage.alt = btn.dataset.title || 'Product image';
            lightboxTitle.textContent = btn.dataset.title || '';
            lightbox.classList.add('open');
            lightbox.setAttribute('aria-hidden', 'false');
        });
    });

    function closeLightbox() {
        lightbox.classList.remove('open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImage.src = '';
    }

    closeBtn.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.classList.contains('open')) {
            closeLightbox();
        }
    });

    const cartKey = 'fleur_cart';
    const isAuthenticated = "{{ Auth::check() }}" === "1";
    const buttons = document.querySelectorAll('.add-to-cart');

    function parsePrice(priceText) {
        const numeric = String(priceText).replace(/[^0-9.]/g, '');
        return numeric ? parseFloat(numeric) : 0;
    }

    function getCartGuest() {
        try {
            return JSON.parse(localStorage.getItem(cartKey)) || [];
        } catch (e) {
            console.warn('Failed to parse cart:', e);
            return [];
        }
    }

    function saveCartGuest(cart) {
        localStorage.setItem(cartKey, JSON.stringify(cart));
    }

    async function getCartFromServer() {
        if (!isAuthenticated) return getCartGuest();
        try {
            const response = await fetch('{{ route("api.cart.get") }}');
            return await response.json();
        } catch (e) {
            console.error('Failed to fetch cart:', e);
            return [];
        }
    }

    // Load cart from server on page load
    if (isAuthenticated) {
        getCartFromServer().then(cart => {
            saveCartGuest(cart);
            window.dispatchEvent(new Event('cart-updated'));
        });
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', async () => {
            const name = btn.dataset.name;
            const price = parsePrice(btn.dataset.price || '0');
            const image = btn.dataset.image;
            
            if (isAuthenticated) {
                try {
                    await fetch('{{ route("api.cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        },
                        body: JSON.stringify({
                            product_name: name,
                            price: price,
                            image_url: image,
                            qty: 1,
                        }),
                    });
                    
                    const cart = getCartGuest();
                    const existing = cart.find(item => item.name === name);
                    if (existing) {
                        existing.qty += 1;
                    } else {
                        cart.push({ name, price, image, qty: 1 });
                    }
                    saveCartGuest(cart);
                } catch (e) {
                    console.error('Failed to add to cart:', e);
                }
            } else {
                const cart = getCartGuest();
                const existing = cart.find(item => item.name === name);
                if (existing) {
                    existing.qty += 1;
                } else {
                    cart.push({ name, price, image, qty: 1 });
                }
                saveCartGuest(cart);
            }
            
            const original = btn.textContent;
            btn.textContent = 'Added';
            setTimeout(() => { btn.textContent = original; }, 900);
            window.dispatchEvent(new Event('cart-updated'));
        });
    });

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

    function attachCartButtons() {
        const newButtons = document.querySelectorAll('.add-to-cart');
        newButtons.forEach(btn => {
            btn.addEventListener('click', async () => {
                const name = btn.dataset.name;
                const price = parsePrice(btn.dataset.price || '0');
                const image = btn.dataset.image;
                
                if (isAuthenticated) {
                    try {
                        await fetch('{{ route("api.cart.add") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            },
                            body: JSON.stringify({
                                product_name: name,
                                price: price,
                                image_url: image,
                                qty: 1,
                            }),
                        });
                        
                        const cart = getCartGuest();
                        const existing = cart.find(item => item.name === name);
                        if (existing) {
                            existing.qty += 1;
                        } else {
                            cart.push({ name, price, image, qty: 1 });
                        }
                        saveCartGuest(cart);
                    } catch (e) {
                        console.error('Failed to add to cart:', e);
                    }
                } else {
                    const cart = getCartGuest();
                    const existing = cart.find(item => item.name === name);
                    if (existing) {
                        existing.qty += 1;
                    } else {
                        cart.push({ name, price, image, qty: 1 });
                    }
                    saveCartGuest(cart);
                }
                
                const original = btn.textContent;
                btn.textContent = 'Added';
                setTimeout(() => { btn.textContent = original; }, 900);
                window.dispatchEvent(new Event('cart-updated'));
            });
        });
    }

    // Event listeners for automatic filtering
    searchInput.addEventListener('input', () => {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(applyFilters, 500); // Debounce for 500ms
    });

    categorySelect.addEventListener('change', applyFilters);
    sortSelect.addEventListener('change', applyFilters);
</script>
@endsection
