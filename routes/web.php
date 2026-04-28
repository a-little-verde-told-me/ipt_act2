<?php

use App\Models\User;
use App\Models\Flower;
use App\Models\Event;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductRating;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminFlowerController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::limit(4)->get();
    return view('home', ['featuredProducts' => $featuredProducts]);
})->name('home'); 

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/flowers', function (Request $request) {
    $perPage = 10;
    $paginated = Flower::paginate($perPage);
    $allFlowers = Flower::all()->toArray();

    return view('flowers', ['flowers' => $paginated, 'allFlowers' => $allFlowers]);
})->name('flowers');

Route::get('/gallery', function (Request $request) {
    $perPage = 10;
    $paginated = Event::paginate($perPage);

    return view('gallery', ['events' => $paginated]);
})->name('gallery');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/customize', function (Request $request) {
    $success = $request->session()->get('customize_success', false);
    $loginRequired = $request->session()->get('customize_login_required', false);
    return view('customize', ['success' => $success, 'loginRequired' => $loginRequired]);
})->name('customize');

Route::post('/customize', function (Request $request) {
    if (!Auth::check()) {
        $request->session()->flash('customize_login_required', true);
        return redirect()->route('customize');
    }

    $request->validate([
        'occasion' => 'required|string',
        'budget' => 'required|string',
        'flowers' => 'required|string',
        'colors' => 'required|string',
        'notes' => 'nullable|string',
    ]);

    $request->session()->flash('customize_success', true);
    return redirect()->route('customize');
})->name('customize.submit');

    $viewsDir = resource_path('views');
    $files = glob($viewsDir.'/*.blade.php') ?: [];
    $items = [];
    $id = 1;
    $stopwords = ['the', 'and', 'for', 'with', 'from', 'this', 'that', 'have', 'your', 'page', 'order', 'product', 'flower', 'gallery', 'see'];

    foreach ($files as $file) {
        $viewName = basename($file, '.blade.php');
        if (!isset($viewMap[$viewName])) {
            continue;
        }
        $raw = file_get_contents($file) ?: '';
        $raw = preg_replace('/<script\\b[^>]*>.*?<\\/script>/is', ' ', $raw);
        $raw = preg_replace('/<style\\b[^>]*>.*?<\\/style>/is', ' ', $raw);
        $raw = preg_replace('/{{.*?}}/s', ' ', $raw);
        $raw = preg_replace('/@\\w+\\b[^\\n]*/', ' ', $raw);
        $text = trim(preg_replace('/\\s+/', ' ', strip_tags($raw)));

        $title = ucfirst($viewName);
        if (preg_match("/@section\\('title',\\s*'([^']+)'\\)/", $raw, $m)) {
            $title = $m[1];
        } elseif (preg_match('/<title>([^<]+)<\\/title>/', $raw, $m)) {
            $title = trim($m[1]);
        }

        $blurb = $text !== '' ? mb_substr($text, 0, 160) : 'Page content for '.$title.'.';

        $words = preg_split('/[^a-zA-Z0-9]+/', strtolower($text), -1, PREG_SPLIT_NO_EMPTY);
        $freq = [];
        foreach ($words as $w) {
            if (strlen($w) < 3 || in_array($w, $stopwords, true)) {
                continue;
            }
            $freq[$w] = ($freq[$w] ?? 0) + 1;
        }
        arsort($freq);
        $keywords = implode(' ', array_slice(array_keys($freq), 0, 12));

        $items[] = [
            'id' => $id++,
            'title' => $title,
            'blurb' => $blurb,
            'url' => $viewMap[$viewName],
            'keywords' => $keywords,
        ];
    }

    // Add real items from Flowers catalog (names in flowers.blade.php)
    $flowersFile = $viewsDir.DIRECTORY_SEPARATOR.'flowers.blade.php';
    if (is_file($flowersFile)) {
        $flowerRaw = file_get_contents($flowersFile) ?: '';
        if (preg_match_all("/\\['image'\\s*=>\\s*'([^']+)'\\s*,\\s*'name'\\s*=>\\s*'([^']+)'\\]/", $flowerRaw, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $name = $m[2];
                $items[] = [
                    'id' => $id++,
                    'title' => $name,
                    'blurb' => 'Flower available in our catalog.',
                    'url' => '/flowers',
                    'keywords' => strtolower($name).' flower bouquet',
                ];
            }
        }
    }

    // Add real items from Gallery events (names in gallery.blade.php)
    $galleryFile = $viewsDir.DIRECTORY_SEPARATOR.'gallery.blade.php';
    if (is_file($galleryFile)) {
        $galleryRaw = file_get_contents($galleryFile) ?: '';
        if (preg_match_all("/'name'\\s*=>\\s*'([^']+)'\\s*,\\s*'category'\\s*=>\\s*'([^']+)'\\s*,\\s*'image'\\s*=>\\s*'[^']+'\\s*,\\s*'slug'\\s*=>\\s*'([^']+)'/", $galleryRaw, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $eventName = $m[1];
                $category = $m[2];
                $slug = $m[3];
                $items[] = [
                    'id' => $id++,
                    'title' => $eventName,
                    'blurb' => $category.' event gallery.',
                    'url' => '/view-gallery/'.$slug,
                    'keywords' => strtolower($eventName).' '.$category.' gallery event',
                ];
            }
        }
    }

    // Add real items from Products list (names in product.blade.php)
    $productFile = $viewsDir.DIRECTORY_SEPARATOR.'product.blade.php';
    if (is_file($productFile)) {
        $productRaw = file_get_contents($productFile) ?: '';
        if (preg_match_all("/\\['name'\\s*=>\\s*'([^']+)'\\s*,\\s*'price'\\s*=>\\s*'([^']+)'\\s*,\\s*'image'\\s*=>\\s*'[^']+'\\]/", $productRaw, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $name = $m[1];
                $price = $m[2];
                $items[] = [
                    'id' => $id++,
                    'title' => $name,
                    'blurb' => 'Product price: '.$price.'.',
                    'url' => '/product',
                    'keywords' => strtolower($name).' product bouquet '.$price,
                ];
            }
        }
    }

