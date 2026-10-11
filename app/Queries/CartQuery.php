<?php

namespace App\Queries;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CartQuery
{
    /** @var array<int, Cart|null> */
    private array $carts = [];

    /** @var array<int, array> */
    private array $summaries = [];

    private function query(): Builder
    {
        return Cart::query()->withItems();
    }

    public function forUser(?int $userId): ?Cart
    {
        if (! $userId) {
            return null;
        }

        if (! array_key_exists($userId, $this->carts)) {
            $this->carts[$userId] = $this->query()
                ->forUser($userId)
                ->first();
        }

        return $this->carts[$userId];
    }

    public function items(?int $userId): Collection
    {
        return $this->forUser($userId)?->items ?? new Collection();
    }

    public function summary(?int $userId): array
    {
        $key = $userId ?? 0;

        return $this->summaries[$key] ??= $this->buildSummary($userId);
    }

    /**
     * بعد از هر تغییر در سبد (افزودن/حذف/آپدیت) صدا بزن.
     */
    public function forget(?int $userId = null): void
    {
        if ($userId === null) {
            $this->carts = [];
            $this->summaries = [];

            return;
        }

        unset($this->carts[$userId], $this->summaries[$userId]);
    }

    private function buildSummary(?int $userId): array
    {
        $cart = $this->forUser($userId);
        $items = $cart?->items ?? new Collection();

        return [
            'cart' => $cart,
            'cartItems' => $items,
            'cartCount' => $cart?->totalQuantity() ?? 0,
            'cartTotal' => $cart?->totalPrice() ?? 0,
            'cartQuantities' => $items->pluck('quantity', 'product_id')->all(),
        ];
    }
}
