<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products with filtering and sorting.
     */
    public function index(Request $request)
    {
        if (Product::count() === 0) {
            Product::insert([
                [
                    'name' => 'Sweet Petals',
                    'category' => 'Signature',
                    'price' => 1299.00,
                    'image_url' => 'sweet_petals.jpg',
                    'description' => 'Soft pink petals arranged for a delicate and romantic gift.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'White Rose Elegance',
                    'category' => 'Classic',
                    'price' => 1599.00,
                    'image_url' => 'white_rose.jpg',
                    'description' => 'A timeless bouquet of white roses for elegant celebrations.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Rosy Charm',
                    'category' => 'Romantic',
                    'price' => 1399.00,
                    'image_url' => 'rosy_charm.jpg',
                    'description' => 'A charming mix of rosy blooms perfect for special moments.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pink Delight',
                    'category' => 'Fresh Picks',
                    'price' => 1499.00,
                    'image_url' => 'pink_delight.jpg',
                    'description' => 'A cheerful pink arrangement with modern floral accents.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        $query = Product::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        // Search by product name (case-insensitive)
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        // Sort by price
        $sort = $request->get('sort', 'default');
        if ($sort === 'price_high') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'price_low') {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->get();

        // Get unique categories for the filter dropdown
        $categories = Product::distinct()->pluck('category')->sort()->values();

        return view('product', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $request->get('category'),
            'activeSearch' => $request->get('search'),
            'activeSort' => $sort,
        ]);
    }
}
