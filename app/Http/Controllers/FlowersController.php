<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FlowersController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->whereRaw('LOWER(category) LIKE ?', ['%flower%']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $flowers = $query->orderBy('name')
            ->get()
            ->unique('name')
            ->values();

        return view('flowers', [
            'flowers' => $flowers,
            'activeSearch' => $request->input('search'),
        ]);
    }
}
