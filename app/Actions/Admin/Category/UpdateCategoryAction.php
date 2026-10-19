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

final class UpdateCategoryAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
        private readonly SyncTagsAction $syncTagsAction,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public function execute(Category $category, array $data): Category
    {
        $image = Arr::pull($data, 'image');
        $tags = Arr::pull($data, 'tags', []);

        return DB::transaction(function () use ($category, $data, $image, $tags): Category {
            $category->update($data);

            if ($image instanceof UploadedFile) {
                $this->storeMediaAction->execute(
                    model: $category,
                    file: $image,
                    collection: MediaCollection::IMAGE,
                    directory: 'categories',
                    replaceExisting: true,
                );
            }

            $this->syncTagsAction->execute(
                model: $category,
                tags: $tags,
            );

            return $category->refresh();
        });
    }
}
