<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\UserType;
use App\Enums\CouponType;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()
            ->where('type', UserType::CUSTOMER)
            ->get();

        $products = Product::query()
            ->published()
            ->with('vendor')
            ->get();

        $coupons = Coupon::query()
            ->where('is_active', true)
            ->get();

        if ($users->isEmpty()) {
            throw new RuntimeException(
                'No customer users found. Run UserSeeder before OrderSeeder.'
            );
        }

        if ($products->isEmpty()) {
            throw new RuntimeException(
                'No published products found. Run ProductSeeder before OrderSeeder.'
            );
        }

        DB::transaction(function () use ($users, $products, $coupons) {
            foreach (range(1, 10) as $index) {
                $order = Order::create([
                    'user_id' => $users->random()->id,
                    'order_number' => $this->generateOrderNumber(),
                    'subtotal' => 0,
                    'discount_amount' => 0,
                    'shipping_amount' => 0,
                    'total' => 0,
                    'status' => OrderStatus::PENDING,
                ]);

                $subtotal = 0;
                $discountAmount = 0;

                $selectedProducts = $products
                    ->random(min(random_int(1, 3), $products->count()));

                foreach ($selectedProducts as $product) {
                    $quantity = random_int(1, 3);

                    $price = $product->price;
                    $itemDiscount = 0;
                    $itemTotal = ($price - $itemDiscount) * $quantity;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'vendor_id' => $product->vendor_id,
                        'product_name' => $product->name,
                        'price' => $price,
                        'discount_amount' => $itemDiscount,
                        'quantity' => $quantity,
                        'total' => $itemTotal,
                    ]);

                    $subtotal += $price * $quantity;
                    $discountAmount += $itemDiscount * $quantity;
                }

                $coupon = $this->findApplicableCoupon(
                    $coupons,
                    $subtotal
                );

                if ($coupon) {
                    $discountAmount = $this->calculateCouponDiscount(
                        $coupon,
                        $subtotal
                    );

                    $order->update([
                        'coupon_id' => $coupon->id,
                    ]);

                    $coupon->increment('used_count');
                }

                $shippingAmount = 0;

                $total = max(
                    0,
                    $subtotal - $discountAmount + $shippingAmount
                );

                $order->update([
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'shipping_amount' => $shippingAmount,
                    'total' => $total,
                ]);
            }
        });
    }

    private function findApplicableCoupon(
        $coupons,
        int $subtotal
    ): ?Coupon {
        $availableCoupons = $coupons->filter(function (Coupon $coupon) use ($subtotal) {
            if (
                $coupon->min_order_amount !== null &&
                $subtotal < $coupon->min_order_amount
            ) {
                return false;
            }

            if (
                $coupon->usage_limit !== null &&
                $coupon->used_count >= $coupon->usage_limit
            ) {
                return false;
            }

            if (
                $coupon->starts_at &&
                now()->lt($coupon->starts_at)
            ) {
                return false;
            }

            if (
                $coupon->expires_at &&
                now()->gt($coupon->expires_at)
            ) {
                return false;
            }

            return true;
        });

        if ($availableCoupons->isEmpty()) {
            return null;
        }

        // همه سفارش‌ها کوپن نگیرند
        return random_int(1, 100) <= 60
            ? $availableCoupons->random()
            : null;
    }

    private function calculateCouponDiscount(
        Coupon $coupon,
        int $subtotal
    ): int {
        $discount = match ($coupon->type) {
            CouponType::PERCENTAGE => (int) round(
                $subtotal * ((float) $coupon->value / 100)
            ),

            CouponType::FIXED => (int) $coupon->value,
        };

        if ($coupon->max_discount_amount !== null) {
            $discount = min(
                $discount,
                $coupon->max_discount_amount
            );
        }

        return min($discount, $subtotal);
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
    }
}
