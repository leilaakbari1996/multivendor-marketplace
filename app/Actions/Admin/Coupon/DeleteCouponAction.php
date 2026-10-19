<?php

declare(strict_types=1);

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;

final class DeleteCouponAction
{
    public function execute(Coupon $coupon): void
    {
        $coupon->delete();
    }
}
