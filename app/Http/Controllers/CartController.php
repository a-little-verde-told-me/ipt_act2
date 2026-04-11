<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->get(['id', 'product_name', 'price', 'image_url', 'qty']);

        return response()->json($cartItems);
    }

    public function getCount()
    {
        $count = Cart::where('user_id', Auth::id())->sum('qty');

        return response()->json(['count' => $count]);
    }

    public function addToCart(Request $request)
    {
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
    }

    public function updateQty(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart->update(['qty' => $request->qty]);

        return response()->json(['status' => 'updated', 'qty' => $cart->qty]);
    }

    public function removeItem(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return response()->json(['status' => 'removed']);
    }

    public function clearCart()
    {
        Cart::where('user_id', Auth::id())->delete();

        return response()->json(['status' => 'cleared']);
    }
}
