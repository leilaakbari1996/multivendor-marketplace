<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Banner;

class UpdateBannerRequest extends BaseBannerRequest
{
    protected function imageRules(): array
    {
        // Optional on update: keep the current image when none is uploaded.
        return ['bail', 'nullable', $this->imageFileRule()];
    }
}
