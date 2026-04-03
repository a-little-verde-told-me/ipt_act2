@extends('headerfooter')

@section('title', 'Products | FLEUR')

@section('content')
<div class="products-page">
    <h1>PRODUCTS</h1>

    <div class="products-grid">
        @php
            $products = [
                ['name' => 'Blush Rose Bouquet', 'price' => 'PHP 2,200', 'image' => 'flower1.jpg'],
                ['name' => 'Sunset Tulip Bundle', 'price' => 'PHP 1,900', 'image' => 'flower2.jpg'],
                ['name' => 'Lavender Dream', 'price' => 'PHP 2,500', 'image' => 'flower3.jpg'],
                ['name' => 'Classic Red Roses', 'price' => 'PHP 2,300', 'image' => 'flower4.jpg'],
                ['name' => 'Golden Sunflower Set', 'price' => 'PHP 1,700', 'image' => 'flower5.jpg'],
                ['name' => 'Orchid Luxe', 'price' => 'PHP 2,900', 'image' => 'flower6.jpg'],
                ['name' => 'Peony Garden Vase', 'price' => 'PHP 2,700', 'image' => 'flower7.jpg'],
                ['name' => 'Spring Wildflowers', 'price' => 'PHP 1,800', 'image' => 'flower8.jpg'],
            ];
        @endphp

        @foreach($products as $product)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ asset('images/'.$product['image']) }}" alt="{{ $product['name'] }}">
                </div>
                <div class="product-info">
                    <h3>{{ $product['name'] }}</h3>
                    <p class="product-price">{{ $product['price'] }}</p>
                    <button
                        class="product-btn add-to-cart"
                        type="button"
                        data-name="{{ $product['name'] }}"
                        data-price="{{ $product['price'] }}"
                        data-image="{{ asset('images/'.$product['image']) }}"
                    >Add to Cart</button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    const cartKey = 'fleur_cart';
    const buttons = document.querySelectorAll('.add-to-cart');

    function parsePrice(priceText) {
        const numeric = priceText.replace(/[^0-9.]/g, '');
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
