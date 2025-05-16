<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Log;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Notification;

class SendOrderConfirmation
{
    
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;

        if($order->client){
            Notification::send($order->client, new OrderPlacedNotification($order));
            
            Log::info("Order confirmation sent to client #{$order->client->id}");
        }
    }
}
