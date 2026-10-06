<?php

namespace Database\Seeders;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class SettingSeeder extends Seeder
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function run(): void
    {
        $settings = [
            'site_name' => 'مارکت هاب',
            'site_description' => 'فروشگاه آنلاین محصولات باکیفیت',

            'contact_phone' => '09013608442',
            'contact_email' => 'leila@gmail.com',
            'contact_address' => 'شیراز، ایران',

            'social_instagram' => 'https://instagram.com/markethub',
            'social_telegram' => 'https://t.me/markethub',
            'social_youtube' => 'https://youtube.com/@markethub',
            'social_facebook' => 'https://facebook.com/markethub',

            'footer_copyright' => 'تمامی حقوق این وب‌سایت محفوظ است.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->storeImageSetting(
            key: 'site_logo',
            fileName: 'logo.png',
            collection: MediaCollection::LOGO,
            directory: 'settings',
        );

//        $this->storeImageSetting(
//            key: 'site_favicon',
//            fileName: 'favicon.png',
//            collection: MediaCollection::FAVICON,
//            directory: 'settings',
//        );
    }

    private function storeImageSetting(
        string $key,
        string $fileName,
        MediaCollection $collection,
        string $directory,
    ): void {
        // ابتدا Setting را ایجاد می‌کنیم تا mediable_id داشته باشد.
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => null,
                'type' => 'image',
            ]
        );

        $filePath = public_path("client/images/{$fileName}");

        $file = new UploadedFile(
            $filePath,
            $fileName,
            mime_content_type($filePath),
            null,
            true
        );

        // حالا Setting دارای ID است و می‌تواند mediable باشد.
        $media = $this->storeMediaAction->execute(
            model: $setting,
            file: $file,
            collection: $collection,
            directory: $directory,
            width: null,
            height: null,
        );

        // ID مدیا داخل value تنظیمات ذخیره می‌شود.
        $setting->update([
            'value' => (string) $media->id,
        ]);
    }
}

