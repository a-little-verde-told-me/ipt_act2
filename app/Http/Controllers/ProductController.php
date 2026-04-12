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
            $search = $request->get('search');
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        // Sort logic
        $sort = $request->get('sort', 'newest');
        match($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $perPage = 10;
        $products = $query->paginate($perPage)->appends($request->except('page'));

        return view('product', [
            'products' => $products,
            'activeSearch' => $request->get('search'),
            'activeSort' => $sort,
        ]);
    }
}
