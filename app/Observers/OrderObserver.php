<?php

namespace App\Observers;

use App\Models\Order;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;
use App\Notifications\OrderStatusNotification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->isDirty('delivery_status')) {
            $old = $order->getOriginal('delivery_status');
            $new = $order->delivery_status;

            // Log to the Laravel console
            Log::info("Order #{$order->id} status changed from '{$old}' to '{$new}'");

            // Dispatch event
            OrderStatusUpdated::dispatch($order, $old, $new);

            if ($order->user) {
                // Create a notification
                $order->user->notify(new OrderStatusNotification($order, $oldStatus, $newStatus));
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
