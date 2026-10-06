<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Enums\VendorStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            [
                'user_name' => 'علی رضایی',
                'mobile' => '09130000001',
                'store_name' => 'فروشگاه علی',
                'url' => 'ali-store',
                'bio' => 'فروشنده محصولات پوشاک و اکسسوری',
                'national_code' => '0012345678',
                'commission_rate' => 10,
                'status' => VendorStatus::APPROVED,
            ],
            [
                'user_name' => 'سارا محمدی',
                'mobile' => '09130000002',
                'store_name' => 'دیجی‌کالا پلاس',
                'url' => 'digikala-plus',
                'bio' => 'فروش انواع کالای دیجیتال',
                'national_code' => '0023456789',
                'commission_rate' => 8.5,
                'status' => VendorStatus::APPROVED,
            ],
            [
                'user_name' => 'محمد احمدی',
                'mobile' => '09130000003',
                'store_name' => 'خانه مدرن',
                'url' => 'modern-home',
                'bio' => 'محصولات خانه و آشپزخانه',
                'national_code' => '0034567890',
                'commission_rate' => 12,
                'status' => VendorStatus::PENDING,
            ],
            [
                'user_name' => 'نگار کریمی',
                'mobile' => '09130000004',
                'store_name' => 'نگار شاپ',
                'url' => 'negar-shop',
                'bio' => 'فروش محصولات زیبایی و مراقبت شخصی',
                'national_code' => '0045678901',
                'commission_rate' => 10.5,
                'status' => VendorStatus::REJECTED,
                'rejected_reason' => 'مدارک فروشنده کامل نیست.',
            ],
            [
                'user_name' => 'رضا حسینی',
                'mobile' => '09130000005',
                'store_name' => 'تکنو مارکت',
                'url' => 'techno-market',
                'bio' => 'فروش لوازم جانبی موبایل و کامپیوتر',
                'national_code' => '0056789012',
                'commission_rate' => 9,
                'status' => VendorStatus::SUSPENDED,
            ],
        ];

        foreach ($vendors as $vendorData) {

            $user = User::create([
                'user_name' => $vendorData['user_name'],
                'mobile' => $vendorData['mobile'],
                'password' => 'password',
                'type' => UserType::VENDOR,
                'status' => UserStatus::ACTIVE,
            ]);

            $user->vendor()->create([
                'store_name' => $vendorData['store_name'],
                'url' => $vendorData['url'],
                'bio' => $vendorData['bio'],
                'national_code' => $vendorData['national_code'],
                'commission_rate' => $vendorData['commission_rate'],
                'status' => $vendorData['status'],
                'rejected_reason' => $vendorData['rejected_reason'] ?? null,
            ]);
        }
    }
}
