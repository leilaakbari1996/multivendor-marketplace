<?php

namespace App\Actions\Admin\Product;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StoreProductAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {}

    public function execute(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            $image = $data['image'] ?? null;

            unset($data['image']);

            $product = Product::create($data);

            if ($image instanceof UploadedFile) {
                $this->storeMediaAction->execute(
                    model: $product,
                    file: $image,
                    collection: MediaCollection::IMAGE,
                    directory: 'products/images',
                    replaceExisting: true,
                );
            }

            return $product->refresh();
        });
    }
}
