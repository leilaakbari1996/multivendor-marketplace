<?php

namespace App\Actions\Admin\Category;

use App\Models\Category;

class DeleteCategoryAction
{
    public function __construct(
    ) {
    }

    public function execute(Category $category): void
    {
        $category->delete();
//        DB::transaction(function () use ($category) {
//            $category->load('media');
//
//            foreach ($category->media as $media) {
//                $this->fileUploader->delete(
//                    path: $media->file_path,
//                    disk: $media->disk,
//                );
//            }
//
//            $category->tags()->detach();
//            $category->media()->delete();
//            $category->delete();
//        });
    }
}
