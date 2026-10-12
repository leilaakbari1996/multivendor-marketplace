<?php

namespace App\Models;

use App\Enums\VendorStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Builder;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'url',
        'bio',
        'national_code',
        'commission_rate',
        'status',
        'rejected_reason',
    ];

    protected function casts(): array
    {
        return [
            'commission_rate' => 'decimal:2',
            'status' => VendorStatus::class,
        ];
    }

    //region Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    //endregion

    //region Scopes

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', VendorStatus::APPROVED);
    }

    //endregion

    //region Helper method

    //endregion

    //region Helper method

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    //endregion
}
