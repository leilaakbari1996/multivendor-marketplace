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
        ];
    }
}

