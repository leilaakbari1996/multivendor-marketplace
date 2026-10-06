<?php

namespace App\Actions\Client\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Support\AuthUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateCartAction
{
    public function execute(int $productId, int $quantity): ?CartItem
    {
        return DB::transaction(function () use ($productId, $quantity) {
            $product = Product::query()
                ->published()
                ->lockForUpdate()
                ->findOrFail($productId);

            $cart = Cart::query()
                ->forUser(AuthUser::id())
                ->firstOrFail();

            $cartItem = CartItem::query()
                ->forCart($cart->id)
                ->forProduct($product->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($quantity <= 0) {
                $cartItem->delete();

                return null;
            }

            if ($quantity > $product->stock) {
                throw ValidationException::withMessages([
                    'quantity' => "حداکثر تعداد قابل خرید {$product->stock} عدد است.",
                ]);
            }

            $cartItem->update(['quantity' => $quantity]);

            return $cartItem->fresh();
        });
    }
}
