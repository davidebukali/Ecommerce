<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Order;

Broadcast::channel('orders.{orderId}', function (User $user, int $orderId) {
    return $user->id === Order::findOrNew($orderId)->user_id;
});
