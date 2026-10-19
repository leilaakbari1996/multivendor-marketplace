<?php

declare(strict_types=1);

namespace App\Actions\Admin\Category;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Actions\Admin\Tag\SyncTagsAction;
use App\Enums\MediaCollection;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class StoreCategoryAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
        private readonly SyncTagsAction $syncTagsAction,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): Category
    {
        $image = Arr::pull($data, 'image');
        $tags = Arr::pull($data, 'tags', []);

        return DB::transaction(function () use ($data, $image, $tags): Category {
            $category = Category::create($data);

            if ($image instanceof UploadedFile) {
                $this->storeMediaAction->execute(
                    model: $category,
                    file: $image,
                    collection: MediaCollection::IMAGE,
                    directory: 'categories',
                );
            }

            if ($tags !== []) {
                $this->syncTagsAction->execute(
                    model: $category,
                    tags: $tags,
                );
            }

            return $category;
        });
    }
}
