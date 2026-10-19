<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Coupon;

use App\Models\Coupon;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends BaseCouponRequest
{
    protected function codeUniqueRule(): mixed
    {
        $coupon = $this->route('coupon');

        return Rule::unique('coupons', 'code')
            ->ignore($coupon instanceof Coupon ? $coupon->getKey() : null);
    }
}
