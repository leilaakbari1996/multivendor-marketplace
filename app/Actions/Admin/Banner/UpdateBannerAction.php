<?php

declare(strict_types=1);

namespace App\Actions\Admin\Banner;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class UpdateBannerAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(Banner $banner, array $data): Banner
    {
        // The image is not a column, so take it out before updating the model.
        $image = Arr::pull($data, 'image');

        return DB::transaction(function () use ($banner, $data, $image): Banner {
            $banner->update($data);

            if ($image instanceof UploadedFile) {
                // Store the new image and remove the old one in a safe order.
                $this->storeMediaAction->execute(
                    model: $banner,
                    file: $image,
                    collection: MediaCollection::IMAGE,
                    directory: 'banners',
                    replaceExisting: true,
                );
            }

            return $banner->refresh();
        });
    }
}
