<?php

declare(strict_types=1);

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;

class UpdateCouponAction
{
    /**
     * @param array<string, mixed> $data
     */
    public function execute(Coupon $coupon, array $data): Coupon
    {
        $coupon->update($data);

        return $coupon->refresh();
    }
}
