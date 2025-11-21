<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    
    public function index()
    {
        $cart = Auth::user()->cart ?? null;
        return view('cart.index', compact('cart'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $user = Auth::user();

        // Get or create cart
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $validated['quantity']]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ]);
        }

        // Update cart total
        $cart->update(['total_price' => $cart->items()->sum('price')]);

        return redirect()->route('cart.index')->with('success', 'Item ditambahkan ke keranjang');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update($validated);

        // Update cart total
        $cart = $cartItem->cart;
        $cart->update(['total_price' => $cart->items()->sum('price')]);

        return back()->with('success', 'Jumlah item diperbarui');
    }

    /**
     * Remove item from cart
     */
    public function remove(CartItem $cartItem)
    {
        $cart = $cartItem->cart;
        $cartItem->delete();

        // Update cart total
        $cart->update(['total_price' => $cart->items()->sum('price')]);

        return back()->with('success', 'Item dihapus dari keranjang');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $cart = Auth::user()->cart;
        if ($cart) {
            $cart->items()->delete();
            $cart->update(['total_price' => 0]);
        }

        return back()->with('success', 'Keranjang dikosongkan');
    }
}
