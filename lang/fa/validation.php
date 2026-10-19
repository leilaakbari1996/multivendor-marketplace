<?php

return [

    'required' => 'وارد کردن :attribute الزامی است.',

    'string' => ':attribute باید از نوع رشته باشد.',

    'integer' => ':attribute باید یک عدد صحیح باشد.',

    'numeric' => ':attribute باید یک عدد باشد.',

    'url' => ':attribute باید یک آدرس معتبر (با http یا https) باشد.',

    'enum' => ':attribute انتخاب‌شده معتبر نیست.',

    'file' => ':attribute باید یک فایل باشد.',

    'uploaded' => 'بارگذاری :attribute ناموفق بود. حجم فایل را بررسی کنید.',

    'extensions' => ':attribute باید یکی از این پسوندها را داشته باشد: :values.',

    'mimetypes' => ':attribute باید از نوع: :values باشد.',

    'min' => [
        'numeric' => ':attribute باید حداقل :min باشد.',
        'string' => ':attribute باید حداقل :min کاراکتر باشد.',
        'array' => ':attribute باید حداقل :min مورد داشته باشد.',
        'file' => 'حجم :attribute باید حداقل :min کیلوبایت باشد.',
    ],

    'max' => [
        'numeric' => ':attribute نباید بیشتر از :max باشد.',
        'string' => ':attribute نباید بیشتر از :max کاراکتر باشد.',
        'array' => ':attribute نباید بیشتر از :max مورد داشته باشد.',
        'file' => 'حجم :attribute نباید بیشتر از :max کیلوبایت باشد.',
    ],

    'size' => [
        'numeric' => ':attribute باید برابر با :size باشد.',
        'string' => ':attribute باید :size کاراکتر باشد.',
        'array' => ':attribute باید :size مورد داشته باشد.',
        'file' => 'حجم :attribute باید :size کیلوبایت باشد.',
    ],

    'unique' => ':attribute قبلاً ثبت شده است.',

    'exists' => ':attribute انتخاب‌شده معتبر نیست.',

    'confirmed' => 'تکرار :attribute با آن مطابقت ندارد.',

    'image' => ':attribute باید یک تصویر باشد.',

    'mimes' => ':attribute باید از نوع: :values باشد.',

    'lte' => [
        'numeric' => ':attribute باید کمتر یا مساوی :value باشد.',
        'string' => ':attribute باید حداکثر :value کاراکتر باشد.',
        'file' => 'حجم :attribute باید کمتر یا مساوی :value کیلوبایت باشد.',
        'array' => ':attribute باید کمتر یا مساوی :value مورد باشد.',
    ],

    'boolean' => ':attribute باید درست یا نادرست باشد.',

    'in' => ':attribute انتخاب‌شده معتبر نیست.',

    'nullable' => ':attribute می‌تواند خالی باشد.',

    'custom' => [

        'current_password' => [
            'current_password' => 'رمز عبور فعلی اشتباه است.',
        ],

        'mobile' => [
            'unique' => 'این شماره موبایل قبلاً ثبت شده است.',
        ],

        'password' => [
            'min' => 'رمز عبور باید حداقل :min کاراکتر باشد.',
            'confirmed' => 'تکرار رمز عبور با رمز عبور مطابقت ندارد.',
        ],

    ],

    'attributes' => [

        'user_name' => 'نام کاربری',
        'name' => 'نام',
        'mobile' => 'شماره موبایل',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تکرار رمز عبور',

        'type' => 'نوع کاربر',
        'status' => 'وضعیت',

        'image' => 'تصویر',
        'url' => 'آدرس سایت',

        'store_name' => 'نام فروشگاه',
        'user_id' => 'کاربر',

        'vendor_id' => 'فروشنده',
        'category_id' => 'دسته‌بندی',

        'slug' => 'نامک',
        'sku' => 'کد محصول',

        'description' => 'توضیحات',

        'price' => 'قیمت',
        'discount_price' => 'قیمت با تخفیف',

        'stock' => 'موجودی',
        'weight' => 'وزن',
        'location' => 'محل نمایش',
        'parent_id' => 'منوی والد',
        'title' => 'عنوان',
        'subtitle' => 'عنوان فرعی',
        'position' => 'موقعیت بنر',
        'sort_order' => 'ترتیب نمایش',
        'is_active' => 'وضعیت',
        'content' => 'محتوا',
        'avatar' => 'تصویر پروفایل',
        'current_password' => 'رمز فعلی',

        'phone' => 'شماره موبایل',
        'pass'  => 'رمز عبور',
        'pass2' => 'تکرار رمز عبور',
        'terms' => 'قوانین و مقررات',
        'subject' => 'موضوع',
        'message' => 'پیام'

    ],

];
