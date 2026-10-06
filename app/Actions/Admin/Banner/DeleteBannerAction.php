<?php

namespace App\Actions\Admin\Banner;

use App\Models\Banner;
use Illuminate\Support\Facades\DB;

class DeleteBannerAction
{
    public function execute(Banner $banner): bool
    {
        return DB::transaction(function () use ($banner) {
            $banner->media()->delete();

            return (bool) $banner->delete();
        });
    }
}
