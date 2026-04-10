<?php

use App\Models\User;
use App\Models\Cart;
use App\Http\Controllers\AdminProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home'); 

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/flowers', function () {
    return view('flowers');
})->name('flowers');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/search', function (\Illuminate\Http\Request $request) {
    $query = trim((string) $request->query('q', ''));
    $page = max(1, (int) $request->query('page', 1));
    $perPage = 10;

    $viewMap = [
        'home' => route('home'),
        'about' => route('about'),
        'contact' => route('contact'),
        'flowers' => route('flowers'),
        'gallery' => route('gallery'),
        'login' => route('login'),
        'registration' => route('registration'),
        'product' => route('product'),
        'profile' => route('profile'),
        'order' => route('order'),
        'cart' => route('cart'),
        'checkout' => route('checkout'),
        'search' => route('search'),
        'filter' => route('filter'),
        // View gallery is dynamic; include a sample entry.
        'viewgallery' => route('gallery.view', ['event' => 'rustic-wedding']),
    ];

    $stopwords = [
        'the','and','for','with','this','that','your','you','from','into','our','are','was','were',
        'has','have','will','shall','also','more','only','not','but','than','then','them','they',
        'about','page','form','contact','home','gallery','flowers','search','filter','login','registration'
    ];

    $viewsDir = resource_path('views');
    $files = glob($viewsDir.'/*.blade.php') ?: [];
    $items = [];
    $id = 1;

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
                    'url' => route('flowers'),
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
                    'url' => route('gallery.view', ['event' => $slug]),
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
                    'url' => route('product'),
                    'keywords' => strtolower($name).' product bouquet '.$price,
                ];
            }
        }
    }

    $results = $items;
    $tokens = [];

    if ($query !== '') {
        $tokens = preg_split('/\s+/', strtolower($query));
        $results = array_filter($items, function ($item) use ($tokens) {
            $hay = strtolower($item['title'].' '.$item['blurb'].' '.$item['keywords']);
            foreach ($tokens as $token) {
                if ($token === '') {
                    continue;
                }
                if (str_contains($hay, $token)) {
                    return true;
                }
            }
            return false;
        });
    }

    $scored = array_map(function ($item) use ($tokens) {
        $score = 0;
        $hay = strtolower($item['title'].' '.$item['keywords']);
        foreach ($tokens as $token) {
            if ($token === '') {
                continue;
            }
            if (str_contains($hay, $token)) {
                $score++;
            }
        }
        $item['score'] = $score;
        return $item;
    }, $results);

    usort($scored, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    $total = count($scored);
    $totalPages = max(1, (int) ceil($total / $perPage));
    $page = min($page, $totalPages);
    $offset = ($page - 1) * $perPage;
    $paged = array_slice($scored, $offset, $perPage);

    return view('search', [
        'query' => $query,
        'items' => $items,
        'results' => $paged,
        'page' => $page,
        'total' => $total,
        'totalPages' => $totalPages,
        'perPage' => $perPage,
    ]);
})->name('search');

Route::get('/filter', function () {
    return view('filter');
})->name('filter');

Route::get('/view-gallery/{event}', function (string $event) {
    return view('viewgallery', ['event' => $event]);
})->name('gallery.view');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::post('/checkout', function () {
    return view('checkout', ['success' => true]);
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
        return redirect()->route('admin.products.index')->with('success', 'Welcome back, admin '.$user->name.'!');
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
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::post('/logout', function (Request $request) {
    if (Auth::check()) {
        Cart::where('user_id', Auth::id())->delete();
    }
    
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home')->with('success', 'You have been logged out successfully.');
})->name('logout');

Route::get('/order', function () {
    return view('order');
})->name('order');

Route::middleware('auth')->group(function () {
    Route::get('/api/cart', function () {
        $cartItems = Cart::where('user_id', Auth::id())->get()->map(function ($item) {
            return [
                'name' => $item->product_name,
                'price' => (float) $item->price,
                'image' => $item->image_url,
                'qty' => $item->qty,
            ];
        })->values()->all();

        return response()->json($cartItems);
    })->name('api.cart.get');

    Route::post('/api/cart', function (Request $request) {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image_url' => 'required|string|max:1000',
            'qty' => 'required|integer|min:1',
        ]);

        $existing = Cart::where('user_id', Auth::id())
            ->where('product_name', $request->product_name)
            ->first();

        if ($existing) {
            $existing->increment('qty', $request->qty);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_name' => $request->product_name,
                'price' => $request->price,
                'image_url' => $request->image_url,
                'qty' => $request->qty,
            ]);
        }

        return response()->json(['status' => 'added']);
    })->name('api.cart.add');

    Route::delete('/api/cart', function () {
        Cart::where('user_id', Auth::id())->delete();
        return response()->json(['status' => 'cleared']);
    })->name('api.cart.clear');
});
