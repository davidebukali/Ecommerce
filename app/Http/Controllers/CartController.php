<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Str;

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
        $cart = $this->cartService->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();
        // sum the total price of all items in the cart
        $subtotal = $cartItems->sum(function ($item) {
            return $item->total;
        });
        $order_number = (string) Str::uuid();
        $transaction_id = (string) Str::uuid();
        return view('cart.index', compact('cart', 'cartItems', 'subtotal', 'order_number', 'transaction_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(Request $request, $productId)
    {
        // Validate the request
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $quantity = $request->input('quantity', 1);
        $price = $request->input('price', 1);

        $this->cartService->addCartItem($price, $quantity, $productId);
        
        return redirect()->back()->with('success', 'Product added to cart!')->with('dispatch', 'cart-updated');;
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
    public function updateCart(Request $request, Cart $cart)
    {
        $quantity = $request->input('quantity', 1);
        $product_id = $request->input('product_id', 1);

        $this->cartService->updateCartItem($product_id, $quantity);
        
        return redirect()->back()->with('success', 'Cart updated!')->with('dispatch', 'cart-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove(Cart $cart)
    {
        $product_id = request()->input('product_id');
        $this->cartService->removeCartItem($product_id);
        
        return redirect()->back()->with('success', 'Product removed!')->with('dispatch', 'cart-updated');
    }
}
