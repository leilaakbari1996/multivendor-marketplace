<?php

namespace Database\Seeders;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class CategorySeeder extends Seeder
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    public function run(): void
    {
        $categories = [
            [
                'name' => 'میوه و سبزیجات',
                'description' => 'انواع میوه و سبزیجات تازه و باکیفیت.',
                'sort_order' => 1,
                'image' => 'icon-vegetables-broccoli.png',
            ],
            [
                'name' => 'نان و شیرینی',
                'description' => 'انواع نان، شیرینی و محصولات تازه نانوایی.',
                'sort_order' => 2,
                'image' => 'icon-bread-baguette.png',
            ],
            [
                'name' => 'نوشیدنی‌ها',
                'description' => 'انواع نوشیدنی‌های سرد و گرم.',
                'sort_order' => 3,
                'image' => 'icon-soft-drinks-bottle.png',
            ],
            [
                'name' => 'نوشیدنی‌های الکلی',
                'description' => 'انواع نوشیدنی‌های بطری‌شده.',
                'sort_order' => 4,
                'image' => 'icon-wine-glass-bottle.png',
            ],
            [
                'name' => 'محصولات پروتئینی',
                'description' => 'انواع گوشت و محصولات پروتئینی.',
                'sort_order' => 5,
                'image' => 'icon-animal-products-drumsticks.png',
            ],
            [
                'name' => 'آرد و غلات',
                'description' => 'انواع آرد، غلات و محصولات مرتبط.',
                'sort_order' => 6,
                'image' => 'icon-bread-herb-flour.png',
            ],
            [
                'name' => 'محصولات تازه',
                'description' => 'محصولات تازه و باکیفیت روزانه.',
                'sort_order' => 7,
                'image' => 'icon-vegetables-broccoli.png',
            ],
            [
                'name' => 'محصولات ارگانیک',
                'description' => 'محصولات طبیعی و ارگانیک.',
                'sort_order' => 8,
                'image' => 'icon-vegetables-broccoli.png',
            ],
            [
                'name' => 'محصولات سالم',
                'description' => 'محصولات مناسب برای یک سبک زندگی سالم.',
                'sort_order' => 9,
                'image' => 'icon-vegetables-broccoli.png',
            ],
            [
                'name' => 'مواد غذایی روزانه',
                'description' => 'مواد غذایی مورد نیاز روزانه.',
                'sort_order' => 10,
                'image' => 'icon-vegetables-broccoli.png',
            ],
            [
                'name' => 'محصولات ویژه',
                'description' => 'محصولات منتخب و ویژه فروشگاه.',
                'sort_order' => 11,
                'image' => 'icon-vegetables-broccoli.png',
            ],
            [
                'name' => 'سایر محصولات',
                'description' => 'سایر محصولات فروشگاه.',
                'sort_order' => 12,
                'image' => 'icon-vegetables-broccoli.png',
            ],
        ];

        foreach ($categories as $data) {
            $image = $data['image'];

            unset($data['image']);

            $category = Category::query()->create([
                ...$data,
                'parent_id' => null,
                'is_active' => true,
            ]);

            $path = public_path("client/images/{$image}");

            if (! file_exists($path)) {
                continue;
            }

            $this->storeMediaAction->execute(
                model: $category,
                file: new UploadedFile(
                    $path,
                    $image,
                    mime_content_type($path),
                    null,
                    true
                ),
                collection: MediaCollection::IMAGE,
                directory: 'categories',
            );
        }
    }
}
