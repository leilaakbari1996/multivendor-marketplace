<?php

namespace App\Queries;

use App\Constants\Client\BlogConstant;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PostQuery
{
    public function paginate(int $perPage = BlogConstant::PER_PAGE, array $filters = []): LengthAwarePaginator
    {
        return Post::query()
            ->published()
            ->with([
                'image',
                'author',
            ])
            ->when(
                $filters['search'] ?? null,
                fn (Builder $query, string $search) => $query->search($search)
            )
            ->when(
                $filters['category'] ?? null,
                fn (Builder $query, int $category) => $query->category($category)
            )
            ->when(
                $filters['featured'] ?? null,
                fn (Builder $query) => $query->featured()
            )
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function recent(int $limit = BlogConstant::RECENT_POSTS_LIMIT, ?int $exceptId = null): Collection
    {
        return Post::query()
            ->published()
            ->with('image')
            ->when($exceptId, fn (Builder $query, int $id) => $query->whereKeyNot($id))
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function previous(Post $post, array $select = ['slug', 'title']): ?Post
    {
        return Post::query()
            ->select($select)
            ->published()
            ->where(fn (Builder $q) => $q
                ->where('published_at', '<', $post->published_at)
                ->orWhere(fn (Builder $q) => $q
                    ->where('published_at', $post->published_at)
                    ->where('id', '<', $post->id)))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->first();
    }

    public function next(Post $post,  array $select = ['slug', 'title']): ?Post
    {
        return Post::query()
            ->select($select)
            ->published()
            ->where(fn (Builder $q) => $q
                ->where('published_at', '>', $post->published_at)
                ->orWhere(fn (Builder $q) => $q
                    ->where('published_at', $post->published_at)
                    ->where('id', '>', $post->id)))
            ->orderBy('published_at')
            ->orderBy('id')
            ->first();
    }
}
