<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

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
        try {
        $notification = ucfirst($order->status->code);
        $class = "\App\Notifications\Order\\" . $notification;

        if (class_exists($class) && $order->user) {
            Notification::send([$order->user], new $class($order));
        }
    } catch (\Throwable $e) {
        Log::error('Order notification error: ' . $e->getMessage());
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
