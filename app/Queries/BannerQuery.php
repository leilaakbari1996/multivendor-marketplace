<?php

namespace App\Queries;

use App\Enums\BannerPosition;
use App\Models\Banner;
use Illuminate\Database\Eloquent\Collection;

class BannerQuery
{
    public function get(bool $activeOnly = true): Collection
    {
        $query = Banner::query()
            ->ordered()
            ->with('media');

        if ($activeOnly) {
            $query->active();
        }

        return $query->get();
    }

    public function byPosition(bool $activeOnly = true): Collection
    {
        return $this->get($activeOnly)
            ->groupBy('position');
    }
    public function forHome(): array
    {
        $banners = $this->byPosition();

        return [
            'main' => $banners->get(
                BannerPosition::MAIN->value,
                collect()
            ),

            'side_top' => $banners->get(
                BannerPosition::SIDE_TOP->value,
                collect()
            )->first(),

            'side_bottom' => $banners->get(
                BannerPosition::SIDE_BOTTOM->value,
                collect()
            )->first(),

            'promo' => $banners->get(
                BannerPosition::PROMO->value,
                collect()
            ),
        ];
    }
}
