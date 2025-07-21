<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItems;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CartService
{
    public function getOrCreateCart()
    {
        $sessionId = session('cart_id');
        // Check if the user is authenticated
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id(), 'status' => 'active'],
                ['status' => 'active']
            );
        } else {
            //check if session is null
            if ($sessionId == null) {
                // Generate a new session ID if it doesn't exist
                $sessionId = (string) Str::uuid();
                session(['cart_id' => $sessionId]);
                $sessionId = session('cart_id');
            }

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

        Log::info('Found a cart to add items: ' . $cart);

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

    public function removeCartItem($productId)
    {
        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->delete();
        }
    }
}
