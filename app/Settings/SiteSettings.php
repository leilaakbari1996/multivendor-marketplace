<?php

namespace App\Settings;

class SiteSettings
{
    public static function definitions(): array
    {
        return [
            [
                'label' => 'لوگو سایت',
                'type' => 'image',
                'name' => 'site_logo',
                'required' => false,
                'accept' => 'image/*',
                'description' => 'لوگوی اصلی سایت',
            ],

            [
                'label' => 'فاویکون',
                'type' => 'image',
                'name' => 'site_favicon',
                'required' => false,
                'accept' => 'image/png,image/x-icon',
                'description' => 'آیکون سایت در مرورگر',
            ],

            [
                'label' => 'نام سایت',
                'type' => 'text',
                'name' => 'site_name',
                'placeholder' => 'نام سایت',
                'required' => true,
            ],

            [
                'label' => 'توضیحات سایت',
                'type' => 'textarea',
                'name' => 'site_description',
                'placeholder' => 'توضیحات سایت',
                'required' => false,
            ],

            [
                'label' => 'شماره تماس',
                'type' => 'text',
                'name' => 'contact_phone',
                'placeholder' => 'شماره تماس',
                'required' => false,
            ],

            [
                'label' => 'ایمیل',
                'type' => 'email',
                'name' => 'contact_email',
                'placeholder' => 'example@example.com',
                'required' => false,
            ],

            [
                'label' => 'آدرس',
                'type' => 'textarea',
                'name' => 'contact_address',
                'placeholder' => 'آدرس فروشگاه',
                'required' => false,
            ],

            [
                'label' => 'اینستاگرام',
                'type' => 'url',
                'name' => 'social_instagram',
                'placeholder' => 'لینک اینستاگرام',
                'required' => false,
            ],

            [
                'label' => 'تلگرام',
                'type' => 'url',
                'name' => 'social_telegram',
                'placeholder' => 'لینک تلگرام',
                'required' => false,
            ],

            [
                'label' => 'یوتیوب',
                'type' => 'url',
                'name' => 'social_youtube',
                'placeholder' => 'لینک یوتیوب',
                'required' => false,
            ],

            [
                'label' => 'فیسبوک',
                'type' => 'url',
                'name' => 'social_facebook',
                'placeholder' => 'لینک فیسبوک',
                'required' => false,
            ],

            [
                'label' => 'متن کپی‌رایت',
                'type' => 'text',
                'name' => 'footer_copyright',
                'placeholder' => 'متن کپی‌رایت فوتر',
                'required' => false,
            ],
            [
                'label' => 'ساعت کاری',
                'type' => 'text',
                'name' => 'contact_hours',
                'placeholder' => 'شنبه تا جمعه 8 تا 22',
                'required' => false,
            ],

            [
                'label' => 'لینک نقشه (iframe گوگل‌مپ)',
                'type' => 'textarea',
                'name' => 'contact_map_embed',
                'placeholder' => 'کد embed گوگل مپ',
                'required' => false,
                'description' => 'از گوگل‌مپ گزینه Share > Embed کپی کنید',
            ],

            [
                'label' => 'واتساپ',
                'type' => 'text', // نه url
                'name' => 'social_whatsapp',
                'placeholder' => '09120000001',
                'required' => false,
            ],

            [
                'label' => 'شماره پشتیبانی سفارش',
                'type' => 'text',
                'name' => 'support_phone',
                'placeholder' => 'شماره پشتیبانی',
                'required' => false,
            ],

            // صفحه درباره ما (About)

            [
                'page'  => 'about',
                'label' => 'عنوان هیرو درباره ما',
                'type' => 'text',
                'name' => 'about_hero_title',
                'placeholder' => 'درباره ما',
                'required' => false,
            ],

            [
                'page'  => 'about',
                'label' => 'توضیحات هیرو درباره ما',
                'type' => 'textarea',
                'name' => 'about_hero_description',
                'placeholder' => 'توضیحات بخش ابتدایی صفحه درباره ما',
                'required' => false,
            ],

            [
                'page'  => 'about',
                'label' => 'داستان ما',
                'type' => 'textarea',
                'name' => 'about_our_story',
                'placeholder' => 'داستان شکل‌گیری فروشگاه',
                'required' => false,
            ],

        // باکس دعوت به خرید (Call To Action)

            [
                'page'  => 'about',
                'label' => 'عنوان باکس دعوت به خرید',
                'type' => 'text',
                'name' => 'cta_shop_title',
                'placeholder' => 'آماده‌اید خرید کنید؟',
                'required' => false,
            ],

            [
                'page'  => 'about',
                'label' => 'توضیحات باکس دعوت به خرید',
                'type' => 'textarea',
                'name' => 'cta_shop_description',
                'placeholder' => 'محصولات تازه و پرتخفیف منتظر شماست.',
                'required' => false,
            ],

        // صفحه تماس با ما (Contact)

            [
                'page'  => 'contact',
                'label' => 'عنوان هیرو تماس با ما',
                'type' => 'text',
                'name' => 'contact_hero_title',
                'placeholder' => 'تماس با ما',
                'required' => false,
            ],

            [
                'page'  => 'contact',
                'label' => 'توضیحات هیرو تماس با ما',
                'type' => 'textarea',
                'name' => 'contact_hero_description',
                'placeholder' => 'برای ارتباط با ما و دریافت راهنمایی در کنار شما هستیم.',
                'required' => false,
            ],

            // صفحه سوالات متداول (FAQ)

            [
                'page' => 'faq',
                'label' => 'عنوان هیرو سوالات متداول',
                'type' => 'text',
                'name' => 'faq_hero_title',
                'placeholder' => 'سوالات متداول',
                'required' => false,
            ],

            [
                'page' => 'faq',
                'label' => 'توضیحات هیرو سوالات متداول',
                'type' => 'textarea',
                'name' => 'faq_hero_description',
                'placeholder' => 'پاسخ سوالات پرتکرار شما درباره خرید، سفارش و خدمات مارکت هاب.',
                'required' => false,
            ],

        ];
    }

    public static function socials() : array
    {
        $socials = $socials ?? [
            'social_instagram' => ['icon' => 'bi-instagram', 'label' => 'اینستاگرام'],
            'social_telegram'  => ['icon' => 'bi-telegram', 'label' => 'تلگرام'],
            'social_whatsapp'  => ['icon' => 'bi-whatsapp', 'label' => 'واتساپ'],
            'social_youtube'   => ['icon' => 'bi-youtube', 'label' => 'یوتیوب'],
            'social_facebook'  => ['icon' => 'bi-facebook', 'label' => 'فیسبوک'],
        ];

        return $socials;
    }
}

