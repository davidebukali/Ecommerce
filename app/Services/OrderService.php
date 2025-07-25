<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;

class OrderService
{
    public function createOrder($validatedData, $cart)
    {
        // 1. Create the Order
        $order = new Order();
        $order->user_id          = auth()->id(); // Will be null for guests
        $order->order_number     = $validatedData['order_number'];
        $order->subtotal         = $validatedData['subtotal'];
        $order->delivery_fee     = $validatedData['delivery_fee'];
        $order->total            = $validatedData['total'];
        $order->payment_method   = $validatedData['payment_method'];
        $order->payment_status   = $validatedData['payment_status'];
        $order->transaction_id   = $validatedData['transaction_id']; // Null for COD
        $order->delivery_address = $validatedData['delivery_address'];
        $order->delivery_status  = 'pending'; // Default status, client should not dictate this
        $order->save();

        // 3. Update cart status
        $cart->status = 'completed'; // Mark the cart as completed/converted
        $cart->save();

        return $order;
    }

    public function getUserOrderIds($userId)
    {
        return Order::where('user_id', $userId)->pluck('id')->toArray();
    }
}
