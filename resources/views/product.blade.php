@extends('headerfooter')

@section('title', 'Products | FLEUR')

@section('content')
<div class="products-page">
    <h1 style="color: #8a3a45; font-size: 2.5rem;">PRODUCTS</h1>

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
                <select name="category" id="categorySelect" style="border-radius: 999px">
                    <option value="" {{ empty($activeCategory) ? 'selected' : '' }}>All Categories</option>
                    @foreach($categoryOptions as $value => $label)
                        <option value="{{ $value }}" {{ ($activeCategory ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <!-- Sort Dropdown -->
                <select name="sort" id="sortSelect" style="border-radius: 999px">
                    <option value="newest" {{ ($activeSort ?? 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="popular" {{ ($activeSort ?? '') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="highest_rated" {{ ($activeSort ?? '') === 'highest_rated' ? 'selected' : '' }}>Highest Rated</option>
                    <option value="price_low" {{ ($activeSort ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ ($activeSort ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ ($activeSort ?? '') === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                    <option value="name_desc" {{ ($activeSort ?? '') === 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                </select>

                <!-- Reset Button -->
                <button type="button" id="resetFilters" class="reset-btn">Reset</button>
            </div>
        </form>
    </div>

    <div class="products-grid">
        @forelse($products as $product)
            @php
                $imagePath = $product->image_url;
                $encodedPath = $imagePath ? implode('/', array_map('rawurlencode', explode('/', $imagePath))) : null;
                $productImageUrl = $imagePath ? asset('images/'.$encodedPath) : asset('images/placeholder.jpg');
            @endphp
            <div class="product-card"
                 data-id="{{ $product->id }}"
                 data-name="{{ strtolower($product->name) }}"
                 data-title="{{ $product->name }}"
                 data-price="{{ $product->price }}"
                 data-description="{{ $product->description ?? 'Beautiful fresh flowers for every occasion.' }}"
                 data-image="{{ $productImageUrl }}"
                 data-rating="{{ number_format($product->ratings_avg_rating ?? $product->averageRating(), 1) }}"
                 data-review-count="{{ $product->ratings_count ?? 0 }}"
            >
                <div class="product-image">
                    <img src="{{ $productImageUrl }}" alt="{{ $product->name }}">
                </div>
                <div class="product-info">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($product->description ?? 'Beautiful fresh flowers for every occasion.', 96) }}</p>
                    <p class="product-price">₱{{ number_format($product->price, 2) }}</p>
                </div>
                @if(($product->ratings_count ?? 0) > 0)
                    <div class="product-rating">
                        <span class="rating-star">★</span>
                        <span class="rating-value">{{ number_format($product->ratings_avg_rating ?? $product->averageRating(), 1) }}</span>
                        <span class="rating-count">({{ $product->ratings_count }})</span>
                    </div>
                @endif
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                <p style="font-size: 1.1rem; margin: 0;">No results found or data is insufficient</p>
                <p style="font-size: 0.9rem; margin-top: 8px;">Try adjusting your filters or search terms.</p>
            </div>
        @endforelse
    </div>

    <div class="product-detail-overlay" id="productDetailOverlay" style="display:none;">
        <div class="product-detail-card">
            <button type="button" class="product-detail-close" id="overlayCloseBtn" aria-label="Close detail modal">×</button>
            <div class="product-detail-body">
                <div class="product-detail-content">
                    <div class="product-detail-image">
                        <img id="overlayProductImage" src="" alt="Product image">
                    </div>
                    <div class="product-detail-meta">
                        <h2 id="overlayProductName">Product Name</h2>
                        <p id="overlayProductDescription">Product description goes here.</p>
                        <p class="product-detail-price" id="overlayProductPrice">₱0.00</p>
                        <div class="quantity-control">
                            <button type="button" id="overlayDecrement" class="qty-btn">−</button>
                            <input type="number" id="overlayQuantity" min="1" value="1" aria-label="Quantity">
                            <button type="button" id="overlayIncrement" class="qty-btn">+</button>
                        </div>
                        <div class="product-detail-actions">
                            <button type="button" class="btn btn-primary" id="overlayAddToCart">Add to Cart</button>
                            <button type="button" class="btn btn-secondary" id="overlayBuyNow">Buy Now</button>
                        </div>
                    </div>
                </div>

                <div class="product-review-section">
                    <div class="review-header">
                        <div class="review-summary">
                            <span class="rating-star">★</span>
                            <span id="overlayProductRatingValue">0.0</span>
                            <span id="overlayProductRatingCount">(0 reviews)</span>
                        </div>
                    </div>
                    <div class="review-list" id="overlayReviewList"></div>
                    <div class="review-pagination" id="overlayReviewPagination"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body.no-scroll {
            overflow: hidden;
        }
        .product-card {
            position: relative;
        }
        .product-rating {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.95);
            padding: 6px 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.875rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(4px);
        }
        .rating-star {
            color: #f59e0b;
            font-size: 1rem;
            line-height: 1;
        }
        .rating-value {
            font-weight: 600;
            color: #1f2937;
        }
        .rating-count {
            color: #6b7280;
            font-size: 0.75rem;
        }
        .product-detail-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(16, 12, 8, 0.65);
            padding: 20px;
        }
        .product-detail-card {
            width: min(100%, 920px);
            max-width: 920px;
            max-height: calc(100vh - 40px);
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 32px 85px rgba(16, 12, 8, 0.16);
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .product-detail-body {
            overflow-y: auto;
            max-height: calc(100vh - 40px);
            padding: 32px;
            box-sizing: border-box;
        }
        .product-detail-content {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 24px;
            margin-bottom: 28px;
        }
        .product-review-section {
            padding-top: 20px;
            border-top: 1px solid #efe9e6;
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }
        .review-header h3 {
            margin: 0;
            color: #3d1c29;
        }
        .review-summary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #54303c;
            font-weight: 600;
        }
        .review-list {
            display: grid;
            gap: 14px;
        }
        .review-item,
        .review-empty {
            background: #f7f2ef;
            border-radius: 20px;
            padding: 18px;
            color: #4f3d3b;
            line-height: 1.6;
        }
        .review-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }
        .review-item-header .review-author {
            color: #6b4a4f;
            font-weight: 700;
        }
        .review-item-header .review-rating {
            color: #b45309;
            font-weight: 700;
        }
        .review-item-text {
            color: #4f3d3b;
            margin: 0;
            white-space: pre-line;
        }
        .review-pagination {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 18px;
        }
        .review-page-btn {
            border: 1px solid #d9c7c2;
            background: #fff;
            color: #5b3f43;
            padding: 8px 14px;
            border-radius: 999px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .review-page-btn:hover {
            background: #f2d8d7;
        }
        .review-page-btn.active {
            background: #8d5660;
            color: #fff;
            border-color: #8d5660;
        }
        .review-item strong {
            display: block;
            margin-bottom: 8px;
            color: #3d1c29;
        }
        .product-detail-close {
            position: absolute;
            right: 18px;
            top: 18px;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: #f6f1ef;
            color: #72333e;
            font-size: 1.5rem;
            cursor: pointer;
            display: grid;
            place-items: center;
        }
        .product-detail-content {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 24px;
            padding: 32px;
        }
        .product-detail-image img {
            width: 100%;
            height: auto;
            border-radius: 24px;
            object-fit: cover;
        }
        .product-detail-meta h2 {
            margin: 0 0 14px;
            font-size: 2rem;
            letter-spacing: 0.02em;
            color: #3d1c29;
        }
        .product-detail-meta p {
            margin: 0 0 18px;
            color: #5f5b58;
            line-height: 1.75;
        }
        .product-detail-price {
            margin-top: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #7b2d38;
        }
        .quantity-control {
            display: inline-flex;
            align-items: center;
            border: 1px solid #e5e1dd;
            border-radius: 999px;
            overflow: hidden;
            margin-bottom: 22px;
        }
        .qty-btn {
            width: 44px;
            height: 44px;
            border: none;
            background: #f8f5f2;
            color: #462b2f;
            font-size: 1.5rem;
            cursor: pointer;
        }
        #overlayQuantity {
            width: 72px;
            border: none;
            outline: none;
            text-align: center;
            font-size: 1rem;
            padding: 0 10px;
        }
        .product-detail-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .product-detail-actions .btn {
            min-width: 160px;
            padding: 14px 18px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .product-detail-actions .btn:hover {
            transform: translateY(-1px);
        }
        .btn-primary {
            background: #8f3641;
            color: #fff;
        }
        .btn-secondary {
            background: #f3ece8;
            color: #4f3d3b;
        }
        @media (max-width: 880px) {
            .product-detail-content {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @if ($products->hasPages())
        <div class="pagination-wrapper">
            {{ $products->links('pagination::custom') }}
        </div>
    @endif
</div>

<script>
    const productDetailOverlay = document.getElementById('productDetailOverlay');
    const overlayImage = document.getElementById('overlayProductImage');
    const overlayName = document.getElementById('overlayProductName');
    const overlayDesc = document.getElementById('overlayProductDescription');
    const overlayPrice = document.getElementById('overlayProductPrice');
    const overlayQtyInput = document.getElementById('overlayQuantity');
    const overlayAddBtn = document.getElementById('overlayAddToCart');
    const overlayBuyBtn = document.getElementById('overlayBuyNow');
    const overlayCloseBtn = document.getElementById('overlayCloseBtn');
    const overlayDecrement = document.getElementById('overlayDecrement');
    const overlayIncrement = document.getElementById('overlayIncrement');
    const overlayRatingValue = document.getElementById('overlayProductRatingValue');
    const overlayRatingCount = document.getElementById('overlayProductRatingCount');
    const overlayReviewList = document.getElementById('overlayReviewList');
    const overlayReviewPagination = document.getElementById('overlayReviewPagination');
    const productCards = document.querySelectorAll('.product-card');
    const buttons = document.querySelectorAll('.add-to-cart');
    const isAuthenticated = "{{ Auth::check() }}" === "1";
    const buyNowStorageKey = 'fleur_buy_now_item';
    const productReviews = {!! json_encode($productReviews) !!};

    let overlayReviewPage = 1;
    let overlayReviewProductId = null;

    function anonymizeName(name) {
        if (!name || name.length <= 2) {
            return name;
        }

        const first = name.charAt(0);
        const last = name.charAt(name.length - 1);
        return `${first}${'*'.repeat(Math.max(1, name.length - 2))}${last}`;
    }

    function renderReviewStars(rating) {
        return '★'.repeat(Math.round(rating)) + '☆'.repeat(5 - Math.round(rating));
    }

    function renderOverlayReviewPage(page = 1) {
        if (!overlayReviewList || !overlayReviewPagination) return;

        const reviews = productReviews[overlayReviewProductId] || [];
        const perPage = 3;
        const totalPages = Math.max(1, Math.ceil(reviews.length / perPage));
        const currentPage = Math.min(Math.max(1, page), totalPages);
        const start = (currentPage - 1) * perPage;
        const currentReviews = reviews.slice(start, start + perPage);

        overlayReviewList.innerHTML = '';
        overlayReviewPagination.innerHTML = '';

        if (reviews.length === 0) {
            overlayReviewList.innerHTML = '<div class="review-empty">No customer reviews yet. Be the first to rate this bouquet.</div>';
            return;
        }

        currentReviews.forEach((item) => {
            overlayReviewList.innerHTML += `
                <div class="review-item">
                    <div class="review-item-header">
                        <span class="review-author">${anonymizeName(item.customer)}</span>
                        <span class="review-rating">${renderReviewStars(item.rating)} ${item.rating.toFixed(1)}</span>
                    </div>
                    <p class="review-item-text">${item.review ? item.review : 'No written review provided.'}</p>
                </div>
            `;
        });

        if (totalPages > 1) {
            for (let i = 1; i <= totalPages; i += 1) {
                overlayReviewPagination.innerHTML += `
                    <button type="button" class="review-page-btn ${i === currentPage ? 'active' : ''}" data-review-page="${i}">${i}</button>
                `;
            }
        }
    }

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

    function addToCart(name, price, image, qty = 1) {
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
                qty: parseInt(qty, 10) || 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                window.dispatchEvent(new CustomEvent('cart-updated'));
                // Show success message
                const btn = document.querySelector(`[data-name="${name}"]`);
                if (btn) {
                    const original = btn.textContent;
                    btn.textContent = 'Added';
                    setTimeout(() => { btn.textContent = original; }, 900);
                }
                if (qty && productDetailOverlay && productDetailOverlay.style.display === 'flex') {
                    overlayClose();
                }
            } else {
                alert('Failed to add to cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding to cart');
        });
    }

    function overlayClose() {
        if (!productDetailOverlay) return;
        productDetailOverlay.style.display = 'none';
        document.body.classList.remove('no-scroll');
    }

    function openProductOverlay(card) {
        const name = card.dataset.title || card.dataset.name;
        const price = parsePrice(card.dataset.price || '0');
        const image = card.dataset.image;
        const description = card.dataset.description || 'Beautiful fresh flowers for every occasion.';
        const productId = card.dataset.id;
        const rating = parseFloat(card.dataset.rating || '0');
        const reviews = productReviews[productId] || [];
        const reviewCount = reviews.length;

        overlayImage.src = image;
        overlayImage.alt = name;
        overlayName.textContent = name;
        overlayDesc.textContent = description;
        overlayPrice.textContent = `₱${price.toFixed(2)}`;
        overlayQtyInput.value = 1;
        overlayQtyInput.dataset.productName = name;
        overlayQtyInput.dataset.productPrice = price;
        overlayQtyInput.dataset.productImage = image;

        overlayReviewProductId = productId;
        overlayReviewPage = 1;

        if (overlayRatingValue) {
            overlayRatingValue.textContent = rating.toFixed(1);
        }
        if (overlayRatingCount) {
            overlayRatingCount.textContent = `(${reviewCount} review${reviewCount === 1 ? '' : 's'})`;
        }
        renderOverlayReviewPage(1);

        // Track product view
        if (productId) {
            fetch(`/api/product/${productId}/view`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).catch(() => {});
        }

        if (productDetailOverlay) {
            productDetailOverlay.style.display = 'flex';
            document.body.classList.add('no-scroll');
        }
    }

    function setOverlayQuantity(value) {
        const qty = Math.max(1, parseInt(value, 10) || 1);
        overlayQtyInput.value = qty;
    }

    function overlayBuyNow() {
        if (!isAuthenticated) {
            showLoginRequiredOverlay();
            return;
        }

        const name = overlayQtyInput.dataset.productName;
        const price = parsePrice(overlayQtyInput.dataset.productPrice || '0');
        const image = overlayQtyInput.dataset.productImage;
        const qty = parseInt(overlayQtyInput.value, 10) || 1;

        localStorage.setItem(buyNowStorageKey, JSON.stringify({
            name,
            price,
            image,
            qty,
        }));

        window.location.href = "{{ route('checkout') }}?buy_now=1";
    }

    function handleAddToCartClick(btn) {
        btn.addEventListener('click', (event) => {
            event.stopPropagation();
            const name = btn.dataset.name;
            const price = parsePrice(btn.dataset.price || '0');
            const image = btn.dataset.image;

            addToCart(name, price, image);
        });
    }

function attachCardDetailListeners() {
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', (event) => {
                if (event.target.closest('.product-btn')) {
                    return;
                }
                openProductOverlay(card);
            });
        });
    }

    function attachCartButtons() {
        const newButtons = document.querySelectorAll('.add-to-cart');
        newButtons.forEach(handleAddToCartClick);
    }

    buttons.forEach(handleAddToCartClick);
    attachCardDetailListeners();

    if (overlayCloseBtn) overlayCloseBtn.addEventListener('click', overlayClose);
    if (productDetailOverlay) {
        productDetailOverlay.addEventListener('click', (event) => {
            if (event.target === productDetailOverlay) {
                overlayClose();
            }
        });
    }

    if (overlayReviewPagination) {
        overlayReviewPagination.addEventListener('click', (event) => {
            const button = event.target.closest('[data-review-page]');
            if (!button) return;
            const page = parseInt(button.dataset.reviewPage, 10);
            if (!Number.isNaN(page)) {
                overlayReviewPage = page;
                renderOverlayReviewPage(page);
            }
        });
    }
    if (overlayDecrement) overlayDecrement.addEventListener('click', () => setOverlayQuantity(parseInt(overlayQtyInput.value, 10) - 1));
    if (overlayIncrement) overlayIncrement.addEventListener('click', () => setOverlayQuantity(parseInt(overlayQtyInput.value, 10) + 1));
    if (overlayAddBtn) overlayAddBtn.addEventListener('click', () => {
        const name = overlayQtyInput.dataset.productName;
        const price = parsePrice(overlayQtyInput.dataset.productPrice || '0');
        const image = overlayQtyInput.dataset.productImage;
        const qty = parseInt(overlayQtyInput.value, 10) || 1;
        addToCart(name, price, image, qty);
    });
    if (overlayBuyBtn) overlayBuyBtn.addEventListener('click', overlayBuyNow);

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            overlayClose();
        }
    });

    window.addEventListener('load', refreshCartCount);
    refreshCartCount();

    // Automatic filtering, searching, and sorting
    let filterTimeout;
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const resetButton = document.getElementById('resetFilters');
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
            } else if (!newPagination && currentPagination) {
                currentPagination.remove();
            }
            
            if (newGrid && currentGrid) {
                // Reattach event listeners to new buttons and product cards
                attachCartButtons();
                attachCardDetailListeners();
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

    const categorySelect = document.getElementById('categorySelect');

    sortSelect.addEventListener('change', applyFilters);
    categorySelect.addEventListener('change', applyFilters);
    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        categorySelect.value = '';
        sortSelect.value = 'newest';
        applyFilters();
    });

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
