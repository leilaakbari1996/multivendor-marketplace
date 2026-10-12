<?php

namespace Database\Seeders;

use App\Enums\CategoryType;
use App\Models\Category;
use App\Models\Faq;
use Illuminate\Database\Seeder;
use RuntimeException;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // فقط دسته‌های نوع «سوالات متداول»
        $categories = Category::query()
            ->where('type', CategoryType::Faq->value)
            ->pluck('id', 'name');

        if ($categories->isEmpty()) {
            throw new RuntimeException(
                'No FAQ categories found. Please run CategorySeeder before FaqSeeder.'
            );
        }

        $items = [
            [
                'category' => 'سفارش',
                'icon' => 'bi-bag-check',
                'question' => 'چطور سفارش ثبت کنم؟',
                'answer' => 'کالاها را به سبد خرید اضافه کنید، آدرس و شماره تماس را وارد کنید و پرداخت را نهایی کنید. پس از ثبت، پیامک تأیید برایتان ارسال می‌شود.',
            ],
            [
                'category' => 'سفارش',
                'icon' => 'bi-pencil-square',
                'question' => 'آیا می‌توانم سفارش را بعد از ثبت تغییر دهم؟',
                'answer' => 'تا قبل از تحویل سفارش به پیک، با پشتیبانی تماس بگیرید تا کالاها یا آدرس را اصلاح کنیم. پس از خروج پیک، تغییر ممکن نیست.',
            ],
            [
                'category' => 'سفارش',
                'icon' => 'bi-box-seam',
                'question' => 'اگر کالایی ناموجود شد چه می‌شود؟',
                'answer' => 'در این حالت با شما تماس می‌گیریم. می‌توانید کالای جایگزین انتخاب کنید یا آن را از سفارش حذف کنید؛ مبلغ کالای حذف‌شده برگردانده می‌شود.',
            ],
            [
                'category' => 'پرداخت',
                'icon' => 'bi-credit-card',
                'question' => 'روش‌های پرداخت چیست؟',
                'answer' => 'پرداخت آنلاین از طریق درگاه بانکی و در صورت فعال بودن، پرداخت در محل هنگام تحویل.',
            ],
            [
                'category' => 'پرداخت',
                'icon' => 'bi-cash-coin',
                'question' => 'پول از حسابم کم شد ولی سفارش ثبت نشد، چه کنم؟',
                'answer' => 'نگران نباشید. مبلغ کسرشده معمولاً ظرف چند روز کاری به حساب شما برمی‌گردد. اگر دیرتر شد، با ذکر شماره پیگیری بانکی با پشتیبانی تماس بگیرید.',
            ],
            [
                'category' => 'ارسال',
                'icon' => 'bi-truck',
                'question' => 'سفارش چه ساعاتی تحویل داده می‌شود؟',
                'answer' => 'ارسال سفارش‌ها شنبه تا جمعه، ساعت ۸ تا ۲۲ انجام می‌شود. زمان تقریبی تحویل پیش از نهایی کردن سفارش نمایش داده می‌شود.',
            ],
            [
                'category' => 'ارسال',
                'icon' => 'bi-geo-alt',
                'question' => 'به کدام مناطق ارسال دارید؟',
                'answer' => 'در حال حاضر ارسال در محدوده شهر شیراز انجام می‌شود. محدوده‌های جدید در همین بخش اطلاع‌رسانی خواهد شد.',
            ],
            [
                'category' => 'ارسال',
                'icon' => 'bi-telephone',
                'question' => 'پیک به تماسم پاسخ نداد، چه کنم؟',
                'answer' => 'با شماره پشتیبانی تماس بگیرید تا وضعیت سفارش و موقعیت پیک را بررسی کنیم.',
            ],
            [
                'category' => 'مرجوعی',
                'icon' => 'bi-arrow-repeat',
                'question' => 'در چه شرایطی می‌توانم کالا را مرجوع کنم؟',
                'answer' => "• کالا خراب، فاسد یا تاریخ‌گذشته باشد.\n• کالای ارسالی با سفارش شما متفاوت باشد.\n• درخواست حداکثر ۲۴ ساعت پس از تحویل و همراه با عکس کالا ثبت شود.",
            ],
            [
                'category' => 'مرجوعی',
                'icon' => 'bi-wallet2',
                'question' => 'پول کالای مرجوعی چه زمانی برمی‌گردد؟',
                'answer' => 'پس از تأیید مرجوعی توسط کارشناسان، مبلغ به همان روش پرداخت به شما برگردانده می‌شود.',
            ],
            [
                'category' => 'حساب کاربری',
                'icon' => 'bi-person-check',
                'question' => 'برای خرید باید حتماً ثبت‌نام کنم؟',
                'answer' => 'بله. ثبت‌نام فقط با شماره موبایل و کد تأیید انجام می‌شود و چند ثانیه بیشتر زمان نمی‌برد.',
            ],
            [
                'category' => 'حساب کاربری',
                'icon' => 'bi-shield-lock',
                'question' => 'اطلاعات من نزد فودمارت امن است؟',
                'answer' => 'اطلاعات شما فقط برای پردازش سفارش، ارسال و پشتیبانی استفاده می‌شود و بدون اجازه شما در اختیار دیگران قرار نمی‌گیرد. جزئیات در صفحه قوانین و شرایط آمده است.',
            ],
        ];

        foreach ($items as $index => $data) {
            $categoryId = $categories->get($data['category']);

            if (! $categoryId) {
                throw new RuntimeException(
                    "FAQ category [{$data['category']}] not found."
                );
            }

            $faq = Faq::query()->firstOrCreate(
                ['question' => $data['question']],
                [
                    'answer' => $data['answer'],
                    'icon' => $data['icon'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

            // رابطه‌ی مورف: ثبت در جدول categorizables
            $faq->categories()->syncWithoutDetaching([$categoryId]);
        }
    }
}
