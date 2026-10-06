<?php

namespace App\Actions\Admin\Vendor;

use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class DeleteVendorAction
{
    public function execute(Vendor $vendor): void
    {
        DB::transaction(function () use ($vendor) {
            $vendor->media()->delete();

            $vendor->delete();
        });
    }
}
