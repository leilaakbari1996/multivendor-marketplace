<?php

namespace Database\Seeders;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\BannerPosition;
use App\Enums\MediaCollection;
use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class BannerSeeder extends Seeder
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    public function run(): void
    {
        $banners = [
            [
                'title' => 'اسموتی تازه و آبمیوه تابستانی',
                'subtitle' => '۱۰۰٪ طبیعی',
                'description' => 'طعم تازه و طبیعی میوه‌ها را با اسموتی و آبمیوه‌های تابستانی تجربه کنید.',
                'url' => '/products',
                'position' => BannerPosition::MAIN,
                'sort_order' => 1,
                'image' => 'product-thumb-1.png',
            ],
            [
                'title' => 'اسموتی تازه و آبمیوه تابستانی',
                'subtitle' => '۱۰۰٪ طبیعی',
                'description' => 'محصولات تازه و طبیعی را با بهترین کیفیت خریداری کنید.',
                'url' => '/products',
                'position' => BannerPosition::MAIN,
                'sort_order' => 2,
                'image' => 'product-thumb-1.png',
            ],
            [
                'title' => 'سس گوجه فرنگی',
                'subtitle' => '۱۰۰٪ طبیعی',
                'description' => 'سس گوجه فرنگی با کیفیت و طعم عالی برای استفاده روزانه.',
                'url' => '/products',
                'position' => BannerPosition::MAIN,
                'sort_order' => 3,
                'image' => 'product-thumb-2.png',
            ],
            [
                'title' => 'میوه و سبزیجات',
                'subtitle' => '۲۰٪ تخفیف',
                'description' => 'انواع میوه و سبزیجات تازه را با تخفیف ویژه تهیه کنید.',
                'url' => '/products',
                'position' => BannerPosition::SIDE_TOP,
                'sort_order' => 1,
                'image' => 'ad-image-1.png',
            ],
            [
                'title' => 'محصولات نانوایی',
                'subtitle' => '۱۵٪ تخفیف',
                'description' => 'محصولات تازه و خوشمزه نانوایی را با تخفیف ویژه خریداری کنید.',
                'url' => '/products',
                'position' => BannerPosition::SIDE_BOTTOM,
                'sort_order' => 1,
                'image' => 'ad-image-2.png',
            ],
            [
                'title' => 'شکلات تلخ لوکس',
                'subtitle' => 'تا ۲۵٪ تخفیف',
                'description' => 'شکلات تلخ با طعم دلپذیر و کیفیت بالا، مناسب برای لحظات شیرین شما.',
                'url' => '/products',
                'position' => BannerPosition::PROMO,
                'sort_order' => 1,
                'image' => 'ad-image-3.png',
            ],
            [
                'title' => 'مافین خامه‌ای',
                'subtitle' => 'تا ۲۵٪ تخفیف',
                'description' => 'مافین‌های تازه و خوش‌طعم با عطر و طعم دلپذیر.',
                'url' => '/products',
                'position' => BannerPosition::PROMO,
                'sort_order' => 2,
                'image' => 'ad-image-4.png',
            ],
        ];

        foreach ($banners as $data) {
            $image = $data['image'];

            unset($data['image']);

            $banner = Banner::query()->create($data);

            $imagePath = public_path("client/images/{$image}");

            $this->storeMediaAction->execute(
                model: $banner,
                file: new UploadedFile(
                    $imagePath,
                    $image,
                    mime_content_type($imagePath),
                    null,
                    true
                ),
                collection: MediaCollection::IMAGE,
                directory: 'banners',
            );
        }
    }
}

