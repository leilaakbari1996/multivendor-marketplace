<?php
namespace App\Actions\Admin\Category;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Actions\Admin\Tag\SyncTagsAction;
use App\Enums\MediaCollection;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StoreCategoryAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
        private readonly SyncTagsAction $syncTagsAction,
    ) {
    }

    public function execute(array $data): Category
    {
        return DB::transaction(function () use ($data) {
            $image = $data['image'] ?? null;
            $tags = $data['tags'] ?? [];

            unset($data['image'], $data['tags']);

            $category = Category::create($data);



            if ($image instanceof UploadedFile) {
                $this->storeMediaAction->execute(
                    model: $category,
                    file: $image,
                    collection: MediaCollection::IMAGE,
                    directory: 'categories',
                );
            }

            if ($tags) {
                $this->syncTagsAction->execute(
                    model: $category,
                    tags: $tags,
                );
            }

            return $category;
        });
    }
}
