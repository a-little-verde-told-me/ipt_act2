<?php
require 'bootstrap/app.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::all();
foreach ($products as $product) {
    $product->update([
        'rating' => round(rand(35, 50) / 10, 1),
        'rating_count' => rand(50, 200)
    ]);
}
echo "Sample ratings added to " . $products->count() . " products\n";
