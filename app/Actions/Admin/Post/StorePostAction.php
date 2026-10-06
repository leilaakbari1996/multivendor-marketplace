<?php

namespace App\Actions\Admin\Post;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Post;
use App\Support\AuthUser;

class StorePostAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function execute(array $data): Post
    {
        $image = $data['image'] ?? null;

        unset($data['image']);
        $data['author_id'] = AuthUser::id();

        $post = Post::create($data);

        if ($image) {
            $this->storeMediaAction->execute(
                model: $post,
                file: $image,
                collection: MediaCollection::IMAGE,
                directory: 'posts',
            );
        }

        return $post;
    }
}

