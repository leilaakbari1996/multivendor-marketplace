<?php

namespace App\Constants\Client;

class CartConstant
{
    /**
     * حداکثر تعداد مجاز از هر محصول در سبد
     */
    public const MAX_QUANTITY_PER_ITEM = 20;

    /**
     * حداقل تعداد مجاز برای افزودن به سبد
     */
    public const MIN_QUANTITY = 1;

    /**
     * تعداد پیش‌فرض هنگام افزودن محصول
     */
    public const DEFAULT_QUANTITY = 1;
}
