<?php

use App\Models\User;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

Route::get('/flowers', function (Request $request) {
    $flowers = [
        ['image' => 'flower1.jpg', 'name' => 'Cosmos'],
        ['image' => 'flower2.jpg', 'name' => 'Indian Paintbrush'],
        ['image' => 'flower3.jpg', 'name' => 'Bluebonnet'],
        ['image' => 'flower4.jpg', 'name' => 'Wild Bergamot'],
        ['image' => 'flower5.jpg', 'name' => 'Dahlia'],
        ['image' => 'flower6.jpg', 'name' => 'Zinnia'],
        ['image' => 'flower7.jpg', 'name' => 'Ranunculus'],
        ['image' => 'flower8.jpg', 'name' => 'Larkspur'],
        ['image' => 'flower9.jpg', 'name' => 'Chrysanthemum'],
        ['image' => 'flower10.jpg', 'name' => 'Anemone'],
        ['image' => 'flower11.jpg', 'name' => 'Celosia'],
        ['image' => 'flower12.jpg', 'name' => 'Gladiolus'],
        ['image' => 'flower13.jpg', 'name' => 'Gomphrena'],
        ['image' => 'flower14.jpg', 'name' => 'Sunflower'],
        ['image' => 'flower15.jpg', 'name' => 'Craspedia'],
        ['image' => 'flower16.jpg', 'name' => 'Gerbera Daisy'],
        ['image' => 'flower17.jpg', 'name' => 'Snapdragon'],
        ['image' => 'flower18.jpg', 'name' => 'Bells of Ireland'],
        ['image' => 'flower19.jpg', 'name' => 'Stock'],
        ['image' => 'flower20.jpg', 'name' => 'Strawflower'],
        ['image' => 'flower21.jpg', 'name' => 'Nigella'],
        ['image' => 'flower22.jpg', 'name' => 'Morning Glory'],
        ['image' => 'flower23.jpg', 'name' => 'Lobelia'],
        ['image' => 'flower24.jpg', 'name' => 'Verbena'],
        ['image' => 'flower25.jpg', 'name' => 'Dusty Miller'],
        ['image' => 'flower26.jpg', 'name' => 'Sweet Alyssum'],
        ['image' => 'flower27.jpg', 'name' => 'Browallia'],
        ['image' => 'flower28.jpg', 'name' => 'Torenia'],
        ['image' => 'flower29.jpg', 'name' => 'Gazania'],
        ['image' => 'flower30.jpg', 'name' => 'Nicotiana'],
        ['image' => 'flower31.jpg', 'name' => 'Nasturtium'],
        ['image' => 'flower32.jpg', 'name' => 'Alyssum'],
    ];

    $perPage = 20;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentItems = array_slice($flowers, ($currentPage - 1) * $perPage, $perPage);

    $paginated = new LengthAwarePaginator(
        $currentItems,
        count($flowers),
        $perPage,
        $currentPage,
        [
            'path' => $request->url(),
            'query' => $request->query(),
        ]
    );

    return view('flowers', ['flowers' => $paginated, 'allFlowers' => $flowers]);
})->name('flowers');

Route::get('/gallery', function (Request $request) {
    $events = [
        [
            'name' => 'Rustic Wedding',
            'category' => 'Weddings',
            'image' => 'rustic_wedding.jpg',
            'slug' => 'rustic-wedding',
        ],
        [
            'name' => '18th Birthday',
            'category' => 'Birthdays',
            'image' => '18th_birthday.jpg',
            'slug' => '18th-birthday',
        ],
        [
            'name' => 'Corporate Gala',
            'category' => 'Others',
            'image' => 'corporate_gala.jpg',
            'slug' => 'corporate-gala',
        ],
        [
            'name' => 'Garden Wedding',
            'category' => 'Weddings',
            'image' => 'garden_wedding.jpg',
            'slug' => 'garden-wedding',
        ],
        [
            'name' => 'Debut Celebration',
            'category' => 'Birthdays',
            'image' => 'debut_celebration.jpg',
            'slug' => 'debut-celebration',
        ],
        [
            'name' => 'Anniversary Party',
            'category' => 'Others',
            'image' => 'anniversary_party.jpg',
            'slug' => 'anniversary-party',
        ],
    ];

    $perPage = 20;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentItems = array_slice($events, ($currentPage - 1) * $perPage, $perPage);

    $paginated = new LengthAwarePaginator(
        $currentItems,
        count($events),
        $perPage,
        $currentPage,
        [
            'path' => $request->url(),
            'query' => $request->query(),
        ]
    );

    return view('gallery', ['events' => $paginated]);
})->name('gallery');



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

Route::get('/view-gallery/{event}', function (string $event) {
    return view('viewgallery', ['event' => $event]);
})->name('gallery.view');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    $user = Auth::user();
    return view('checkout', ['user' => $user]);
})->name('checkout');

Route::post('/checkout', function () {
    $user = Auth::user();
    return view('checkout', ['user' => $user, 'success' => true]);
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
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home')
        ->with('success', 'You have been logged out successfully.')
        ->with('clear_cart', true);
})->name('logout');

Route::get('/order', function () {
    return view('order');
})->name('order');

Route::middleware('auth')->prefix('api/cart')->group(function () {
    Route::get('/', [CartController::class, 'getCart'])->name('api.cart.get');
    Route::get('/count', [CartController::class, 'getCount'])->name('api.cart.count');
    Route::post('/', [CartController::class, 'addToCart'])->name('api.cart.add');
    Route::put('/{cart}', [CartController::class, 'updateQty'])->name('api.cart.update');
    Route::delete('/{cart}', [CartController::class, 'removeItem'])->name('api.cart.remove');
    Route::delete('/', [CartController::class, 'clearCart'])->name('api.cart.clear');
});
