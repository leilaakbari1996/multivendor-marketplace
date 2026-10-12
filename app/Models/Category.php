<?php

namespace App\Models;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
        'meta_description',
        'is_main',
        'type'
    ];

    protected function casts(): array
    {
        return [
            'type'       => CategoryType::class,
            'is_active' => 'boolean',
            'is_main' => 'boolean',
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

    public function faqs() : MorphToMany
    {
        return $this->morphedByMany(Faq::class, 'categorizable');
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'categorizable');
    }
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

    //endregion

    //region Scopes

    public function scopeOfType(Builder $query, CategoryType $type): Builder
    {
        return $query->where('type', $type->value);
    }
    public function scopeActiveParents(Builder $query): Builder
    {
        return $query
            ->whereNull('parent_id')
            ->active();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
    public function scopeMain(Builder $query): Builder
    {
        return $query->where('is_main', true);
    }

    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query
            ->where('slug', $slug)
            ;
    }
    //endregion


}
