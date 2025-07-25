<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // Recommended for better performance
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        // Use withoutRelations() to prevent issues with serializing full models
        $this->order = $order->withoutRelations();
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Store this notification in the database
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Ensure you have a route named 'orders.details' for the link
        $orderUrl = '#'; // Default fallback
        try {
            $orderUrl = 'orders/' . $this->order->id; // Adjust this to your actual route
        } catch (\Exception $e) {
            // Route not found, handle gracefully
        }

        return [
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Order #{$this->order->id} status updated to '{$this->newStatus}'.",
            'order_url' => $orderUrl,
        ];
    }
}
