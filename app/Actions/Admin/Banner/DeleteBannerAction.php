<?php

declare(strict_types=1);

namespace App\Actions\Admin\Banner;

use App\Models\Banner;

final class DeleteBannerAction
{
    public function execute(Banner $banner): void
    {
        // Soft delete: the record and its media are kept, so restore() works.
        $banner->delete();
    }
}
