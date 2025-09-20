<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Services\AuthService;

class CartRepository
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getOrCreateCart()
    {
        return Cart::firstOrCreate(
            ['session_id' => $this->authService->getSessionId(), 'status' => 'active'],
            ['status' => 'active']
        );
    }

    public function addItem($price, $quantity, $productId)
    {
        $cart = $this->getOrCreateCart();
        // Add or update the product in the cart
        $cartItem = $cart->items()->firstOrNew(['product_id' => $productId]);
        $cartItem->quantity = $quantity;
        $cartItem->price = $price;
        $cartItem->total = $cartItem->quantity * $cartItem->price;
        $cartItem->save();
    }
}
