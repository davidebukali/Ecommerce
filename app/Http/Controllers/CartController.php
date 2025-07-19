<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Services\CartService;
use Livewire\Livewire;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessionId = session()->getId();
        $cart = $this->cartService->getOrCreateCart($sessionId);
        $cartItems = $cart->items()->with('product')->get();
        // sum the total price of all items in the cart
        $subtotal = $cartItems->sum(function ($item) {
            return $item->total;
        });
        return view('cart.index', compact('cart', 'cartItems', 'subtotal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1);
        $price = $request->input('price', 1);
        $sessionId = session()->getId();

        $this->cartService->addCartItem($price, $quantity, $productId, $sessionId);

        // Dispatch the event that the Livewire CartCounter component is listening for
        Livewire::dispatch('cartUpdated');
        
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
