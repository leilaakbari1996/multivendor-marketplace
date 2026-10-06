<?php

namespace App\Actions\Client\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Support\AuthUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StoreCartAction
{
    public function execute(int $productId, int $quantity): ?CartItem
    {
        return DB::transaction(function () use ($productId, $quantity) {
            $product = Product::query()
                ->published()
                ->lockForUpdate()
                ->findOrFail($productId);

            $cart = Cart::query()->firstOrCreate([
                'user_id' => AuthUser::id(),
            ]);

            $cartItem = CartItem::query()
                ->forCart($cart->id)
                ->forProduct($product->id)
                ->lockForUpdate()
                ->first();

            // تعداد ارسالی = تعداد نهایی در سبد (نه مقدار افزوده)
            if ($quantity <= 0) {
                $cartItem?->delete();

                return null;
            }

            if ($quantity > $product->stock) {
                throw ValidationException::withMessages([
                    'quantity' => "حداکثر تعداد قابل خرید {$product->stock} عدد است.",
                ]);
            }

            if ($cartItem) {
                $cartItem->update(['quantity' => $quantity]);

                return $cartItem->fresh();
            }

            return $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ]);
        });
    }
}
