<?php

namespace App\Actions\Admin\Vendor;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Vendor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdateVendorAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function execute(Vendor $vendor, array $data): Vendor
    {
        return DB::transaction(function () use ($vendor, $data) {

            $logo = $data['logo'] ?? null;
            $banner = $data['banner'] ?? null;

            unset(
                $data['logo'],
                $data['banner'],
            );

            // آپدیت اطلاعات Vendor
            $vendor->update($data);

            // لوگو
            if ($logo instanceof UploadedFile) {
                $vendor->media()
                    ->where('collection', MediaCollection::LOGO)
                    ->delete();

                $this->storeMediaAction->execute(
                    model: $vendor,
                    file: $logo,
                    collection: MediaCollection::LOGO,
                    directory: 'vendors/logo',
                );
            }

            // بنر
            if ($banner instanceof UploadedFile) {
                $vendor->media()
                    ->where('collection', MediaCollection::BANNER)
                    ->delete();

                $this->storeMediaAction->execute(
                    model: $vendor,
                    file: $banner,
                    collection: MediaCollection::BANNER,
                    directory: 'vendors/banner',
                );
            }

            return $vendor->refresh();
        });
    }
}
