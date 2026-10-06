<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * برای هر کاربر ۱ تا ۳ آدرس نمونه می‌سازد.
 *
 * نکته: استان/شهرستان/بخش/شهر از روی خود ردیف شهر انتخاب می‌شوند،
 * پس سلسله‌مراتب همیشه معتبر است.
 *
 * پیش‌نیاز: جدول‌های iran_* باید قبل از این سیدر پر شده باشند.
 */
class AddressSeeder extends Seeder
{
    private const TITLES = ['خانه', 'محل کار', 'منزل پدری', 'منزل مادربزرگ', 'مغازه'];

    private const NAMES = [
        'علی رضایی', 'مریم احمدی', 'محمد حسینی', 'زهرا کریمی',
        'حسین موسوی', 'فاطمه جعفری', 'رضا محمدی', 'سارا نوری',
    ];

    private const STREETS = [
        'خیابان ولیعصر', 'خیابان آزادی', 'بلوار کشاورز', 'خیابان شهید بهشتی',
        'خیابان امام خمینی', 'بلوار معلم', 'خیابان فردوسی', 'خیابان انقلاب',
    ];

    public function run(): void
    {
        $cities = DB::table('iran_cities')
            ->where('status', 1)
            ->get(['id', 'province_id', 'county_id', 'sector_id']);

        if ($cities->isEmpty()) {
            $this->command?->warn('جدول iran_cities خالی است؛ ابتدا سیدر مناطق ایران را اجرا کنید.');

            return;
        }

        if (DB::table('users')->doesntExist()) {
            User::factory()->count(3)->create();
        }

        $userIds = DB::table('users')->pluck('id');

        // کاربرانی که از قبل آدرس دارند دوباره سیدر نمی‌شوند
        $haveAddress = DB::table('addresses')
            ->whereIn('user_id', $userIds)
            ->distinct()
            ->pluck('user_id')
            ->all();

        $now = now();
        $rows = [];

        foreach ($userIds as $userId) {
            if (in_array($userId, $haveAddress, true)) {
                continue;
            }

            $count = random_int(1, 3);
            $titles = collect(self::TITLES)->shuffle()->take($count)->values();

            foreach ($titles as $i => $title) {
                $city = $cities->random();

                $rows[] = [
                    'user_id'          => $userId,
                    'title'            => $title,
                    'recipient_name'   => self::NAMES[array_rand(self::NAMES)],
                    'recipient_mobile' => '09' . str_pad((string) random_int(0, 999999999), 9, '0', STR_PAD_LEFT),
                    'province_id'      => $city->province_id,
                    'county_id'        => $city->county_id,
                    'sector_id'        => $city->sector_id,
                    'city_id'          => $city->id,
                    'address'          => self::STREETS[array_rand(self::STREETS)]
                        . '، کوچه ' . random_int(1, 40)
                        . '، ساختمان ' . random_int(1, 30),
                    'postal_code'      => (string) random_int(1, 9) . str_pad((string) random_int(0, 999999999), 9, '0', STR_PAD_LEFT),
                    'plaque'           => random_int(0, 1) ? random_int(1, 500) : null,
                    'unit'             => random_int(0, 1) ? (string) random_int(1, 20) : null,
                    'is_default'       => $i === 0, // فقط اولین آدرس هر کاربر پیش‌فرض است
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ];
            }
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('addresses')->insert($chunk);
        }

        $this->command?->info(count($rows) . ' آدرس ساخته شد.');
    }
}
