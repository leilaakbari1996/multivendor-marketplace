<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'recipient_name',
        'recipient_mobile',
        'province_id',
        'county_id',
        'sector_id',
        'city_id',
        'address',
        'postal_code',
        'plaque',
        'unit',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'plaque' => 'integer',
        ];
    }

    //region Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //endregion

    //region Scopes

    public function scopeWhereKeyNot(
        Builder $query,
        int $id
    ): Builder {
        return $query->whereKeyNot($id);
    }
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

// آدرس پیش‌فرض اول، بقیه از جدید به قدیم
    public function scopeDefaultFirst(Builder $query): Builder
    {
        return $query->orderByDesc('is_default')->latest('id');
    }

//endregion
}
