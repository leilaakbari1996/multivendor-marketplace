<?php

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;

class StoreCouponAction
{
    public function execute(array $data): Coupon
    {
        return Coupon::create($data);
    }
}
