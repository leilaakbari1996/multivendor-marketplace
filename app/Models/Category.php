<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasPersianSlug, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'slug',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    //region Morphs
    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('collection', 'image');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    //endregion

    //region Relationships

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    //endregion

    //region Scopes
    public function scopeActiveParents(Builder $query): Builder
    {
        return $query
            ->whereNull('parent_id')
            ->where('is_active', true);
    }
    //endregion


}