Route::get('/view-gallery/{event}', function (Request $request, string $event) {
    $perPage = 9;
    $eventData = Event::where('slug', $event)->first();
    $images = null;

    if ($eventData) {
        $images = $eventData->images()->paginate($perPage)->appends($request->except('page'));
    }

    return view('viewgallery', [
        'event' => $eventData,
        'images' => $images,
    ]);
})->name('gallery.view');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    $user = Auth::user();
    return view('checkout', ['user' => $user]);
})->name('checkout');

Route::post('/checkout', function (Request $request) {
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('login')->with('error', 'Please log in before placing your order.');
    }

    $request->validate([
        'full_name' => 'required|string|max:255',
        'phone' => 'required|string|max:50',
        'address' => 'required|string|max:1000',
        'notes' => 'nullable|string|max:1000',
        'selected_items' => 'nullable|string',
        'buy_now_item' => 'nullable|string',
    ]);

    $selectedItems = json_decode($request->input('selected_items', '[]'), true);
    $buyNowItem = json_decode($request->input('buy_now_item', 'null'), true);
    $orderItems = [];
    $selectedIds = [];

    if (is_array($buyNowItem) && ! empty($buyNowItem['name']) && ! empty($buyNowItem['price']) && ! empty($buyNowItem['qty'])) {
        $orderItems[] = [
            'product_name' => $buyNowItem['name'],
            'price' => floatval($buyNowItem['price']),
            'qty' => intval($buyNowItem['qty']),
            'image_url' => $buyNowItem['image'] ?? null,
        ];
    }

    if (empty($orderItems) && is_array($selectedItems) && count($selectedItems) > 0) {
        $selectedIds = array_values(array_filter($selectedItems, function ($id) {
            return is_numeric($id);
        }));

        if (count($selectedIds) > 0) {
            $cartItems = \App\Models\Cart::where('user_id', Auth::id())
                ->whereIn('id', $selectedIds)
                ->get(['id', 'product_name', 'price', 'image_url', 'qty']);

            foreach ($cartItems as $item) {
                $orderItems[] = [
                    'product_name' => $item->product_name,
                    'price' => $item->price,
                    'qty' => $item->qty,
                    'image_url' => $item->image_url,
                    'cart_id' => $item->id,
                ];
            }
        }
    }

    if (count($orderItems) === 0) {
        return redirect()->route('checkout')->with('error', 'Please select at least one item before placing your order.');
    }

    $subtotal = 0;
    foreach ($orderItems as $item) {
        $subtotal += $item['price'] * $item['qty'];
    }

    $shipping = $subtotal > 0 ? 150 : 0;
    $total = $subtotal + $shipping;

    $order = Order::create([
        'user_id' => $user->id,
        'full_name' => $request->input('full_name'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'notes' => $request->input('notes'),
        'status' => 'processing',
        'subtotal' => $subtotal,
        'shipping_cost' => $shipping,
        'total' => $total,
    ]);

    foreach ($orderItems as $item) {
        $order->items()->create([
            'product_name' => $item['product_name'],
            'price' => $item['price'],
            'qty' => $item['qty'],
            'image_url' => $item['image_url'] ?? null,
        ]);
    }

    if (count($selectedIds) > 0) {
        \App\Models\Cart::where('user_id', Auth::id())
            ->whereIn('id', $selectedIds)
            ->delete();
    }

    return redirect()->route('order')->with('success', 'Your order has been placed successfully.');
})->name('checkout.submit');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'login' => ['required', 'string', 'min:5', 'max:50'],
        'password' => ['required', 'string', 'min:8', 'max:20'],
    ]);

    $login = $request->input('login');

    if ($login === 'admin@gmail.com' && $request->password === 'admin123') {
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'age' => 30,
                'gender' => 'Other',
                'civil_status' => 'Single',
                'mobile' => '09990000000',
                'address' => 'Admin Office Address',
                'zip' => '0000',
            ]
        );

        Auth::login($user);
        return redirect()->route('admin.products.index')->with('success', 'Welcome back, admin '.$user->name.'!');
    }

    $user = filter_var($login, FILTER_VALIDATE_EMAIL)
        ? User::where('email', $login)->first()
        : User::where('username', $login)->first();

    if (! $user) {
        return back()
            ->withInput($request->only('login'))
            ->with('error', 'No account found with that email or username. Please register first.');
    }

    if (! Hash::check($request->password, $user->password)) {
        return back()
            ->withInput($request->only('login'))
            ->with('error', 'Invalid password. Please try again.');
    }

    Auth::login($user);

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, admin '.$user->name.'!');
    }

    return redirect()->route('profile')->with('success', 'Welcome back, '.$user->name.'!');
})->name('login.submit');

