<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
    ];

    //region Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    //endregion

    //region Scopes
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithItems(Builder $query): Builder
    {
        return $query->with('items.product');
    }
    //endregion

    //region Totals
    public function totalQuantity(): int
    {
        return (int) $this->items->sum('quantity');
    }

    public function totalPrice(): int
    {
        return (int) $this->items->sum(fn (CartItem $item) => $item->totalPrice());
    }

    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }
    //endregion
}
