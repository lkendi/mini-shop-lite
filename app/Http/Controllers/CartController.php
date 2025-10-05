<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $cart = $this->cart->all();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        $success = $this->cart->add($product, $quantity);

        if (!$success) {
            return redirect()->back()->with('error', 'Not enough stock to add item to cart.');
        }

        return redirect()->back()->with('success', 'Item added to cart.');
    }

    public function remove($id)
    {
        $this->cart->remove($id);
        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    public function clear()
    {
        $this->cart->clear();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $success = $this->cart->update($id, $request->quantity);

        if (!$success) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available.'], 422);
        }

        return response()->json(['success' => true]);
    }
}
