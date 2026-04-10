<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function items()
    {
        if (!auth()->check()) {
            return response()->json([
                'items' => [],
                'subtotal' => 0,
                'shipping' => 0,
                'total' => 0,
            ]);
        }

        $items = CartItem::where('user_id', auth()->id())->get();
        $subtotal = $items->sum(fn ($item) => $item->price * $item->quantity);
        $shipping = $items->count() ? 150 : 0;

        return response()->json([
            'items' => $items,
            'subtotal' => (float) $subtotal,
            'shipping' => (float) $shipping,
            'total' => (float) ($subtotal + $shipping),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = CartItem::where('user_id', auth()->id());
        if (!empty($validated['product_id'])) {
            $query->where('product_id', $validated['product_id']);
        } else {
            $query->where('name', $validated['name']);
        }

        $item = $query->first();
        $qty = $validated['quantity'] ?? 1;

        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            $item = CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'] ?? null,
                'name' => $validated['name'],
                'price' => $validated['price'],
                'image_url' => $validated['image_url'] ?? null,
                'quantity' => $qty,
            ]);
        }

        return response()->json(['item' => $item], 201);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $item = CartItem::where('user_id', auth()->id())->findOrFail($id);
        if ($validated['quantity'] === 0) {
            $item->delete();
        } else {
            $item->quantity = $validated['quantity'];
            $item->save();
        }

        return response()->json(['ok' => true]);
    }

    public function destroy(int $id)
    {
        $item = CartItem::where('user_id', auth()->id())->findOrFail($id);
        $item->delete();

        return response()->json(['ok' => true]);
    }
}
