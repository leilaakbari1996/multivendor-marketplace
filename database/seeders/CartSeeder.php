<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()
            ->where('type', \App\Enums\UserType::CUSTOMER)
            ->get();

        $products = Product::query()
            ->where('stock', '>', 0)
            ->get();

        if ($users->isEmpty()) {
            $this->command->warn('هیچ کاربری برای ایجاد سبد خرید پیدا نشد.');
            return;
        }

        if ($products->isEmpty()) {
            $this->command->warn('هیچ محصولی برای ایجاد آیتم سبد خرید پیدا نشد.');
            return;
        }

        foreach ($users as $index => $user) {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);

            $itemsCount = ($index % 3) + 1;

            $selectedProducts = $products
                ->slice($index % $products->count(), $itemsCount);

            foreach ($selectedProducts as $product) {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => min(($index % 3) + 1, $product->stock),
                ]);
            }
        }
    }
}
