<?php

namespace App\Models;

use App\Enums\MediaCollection;
use App\Enums\ProductStatus;
use App\Support\AuthUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use SoftDeletes,HasPersianSlug;

    protected $fillable = [
        'vendor_id',
//        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'discount_price',
        'stock',
        'weight',
        'status',
        'is_featured',
        'featured_from',
        'featured_until',
        'is_best_selling'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'discount_price' => 'integer',
            'stock' => 'integer',
            'weight' => 'integer',
            'status' => ProductStatus::class,
            'is_featured' => 'boolean',
            'is_best_selling' => 'boolean',
            'featured_from' => 'datetime',
            'featured_until' => 'datetime',
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
        return 'slug';
    }

    //region Morphs

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')
            ->where('collection', 'image');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('collection', MediaCollection::IMAGE);
    }

    public function gallery(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')
            ->where('collection', MediaCollection::GALLERY)
            ->orderBy('id');
    }
    //endregion

    //region Relationships

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    //endregion

    //region Scopes

    public function scopeLikedBy(Builder $query, int $userId): Builder
    {
        return $query->whereHas('likes', function (Builder $query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }
    public function scopeOrderBySoldQuantity(Builder $query): Builder
    {
        return $query->orderByDesc('sold_quantity');
    }
    public function scopeWithHomeRelations(Builder $query): Builder
    {
        return $query->with([
            'image',
        ])->when(
            AuthUser::check(),
            fn (Builder $query) => $query->with([
                'likes' => fn ($query) => $query->forUser(
                    AuthUser::id()
                ),
            ])
        );
    }

    public function scopePublishedFeatured(Builder $query): Builder
    {
        return $query
            ->published()
            ->featured()
            ->latest();
    }

    public function scopeBestSelling(Builder $query): Builder
    {
        return $query->where('is_best_selling', true);
    }
    public function scopePublished($query)
    {
        return $query
            ->where('status', ProductStatus::PUBLISHED)
            ->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query
            ->where('is_featured', true)
            ->where(function ($query) {
                $query
                    ->whereNull('featured_from')
                    ->orWhere('featured_from', '<=', now());
            })
            ->where(function ($query) {
                $query
                    ->whereNull('featured_until')
                    ->orWhere('featured_until', '>=', now());
            });
    }
    //endregion

    //region Attributes
    protected function hasDiscount(): Attribute
    {
        return Attribute::get(fn () =>
            $this->discount_price > 0 && $this->discount_price < $this->price
        );
    }
    protected function discountPercent(): Attribute
    {
        return Attribute::get(fn () => $this->has_discount
            ? (int) round((($this->price - $this->discount_price) / $this->price) * 100)
            : 0
        );
    }

    protected function finalPrice(): Attribute
    {
        return Attribute::get(fn () => $this->has_discount ? $this->discount_price : $this->price);
    }

    //endregion
}
