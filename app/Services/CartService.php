<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartService
{
    protected string $sessionKey = 'cart';

    public function all()
    {
        return Session::get($this->sessionKey, [
            'items' => [],
            'total' => 0,
            'count' => 0,
        ]);
    }

    public function add(Product $product, int $quantity = 1)
    {
        $cart = $this->all();
        $id = $product->id;

        $quantityInCart = $cart['items'][$id]['quantity'] ?? 0;
        $totalQuantity = $quantityInCart + $quantity;

        if ($product->stock < $totalQuantity) {
            return false;
        }

        if (isset($cart['items'][$id])) {
            $cart['items'][$id]['quantity'] = $totalQuantity;
        } else {
            $cart['items'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image_url,
            ];
        }

        $this->updateTotals($cart);
        Session::put($this->sessionKey, $cart);
        return true;
    }

    public function remove($id)
    {
        $cart = $this->all();

        if (isset($cart['items'][$id])) {
            unset($cart['items'][$id]);
            $this->updateTotals($cart);
            Session::put($this->sessionKey, $cart);
        }
    }

    public function clear()
    {
        Session::forget($this->sessionKey);
    }

    public function update($id, int $quantity)
    {
        $cart = $this->all();

        if (!isset($cart['items'][$id])) {
            return false;
        }

        $product = Product::find($id);
        if (!$product) {
            $this->remove($id);
            return false;
        }

        if ($product->stock < $quantity) {
            return false;
        }

        if ($quantity > 0) {
            $cart['items'][$id]['quantity'] = $quantity;
        } else {
            unset($cart['items'][$id]);
        }
        
        $this->updateTotals($cart);
        Session::put($this->sessionKey, $cart);
        return true;
    }

    protected function updateTotals(&$cart)
    {
        $cart['total'] = collect($cart['items'])
            ->sum(fn($item) => $item['price'] * $item['quantity']);
        $cart['count'] = collect($cart['items'])
            ->sum(fn($item) => $item['quantity']);
    }
}