Route::get('/registration', function () {
    return view('registration');
})->name('registration');

Route::post('/registration', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'min:2', 'regex:/^[A-Za-z ]+$/'],
        'username' => ['required', 'string', 'min:5', 'max:15', 'regex:/^[A-Za-z][A-Za-z0-9_]{4,14}$/', 'unique:users,username'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8', 'max:20', "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[^\\s'\"]{8,20}$/"],
        'confirm_password' => ['required', 'same:password'],
        'age' => ['required', 'integer', 'between:18,60'],
        'gender' => ['required', 'in:Male,Female,Other'],
        'civil_status' => ['required', 'in:Single,Married,Separated,Widowed'],
        'mobile' => ['required', 'regex:/^09\d{9}$/'],
        'address' => ['required', 'string', 'min:50'],
        'zip' => ['required', 'regex:/^\d{4}$/'],
    ], [
        'name.regex' => 'Full name may only contain letters and spaces.',
        'username.regex' => 'Username must start with a letter and contain only letters, numbers, and underscore.',
        'password.regex' => 'Password must be 8-20 chars, include uppercase, lowercase, and a number.',
        'confirm_password.same' => 'Passwords do not match.',
        'mobile.regex' => 'Mobile number must be 11 digits and start with 09.',
        'zip.regex' => 'ZIP code must be exactly 4 digits.',
    ]);

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'age' => $request->age,
        'gender' => $request->gender,
        'civil_status' => $request->civil_status,
        'mobile' => $request->mobile,
        'address' => $request->address,
        'zip' => $request->zip,
    ]);

    Auth::login($user);

    return redirect()->route('profile')->with('success', 'Account created successfully. You are now logged in.');
})->name('registration.submit');

