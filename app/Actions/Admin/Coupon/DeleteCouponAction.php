<?php

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;

class DeleteCouponAction
{
    public function execute(Coupon $coupon): void
    {
        $coupon->delete();
    }
}
