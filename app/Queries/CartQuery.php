<?php

namespace App\Queries;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CartQuery
{
    private function query(): Builder
    {
        return Cart::query()->withItems();
    }

    public function forUser(?int $userId): ?Cart
    {
        if (! $userId) {
            return null;
        }

        return $this->query()
            ->forUser($userId)
            ->first();
    }

    public function items(?int $userId): Collection
    {
        return $this->forUser($userId)?->items ?? new Collection();
    }

    public function summary(?int $userId): array
    {
        $cart = $this->forUser($userId);
        $items = $cart?->items ?? new Collection();

        return [
            'cart'      => $cart,
            'cartItems' => $cart?->items ?? new Collection(),
            'cartCount' => $cart?->totalQuantity() ?? 0,
            'cartTotal' => $cart?->totalPrice() ?? 0,
            'cartQuantities' => $items->pluck('quantity', 'product_id')->all(),
        ];
    }
}
