<?php

namespace App\Actions\Admin\Post;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Post;

class UpdatePostAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function execute(
        Post $post,
        array $data
    ): Post {
        $image = $data['image'] ?? null;

        unset($data['image']);

        $post->update($data);

        if ($image) {
            $this->storeMediaAction->execute(
                model: $post,
                file: $image,
                collection: MediaCollection::IMAGE,
                directory: 'posts',
                replaceExisting: true,
            );
        }

        return $post->refresh();
    }
}
