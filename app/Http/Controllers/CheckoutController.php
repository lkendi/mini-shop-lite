<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(Request $request)
    {
        $cart = $this->cartService->all();

        if ($cart['count'] === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = null;

        try {
            DB::transaction(function () use ($cart, &$order) {
                $totalAmount = $cart['total'];

                $order = Auth::user()->orders()->create([
                    'total_amount' => $totalAmount
                ]);

                foreach ($cart['items'] as $productId => $item) {
                    $product = Product::find($productId);

                    if ($product->stock < $item['quantity']) {
                        throw new \Exception('Product ' . $product->name . ' is out of stock.');
                    }

                    $order->items()->create([
                        'product_id' => $productId,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                        'line_total' => $item['price'] * $item['quantity'],
                    ]);

                    $product->decrement('stock', $item['quantity']);
                }

                $this->cartService->clear();
            });
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }
}
