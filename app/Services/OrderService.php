<?php

namespace App\Services;

use App\Models\Order;
use App\Services\Contracts\OrderServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Events\OrderPlaced;
use App\Notifications\OrderPlacedNotification;
use App\Models\OrderItem;
use App\Exceptions\AppException;

class OrderService implements OrderServiceInterface
{
    public function placeOrder(array $data): void
    {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'client_id' => $data['client_id'],
                'total_price' => $data['total_price'],
                'status' => $data['status'] ?? 'pending',
            ]);

            foreach($data['items'] as $item){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            event(new OrderPlaced($order));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new AppException('Failed to place order', 500, ['error' => $e->getMessage()]);
        }
    }
}
