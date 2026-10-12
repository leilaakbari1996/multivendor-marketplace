<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'icon',
        'sort_order',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];


    //region Morphs

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    //endregion

    //region Scopes
    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }

    //endregion
}
