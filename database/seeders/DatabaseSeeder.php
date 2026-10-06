<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('iran:init', [
            '--no-interaction' => true,
            '--force' => true,
        ]);
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            VendorSeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
            CouponSeeder::class,
            OrderSeeder::class,
            SettingSeeder::class,
            BannerSeeder::class,
            PostSeeder::class,
            ShopBenefitSeeder::class,
            MenuSeeder::class,
            AddressSeeder::class
        ]);
    }
}
