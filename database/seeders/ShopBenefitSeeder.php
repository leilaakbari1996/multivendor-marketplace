<?php

namespace Database\Seeders;

use App\Models\ShopBenefit;
use Illuminate\Database\Seeder;

class ShopBenefitSeeder extends Seeder
{
    public function run(): void
    {
        $benefits = [
            [
                'title' => 'ارسال سریع',
                'description' => 'سفارش‌های شما در کوتاه‌ترین زمان ممکن ارسال می‌شوند.',
                'icon' => 'delivery',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'پرداخت امن',
                'description' => 'پرداخت آنلاین با استفاده از درگاه امن و مطمئن.',
                'icon' => 'payment',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'ضمانت کیفیت',
                'description' => 'محصولات باکیفیت را با اطمینان از ما خریداری کنید.',
                'icon' => 'quality',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'قیمت مناسب',
                'description' => 'محصولات متنوع با قیمت‌های رقابتی و مناسب.',
                'icon' => 'savings',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'پیشنهادهای ویژه',
                'description' => 'از تخفیف‌ها و پیشنهادهای ویژه روزانه باخبر شوید.',
                'icon' => 'offers',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($benefits as $benefit) {
            ShopBenefit::query()->create($benefit);
        }
    }
}

