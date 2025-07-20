<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\CartItem;

class MergeGuestCartOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $oldSessionId = session('cart_id');

        // 1. Find the guest cart using the old session ID
        $guestCart = Cart::with('items')
                         ->where('session_id', $oldSessionId)
                         ->where('status', 'active')
                         ->first();

        // 2. Find the logged-in user's active cart
        $userCart = Cart::with('items')
                        ->where('user_id', $user->id)
                        ->where('status', 'active')
                        ->first();

        // Scenario A: Guest has a cart, User does NOT have an active cart
        if ($guestCart && !$userCart) {
            $guestCart->user_id = $user->id;
            $guestCart->session_id = null; // Clear the session ID
            $guestCart->save();
        }
        // Scenario B: Guest has a cart, AND User also has an active cart (needs merging)
        elseif ($guestCart && $userCart) {
            foreach ($guestCart->items as $guestItem) {
                // Check if the product already exists in the user's cart
                $existingUserItem = $userCart->items()
                                             ->where('product_id', $guestItem->product_id)
                                             ->first();

                if ($existingUserItem) {
                    // Update quantity if item exists
                    $existingUserItem->quantity += $guestItem->quantity;
                    $existingUserItem->save();
                } else {
                    // Move item to user's cart
                    $guestItem->cart_id = $userCart->id;
                    $guestItem->save();
                }
            }
            // Delete the old guest cart after merging its items
            $guestCart->delete();
        }
    }
}
