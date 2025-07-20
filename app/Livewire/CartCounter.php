<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    public $cartCount = 0;

    // Listen for the 'cart-updated' event from other components or controllers
    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        // Initial load of the cart count when the component is mounted
        $this->updateCartCount();
    }
 
    #[On('cart-updated')] // Listen for the 'cart-updated' event from the browser
    public function updateCartCount()
    {
        $cart = $this->getCart();

        if ($cart && $cart->items) {
            $this->cartCount = $cart->items->sum('quantity');
        } else {
            $this->cartCount = 0;
        }
    }

    protected function getCart()
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())
                       ->where('status', 'active')
                       ->first();
        } else {
            $sessionId = session('cart_id');
            return Cart::where('session_id', $sessionId)
                       ->where('status', 'active')
                       ->first();
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