Route::get('/product', [\App\Http\Controllers\ProductController::class, 'index'])->name('product');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        if (! Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/flowers', [AdminFlowerController::class, 'index'])->name('flowers.index');
    Route::get('/flowers/create', [AdminFlowerController::class, 'create'])->name('flowers.create');
    Route::post('/flowers', [AdminFlowerController::class, 'store'])->name('flowers.store');
    Route::get('/flowers/{flower}/edit', [AdminFlowerController::class, 'edit'])->name('flowers.edit');
    Route::put('/flowers/{flower}', [AdminFlowerController::class, 'update'])->name('flowers.update');
    Route::delete('/flowers/{flower}', [AdminFlowerController::class, 'destroy'])->name('flowers.destroy');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [AdminEventController::class, 'create'])->name('events.create');
    Route::post('/events', [AdminEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [AdminEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [AdminEventController::class, 'destroy'])->name('events.destroy');
});

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home')
        ->with('success', 'You have been logged out successfully.')
        ->with('clear_cart', true);
})->name('logout');

Route::get('/order', function (Request $request) {
    $query = Order::where('user_id', Auth::id())->with('items');

    if ($request->filled('status') && array_key_exists($request->status, Order::statuses())) {
        $query->where('status', $request->status);
    }

    $orders = $query->orderBy('created_at', 'desc')->get();

    $productNames = $orders->flatMap(function ($order) {
        return $order->items->pluck('product_name');
    })->unique()->values()->all();

    $productsByName = Product::whereIn('name', $productNames)
        ->get()
        ->keyBy('name');

    $ratedOrderItemIds = ProductRating::where('user_id', Auth::id())
        ->pluck('order_item_id')
        ->toArray();

    return view('order', [
        'orders' => $orders,
        'productsByName' => $productsByName,
        'ratedOrderItemIds' => $ratedOrderItemIds,
        'selectedStatus' => $request->query('status', ''),
    ]);
})->middleware('auth')->name('order');

Route::post('/order/{order}/rate', function (Request $request, Order $order) {
    if ($order->user_id !== Auth::id()) {
        abort(403, 'Unauthorized.');
    }

    if ($order->status !== 'completed') {
        return back()->with('error', 'You can only rate products for completed orders.');
    }

    $request->validate([
        'order_item_id' => 'required|integer',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:1000',
    ]);

    $item = $order->items()->where('id', $request->order_item_id)->first();

    if (! $item) {
        return back()->with('error', 'Order item not found.');
    }

    $product = Product::where('name', $item->product_name)->first();

    if (! $product) {
        return back()->with('error', 'Unable to rate this item because the product is no longer available.');
    }

    ProductRating::updateOrCreate(
        [
            'order_item_id' => $item->id,
        ],
        [
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]
    );

    return back()->with('success', 'Thank you for rating the product.');
})->middleware('auth')->name('order.rate');

Route::post('/order/{order}/received', function (Request $request, Order $order) {
    if ($order->user_id !== Auth::id()) {
        abort(403, 'Unauthorized.');
    }

    if ($order->status !== 'delivered') {
        return back()->with('error', 'Order must be delivered before you can confirm receipt.');
    }

    $order->update(['status' => 'completed']);

    return back()->with('success', 'Order confirmed received. You can now rate the product.');
})->middleware('auth')->name('order.received');

Route::middleware('auth')->prefix('api/cart')->group(function () {
    Route::get('/', [CartController::class, 'getCart'])->name('api.cart.get');
    Route::get('/count', [CartController::class, 'getCount'])->name('api.cart.count');
    Route::post('/', [CartController::class, 'addToCart'])->name('api.cart.add');
    Route::put('/{cart}', [CartController::class, 'updateQty'])->name('api.cart.update');
    Route::delete('/{cart}', [CartController::class, 'removeItem'])->name('api.cart.remove');
    Route::delete('/', [CartController::class, 'clearCart'])->name('api.cart.clear');
});

Route::prefix('api/product')->group(function () {
    Route::post('/{product}/view', [\App\Http\Controllers\ProductController::class, 'trackView']);
});
