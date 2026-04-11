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
            $query->orderBy('name', 'asc');
        }

        $products = $query->get();

        // Get unique categories for the filter dropdown
        $categories = Product::distinct()->pluck('category')->sort()->values();

        // Check if this is an AJAX request
        if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('product', [
                'products' => $products,
                'categories' => $categories,
                'activeCategory' => $request->get('category'),
                'activeSearch' => $request->get('search'),
                'activeSort' => $sort,
            ]);
        }

        return view('product', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $request->get('category'),
            'activeSearch' => $request->get('search'),
            'activeSort' => $sort,
        ]);
    }
}
