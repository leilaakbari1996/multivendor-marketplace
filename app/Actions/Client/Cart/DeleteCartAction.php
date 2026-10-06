<?php

namespace App\Actions\Client\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Support\AuthUser;

class DeleteCartAction
{
    public function execute(int $productId): void
    {
        $cart = Cart::query()
            ->forUser(AuthUser::id())
            ->first();

        if (! $cart) {
            return;
        }

        CartItem::query()
            ->forCart($cart->id)
            ->forProduct($productId)
            ->delete();
    }
}
