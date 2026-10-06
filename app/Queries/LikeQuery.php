<?php

namespace App\Queries;

use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LikeQuery
{
    public function posts(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Post::query()
            ->likedBy($userId)
            ->latest()
            ->paginate($perPage, ['*'], 'posts_page');
    }

    public function products(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Product::query()
            ->likedBy($userId)
            ->latest()
            ->paginate($perPage, ['*'], 'products_page');
    }

    public function forUser(
        User $user,
        int $perPage = 12,
    ): array {
        return [
            'posts' => self::posts($user->id,$perPage),
            'products' => self::products($user->id,$perPage)
        ];
    }
}
