<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Jobs\ProcessOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderPlacedNotification
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
    public function handle(OrderPlaced $event): void
    {
        // Dispatch the job to process the order asynchronously
        ProcessOrder::dispatch($event->order);
    }
}
