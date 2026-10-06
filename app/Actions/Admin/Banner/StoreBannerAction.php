<?php

namespace App\Actions\Admin\Banner;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StoreBannerAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    public function execute(array $data): Banner
    {
        return DB::transaction(function () use ($data) {
            $image = $data['image'] ?? null;

            unset($data['image']);

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
