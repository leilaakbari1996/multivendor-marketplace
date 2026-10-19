<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasMedia;
use App\Enums\CategoryType;
use App\Enums\MediaCollection;
use App\Traits\InteractsWithMedia;
use App\Traits\PrunesSoftDeleted;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    use HasPersianSlug;
    use InteractsWithMedia;
    use PrunesSoftDeleted;
    use SoftDeletes;

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
        'type',
    ];

    protected function casts(): array
    {
        return [
            'type' => CategoryType::class,
            'is_active' => 'boolean',
            'is_main' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            // Renaming a category must not change its URL (SEO, bookmarks).
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Only categories that no other category depends on are pruned.
     * Children point to their parent, so deleting the parent would break them.
     *
     * @return Builder<Category>
     */
    public function prunable(): Builder
    {
        return static::onlyTrashed()
            ->where($this->getQualifiedDeletedAtColumn(), '<=', now()->subDays($this->pruneAfterDays()))
            ->whereDoesntHave('children');
    }

    /**
     * Runs right before a pruned category is deleted for good.
     * Pivot rows have no foreign key cascade, so remove them here.
     */
    protected function pruning(): void
    {
        $this->faqs()->detach();
        $this->products()->detach();
        $this->tags()->detach();
    }

    // Relationships

    /**
     * Convenience relation for the single category image.
     * The generic media() relation comes from InteractsWithMedia.
     *
     * @return MorphOne<Media, $this>
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('collection', MediaCollection::IMAGE->value);
    }

    public function faqs(): MorphToMany
    {
        return $this->morphedByMany(Faq::class, 'categorizable');
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'categorizable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Scopes

    /**
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeOfType(Builder $query, CategoryType $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeActiveParents(Builder $query): Builder
    {
        return $query
            ->whereNull('parent_id')
            ->active();
    }

    /**
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeMain(Builder $query): Builder
    {
        return $query->where('is_main', true);
    }

    /**
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
