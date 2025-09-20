<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItems;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\CartRepository;
use App\Services\AuthService;

class CartService
{    
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function updateCartItem($productId, $quantity)
    {
        $cart = $this->cartRepository->getOrCreateCart();
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

    public function addProductToCart($price, $quantity, $productId)
    {
        $this->cartRepository->addItem($price, $quantity, $productId);
    }
}
