<?php

declare(strict_types=1);

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;

final class StoreCouponAction
{
    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): Coupon
    {
          return Coupon::create($data);
    }
}
