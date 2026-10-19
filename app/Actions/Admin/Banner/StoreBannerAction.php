<?php

declare(strict_types=1);

namespace App\Actions\Admin\Banner;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class StoreBannerAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): Banner
    {
        // The image is not a column, so take it out before creating the model.
        $image = Arr::pull($data, 'image');

        return DB::transaction(function () use ($data, $image): Banner {
            $banner = Banner::create($data);

            if ($image instanceof UploadedFile) {
                $this->storeMediaAction->execute(
                    model: $banner,
                    file: $image,
                    collection: MediaCollection::IMAGE,
                    directory: 'banners',
                );
            }

            return $banner;
        });
    }
}
