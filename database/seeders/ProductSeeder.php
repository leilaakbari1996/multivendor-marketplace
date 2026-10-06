<?php

namespace Database\Seeders;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class ProductSeeder extends Seeder
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    public function run(): void
    {
        $vendor = Vendor::query()->first();

        if (!$vendor) {
            throw new RuntimeException(
                'No vendor found. Please seed vendors before running ProductSeeder.'
            );
        }

        $categories = Category::query()
            ->whereIn('name', [
                'میوه و سبزیجات',
                'نان و شیرینی',
                'نوشیدنی‌ها',
                'محصولات پروتئینی',
                'آرد و غلات',
            ])
            ->pluck('id', 'name');

        $products = [
            [
                'category' => 'میوه و سبزیجات',
                'name' => 'موز تازه',
                'sku' => 'FRUIT-001',
                'description' => 'موز تازه و باکیفیت مناسب مصرف روزانه.',
                'price' => 180000,
                'discount_price' => 149000,
                'stock' => 25,
                'weight' => 1000,
                'image' => 'thumb-bananas.png',
                'is_best_selling' => true,
            ],
            [
                'category' => 'نان و شیرینی',
                'name' => 'بیسکویت کره‌ای',
                'sku' => 'BAKE-001',
                'description' => 'بیسکویت ترد و خوش‌طعم مناسب میان‌وعده.',
                'price' => 120000,
                'discount_price' => 99000,
                'stock' => 40,
                'weight' => 300,
                'image' => 'thumb-biscuits.png',
                'is_best_selling' => true,
            ],
            [
                'category' => 'میوه و سبزیجات',
                'name' => 'خیار تازه',
                'sku' => 'VEG-001',
                'description' => 'خیار تازه و ترد مناسب مصرف روزانه و سالاد.',
                'price' => 85000,
                'discount_price' => null,
                'stock' => 35,
                'weight' => 1000,
                'image' => 'thumb-cucumber.png',
                'is_best_selling' => false,
            ],
            [
                'category' => 'نوشیدنی‌ها',
                'name' => 'شیر تازه',
                'sku' => 'DRINK-001',
                'description' => 'شیر تازه مناسب صبحانه و مصرف روزانه.',
                'price' => 95000,
                'discount_price' => 79000,
                'stock' => 30,
                'weight' => 1000,
                'image' => 'thumb-milk.png',
                'is_best_selling' => true,
            ],
            [
                'category' => 'نوشیدنی‌ها',
                'name' => 'آب پرتقال طبیعی',
                'sku' => 'DRINK-002',
                'description' => 'آب پرتقال با طعم طبیعی و تازه.',
                'price' => 175000,
                'discount_price' => 145000,
                'stock' => 20,
                'weight' => 1000,
                'image' => 'thumb-orange-juice.png',
                'is_best_selling' => false,
            ],
            [
                'category' => 'میوه و سبزیجات',
                'name' => 'تمشک تازه',
                'sku' => 'FRUIT-002',
                'description' => 'تمشک تازه و خوش‌طعم مناسب میان‌وعده.',
                'price' => 220000,
                'discount_price' => null,
                'stock' => 15,
                'weight' => 500,
                'image' => 'thumb-raspberries.png',
                'is_best_selling' => false,
            ],
            [
                'category' => 'میوه و سبزیجات',
                'name' => 'گوجه فرنگی تازه',
                'sku' => 'VEG-002',
                'description' => 'گوجه فرنگی تازه مناسب سالاد و آشپزی.',
                'price' => 95000,
                'discount_price' => 79000,
                'stock' => 45,
                'weight' => 1000,
                'image' => 'thumb-tomatoes.png',
                'is_best_selling' => true,
            ],
            [
                'category' => 'نان و شیرینی',
                'name' => 'سس گوجه فرنگی',
                'sku' => 'FOOD-001',
                'description' => 'سس گوجه فرنگی مناسب انواع غذا و ساندویچ.',
                'price' => 110000,
                'discount_price' => null,
                'stock' => 25,
                'weight' => 500,
                'image' => 'thumb-tomatoketchup.png',
                'is_best_selling' => false,
            ],
        ];

        $featuredFrom = now()->startOfDay()->subDays(3);
        $featuredUntil = now()->startOfDay()->addDays(14);

        foreach ($products as $data) {
            $categoryId = $categories->get($data['category']);

            if (!$categoryId) {
                throw new RuntimeException(
                    "Category [{$data['category']}] not found."
                );
            }

            $image = $data['image'];

            unset(
                $data['category'],
                $data['image']
            );

            $product = Product::create([
                ...$data,
                'vendor_id' => $vendor->id,
                'category_id' => $categoryId,
                'status' => ProductStatus::PUBLISHED,
                'is_featured' => true,
                'featured_from' => $featuredFrom,
                'featured_until' => $featuredUntil,
            ]);

            $imagePath = public_path("client/images/{$image}");

            if (!is_file($imagePath)) {
                throw new RuntimeException(
                    "Product image [{$image}] not found."
                );
            }

            $uploadedFile = new UploadedFile(
                $imagePath,
                basename($imagePath),
                mime_content_type($imagePath),
                null,
                true
            );

            $this->storeMediaAction->execute(
                model: $product,
                file: $uploadedFile,
                collection: MediaCollection::IMAGE,
                directory: 'products',
            );
        }
    }
}

