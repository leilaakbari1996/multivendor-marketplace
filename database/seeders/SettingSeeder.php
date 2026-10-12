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
            'contact_address' => 'ایران شیراز میدان ارم',
            'contact_hours' => 'شنبه تا جمعه 8 تا 22',
            'support_phone' => '09013608442',
            'contact_map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13872.79737371563!2d52.538643!3d29.626953!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fb20d9e16ddb3ef%3A0x5f683b7557c04c54!2z2KjYp9iy2KfYsSDYp9mG2YLZhNin2Kg!5e0!3m2!1sen!2sus!4v1791558287777!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>',
            'social_instagram' => 'https://instagram.com/markethub',
            'social_telegram' => 'https://t.me/markethub',
            'social_whatsapp' => '09013608442',
            'footer_copyright' => 'تمامی حقوق این وب‌سایت محفوظ است.',
            'contact_hero_description' => 'خوشحال می‌شویم صدای شما را بشنویم! برای پشتیبانی سفارش، همکاری و هر سوالی فرم زیر را پر کنید یا با راه‌های ارتباطی تماس بگیرید.',
            'contact_hero_title' => 'تماس با ما',
            'cta_shop_description' => 'محصولات تازه و پرتخفیف منتظر شماست.',
            'cta_shop_title' => 'آماده‌اید خرید کنید؟',
            'about_our_story' => 'فودمارت با یک هدف شروع شد: اینکه خرید مایحتاج روزانه، بی‌دغدغه و با کیفیتی که به آن اعتماد دارید انجام شود. از میوه و سبزیجات تازه تا نوشیدنی و لبنیات، همه را در یک‌جا کنار هم آورده‌ایم.
ما فقط محصول نمی‌فروشیم؛ تلاش می‌کنیم تجربه‌ی خرید شما از انتخاب تا تحویل، روان و قابل‌اعتماد باشد.             ',
            'about_hero_description' => 'خرید روزانه‌ی خانه را ساده، سریع و مطمئن می‌کنیم.',
            'about_hero_title' => 'درباره ما',
            'faq_hero_title' => 'سوالات متداول',
            'faq_hero_description' => 'پاسخ سوالات پرتکرار شما درباره خرید، سفارش و خدمات مارکت هاب.',


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

