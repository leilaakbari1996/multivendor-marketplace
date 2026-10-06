<?php

namespace App\Actions\Admin\Banner;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdateBannerAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    public function execute(
        Banner $banner,
        array $data
    ): Banner {
        return DB::transaction(function () use ($banner, $data) {
            $image = $data['image'] ?? null;

            unset($data['image']);

            $banner->update($data);

            if ($image instanceof UploadedFile) {
                $banner->media()
                    ->where('collection', MediaCollection::IMAGE)
                    ->delete();

                $this->storeMediaAction->execute(
                    model: $banner,
                    file: $image,
                    collection: MediaCollection::IMAGE,
                    directory: 'banners',
                );
            }

            return $banner->refresh();
        });
    }
}
