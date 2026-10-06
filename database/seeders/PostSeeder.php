<?php

namespace Database\Seeders;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class PostSeeder extends Seeder
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    public function run(): void
    {
        $author = User::query()->first();

        if (!$author) {
            throw new RuntimeException(
                'No user found. Please seed users before running PostSeeder.'
            );
        }

        $posts = [
            [
                'title' => 'راهنمای انتخاب محصولات مناسب برای خرید روزانه',
                'excerpt' => 'با چند نکته ساده می‌توانید محصولات مورد نیاز خود را بهتر و سریع‌تر انتخاب کنید.',
                'content' => 'در این مقاله با نکات مهم برای انتخاب محصولات مناسب، بررسی کیفیت و خرید بهتر آشنا می‌شوید.',
                'image' => 'post-thumb-1.jpg',
            ],
            [
                'title' => 'چطور خرید هوشمندانه‌تری داشته باشیم؟',
                'excerpt' => 'با رعایت چند نکته ساده می‌توانید خریدی اقتصادی‌تر و کاربردی‌تر داشته باشید.',
                'content' => 'خرید هوشمندانه فقط به قیمت کمتر محدود نمی‌شود. انتخاب محصول مناسب، بررسی کیفیت و توجه به نیاز واقعی از مهم‌ترین نکات یک خرید خوب است.',
                'image' => 'post-thumb-2.jpg',
            ],
            [
                'title' => 'نکات مهم برای انتخاب محصولات باکیفیت',
                'excerpt' => 'قبل از خرید محصولات مختلف، بهتر است به چند نکته مهم درباره کیفیت آن‌ها توجه کنید.',
                'content' => 'کیفیت محصول، تاریخ تولید، شرایط نگهداری و تناسب آن با نیاز شما از مواردی هستند که هنگام خرید باید مورد توجه قرار بگیرند.',
                'image' => 'post-thumb-3.jpg',
            ],
        ];

        foreach ($posts as $data) {
            $image = $data['image'];

            unset($data['image']);

            $post = Post::create([
                ...$data,
                'author_id' => $author->id,
                'status' => PostStatus::PUBLISHED,
                'is_featured' => true,
                'published_at' => now(),
            ]);

            $imagePath = public_path("client/images/{$image}");

            if (!is_file($imagePath)) {
                throw new RuntimeException(
                    "Post image [{$image}] not found."
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
                model: $post,
                file: $uploadedFile,
                collection: MediaCollection::IMAGE,
                directory: 'posts',
            );
        }
    }
}

