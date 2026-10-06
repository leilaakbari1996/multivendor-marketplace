<?php

namespace App\Actions\Admin\Vendor;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Vendor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StoreVendorAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function execute(array $data): Vendor
    {
        return DB::transaction(function () use ($data) {
            $logo = $data['logo'] ?? null;
            $banner = $data['banner'] ?? null;

            unset(
                $data['logo'],
                $data['banner'],
            );

            $vendor = Vendor::create($data);

            if ($logo instanceof UploadedFile) {
                $this->storeMediaAction->execute(
                    model: $vendor,
                    file: $logo,
                    collection: MediaCollection::LOGO,
                    directory: 'vendors/logo'
                );
            }

            if ($banner instanceof UploadedFile) {
                $this->storeMediaAction->execute(
                    model: $vendor,
                    file: $banner,
                    collection: MediaCollection::BANNER,
                    directory: 'vendors/banner'
                );
            }

            return $vendor->refresh();
        });
    }
}
