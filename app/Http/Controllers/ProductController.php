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
        $query = Product::query();

        // Search by product name (case-insensitive)
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        // Category filter options
        $categoryMap = [
            'bouquets' => 'Bouquet',
            'ribbons' => 'Ribbons',
            'wrapping_paper' => 'Wrapping Paper',
            'sweet_treats' => 'Sweet Treats',
        ];

        $activeCategory = $request->query('category');
        if ($activeCategory && isset($categoryMap[$activeCategory])) {
            $query->where('category', $categoryMap[$activeCategory]);
        }

        // Sort logic
        $sort = $request->query('sort', 'newest');
        if ($sort === 'highest_rated') {
            $query->withAvg('ratings', 'rating')
                ->orderBy('ratings_avg_rating', 'desc');
        } else {
            match($sort) {
                'popular' => $query->orderBy('views', 'desc'),
                'price_low' => $query->orderBy('price', 'asc'),
                'price_high' => $query->orderBy('price', 'desc'),
                'name_asc' => $query->orderBy('name', 'asc'),
                'name_desc' => $query->orderBy('name', 'desc'),
                default => $query->orderBy('created_at', 'desc'),
            };
        }

        $perPage = 10;
        $products = $query->paginate($perPage)->appends($request->except('page'));

        return view('product', [
            'products' => $products,
            'activeSearch' => $request->query('search'),
            'activeSort' => $sort,
            'activeCategory' => $activeCategory,
            'categoryOptions' => $categoryMap,
        ]);
    }

    /**
     * Track product view for popularity sorting.
     */
    public function trackView(Product $product)
    {
        $product->increment('views');
        return response()->json(['status' => 'tracked']);
    }
}
