<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasMedia;
use App\Enums\MediaCollection;
use App\Enums\PostStatus;
use App\Traits\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;
use Stevebauman\Purify\Facades\Purify;

class Post extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    use HasPersianSlug;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'is_featured',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    // Relationships

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Morphs

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('collection', MediaCollection::IMAGE);
    }

    // Scopes

    /**
     * @param Builder<Post> $query
     * @return Builder<Post>
     */
    public function scopeLikedBy(Builder $query, int $userId): Builder
    {
        return $query->whereHas(
            'likes',
            fn (Builder $query) => $query->where('user_id', $userId),
        );
    }

    /**
     * @param Builder<Post> $query
     * @return Builder<Post>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', PostStatus::PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @param Builder<Post> $query
     * @return Builder<Post>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * @param Builder<Post> $query
     * @return Builder<Post>
     */
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where('title', 'like', "%{$term}%");
    }

    // Attributes

    protected function content(): Attribute
    {
        return Attribute::set(
            fn (?string $value): string => Purify::clean($value ?? ''),
        );
    }
}
