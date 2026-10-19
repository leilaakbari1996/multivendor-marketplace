<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Validation\Rule;

class StoreCouponRequest extends BaseCouponRequest
{
    protected function codeUniqueRule(): mixed
    {
        return Rule::unique('coupons', 'code');
    }
}
