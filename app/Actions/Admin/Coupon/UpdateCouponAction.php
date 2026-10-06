<?php

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;

class UpdateCouponAction
{
    public function execute(Coupon $coupon, array $data): Coupon
    {
        $coupon->update($data);

        return $coupon->refresh();
    }
}
