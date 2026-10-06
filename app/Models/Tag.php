<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;

class Tag extends Model
{
    use HasPersianSlug;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    //region Morphs
    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'taggable');
    }
    //endregion
}
