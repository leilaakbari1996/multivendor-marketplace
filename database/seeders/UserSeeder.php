<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user_name' => 'علی رضایی',
                'mobile' => '09120000001',
            ],
            [
                'user_name' => 'سارا محمدی',
                'mobile' => '09120000002',
            ],
            [
                'user_name' => 'محمد احمدی',
                'mobile' => '09120000003',
            ],
            [
                'user_name' => 'نگار کریمی',
                'mobile' => '09120000004',
            ],
            [
                'user_name' => 'رضا حسینی',
                'mobile' => '09120000005',
            ],
            [
                'user_name' => 'مریم اکبری',
                'mobile' => '09120000006',
            ],
            [
                'user_name' => 'امیرحسین مرادی',
                'mobile' => '09120000007',
            ],
            [
                'user_name' => 'الهام موسوی',
                'mobile' => '09120000008',
            ],
            [
                'user_name' => 'حسین کریمی',
                'mobile' => '09120000009',
            ],
            [
                'user_name' => 'نازنین احمدی',
                'mobile' => '09120000010',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                ...$user,
                'password' => 'password',
                'type' => UserType::CUSTOMER,
                'status' => UserStatus::ACTIVE,
            ]);
        }
    }
}
