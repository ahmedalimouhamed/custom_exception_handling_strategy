<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\OrderPlacedNotification;

class SendOrderConfirmation
{
    
    public function handle(object $event): void
    {
        $order = $event->order;

        if($order->client){
            $order->client->notify(new OrderPlacedNotification($order));
        }
    }
}
