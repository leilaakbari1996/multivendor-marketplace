<?php

namespace App\Queries;

use App\Enums\VendorStatus;
use App\Models\Vendor;

class VendorQuery
{

    public function approvedCount(): int
    {
        return Vendor::query()
            ->where('status', VendorStatus::APPROVED)
            ->count();
    }

}
