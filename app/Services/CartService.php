<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItems;

class CartService
{
    public function getOrCreateCart()
    {
        $sessionId = session()->getId();
        // Check if the user is authenticated
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id(), 'status' => 'active'],
                ['status' => 'active']
            );
        } else {
            // For guests, use the session ID to identify the cart
            $cart = Cart::firstOrCreate(
                ['session_id' => $sessionId, 'status' => 'active'],
                ['status' => 'active']
            );
        }

        return $cart;
    }

    public function addCartItem($price, $quantity, $productId)
    {
        // Get or create the cart
        $cart = $this->getOrCreateCart();

        // Add or update the product in the cart
        $cartItem = $cart->items()->firstOrNew(['product_id' => $productId]);
        $cartItem->quantity = $quantity;
        $cartItem->price = $price;
        $cartItem->total = $cartItem->quantity * $cartItem->price;
        $cartItem->save();
    }

    public function updateCartItem($productId, $quantity)
    {
        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->total = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
        }
    }
}
