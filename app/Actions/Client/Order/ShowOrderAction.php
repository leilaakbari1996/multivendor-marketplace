<?php

namespace App\Actions\Client\Order;

use App\Models\Order;
use App\Models\User;

class ShowOrderAction
{
    public function execute(User $user, string $orderNumber): Order
    {
        // اگر سفارش مال کاربر دیگری باشد، 404 می‌دهد (نه 403) تا وجودش لو نرود
        return Order::query()
            ->forUser($user)
            ->byNumber($orderNumber)
            ->with(['items', 'coupon'])
            ->firstOrFail();
    }
}
