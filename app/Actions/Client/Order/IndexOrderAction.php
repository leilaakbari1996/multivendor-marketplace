<?php

namespace App\Actions\Client\Order;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexOrderAction
{
    public function execute(User $user, ?OrderStatus $status = null, int $perPage = 10): LengthAwarePaginator
    {
        return Order::query()
            ->forUser($user)
            ->ofStatus($status)
            ->with('items:id,order_id,product_id,product_name,quantity,price,discount_amount,total')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
