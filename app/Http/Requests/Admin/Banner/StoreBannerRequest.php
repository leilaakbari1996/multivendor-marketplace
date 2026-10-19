<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Banner;

class StoreBannerRequest extends BaseBannerRequest
{
    protected function imageRules(): array
    {
        return ['bail', 'required', $this->imageFileRule()];
    }
}
