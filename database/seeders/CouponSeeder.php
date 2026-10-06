<?php

namespace Database\Seeders;

use App\Enums\CouponType;
use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::query()->create([
            'code' => 'WELCOME10',
            'type' => CouponType::PERCENTAGE,
            'value' => 10,
            'min_order_amount' => 1_000_000,
            'max_discount_amount' => 300_000,
            'usage_limit' => 100,
            'used_count' => 0,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(1),
            'is_active' => true,
        ]);

        Coupon::query()->create([
            'code' => 'SUMMER20',
            'type' => CouponType::PERCENTAGE,
            'value' => 20,
            'min_order_amount' => 2_000_000,
            'max_discount_amount' => 500_000,
            'usage_limit' => 50,
            'used_count' => 0,
            'starts_at' => now()->subDays(5),
            'expires_at' => now()->addDays(20),
            'is_active' => true,
        ]);

        Coupon::query()->create([
            'code' => '100KOFF',
            'type' => CouponType::FIXED,
            'value' => 100_000,
            'min_order_amount' => 500_000,
            'max_discount_amount' => null,
            'usage_limit' => 200,
            'used_count' => 15,
            'starts_at' => now()->subDays(10),
            'expires_at' => now()->addDays(10),
            'is_active' => true,
        ]);

        Coupon::query()->create([
            'code' => 'EXPIRED10',
            'type' => CouponType::PERCENTAGE,
            'value' => 10,
            'min_order_amount' => null,
            'max_discount_amount' => 200_000,
            'usage_limit' => 100,
            'used_count' => 100,
            'starts_at' => now()->subMonths(2),
            'expires_at' => now()->subDays(5),
            'is_active' => true,
        ]);

        Coupon::query()->create([
            'code' => 'INACTIVE50',
            'type' => CouponType::PERCENTAGE,
            'value' => 50,
            'min_order_amount' => 1_000_000,
            'max_discount_amount' => 1_000_000,
            'usage_limit' => null,
            'used_count' => 0,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(2),
            'is_active' => false,
        ]);
    }
}
