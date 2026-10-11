<?php

namespace App\Models;

use App\Enums\MediaCollection;
use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Stevebauman\Purify\Facades\Purify;

class Post extends Model
{
    use SoftDeletes, HasPersianSlug;

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

    //region Relationships

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    //endregion

    //region Morphs

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('collection', MediaCollection::IMAGE);
    }

    //endregion

    //region Scopes

    public function scopeLikedBy(Builder $query, int $userId): Builder
    {
        return $query->whereHas('likes', function (Builder $query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', PostStatus::PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query
            ->where('is_featured', true);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where('title', 'like', "%{$term}%");
    }

    //endregion

    //region Attributes

    protected function content(): Attribute
    {
        return Attribute::set(fn (?string $value) => Purify::clean($value ?? ''));
    }

    //endregion

}

