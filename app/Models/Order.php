<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'discount_amount',
        'shipping_amount',
        'total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'discount_amount' => 'integer',
            'shipping_amount' => 'integer',
            'total' => 'integer',
            'status' => OrderStatus::class,
        ];
    }

    //region Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    //endregion

    //region Scopes

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::PENDING);
    }

    public function scopeProcessing(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::PROCESSING);
    }

    public function scopeShipped(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::SHIPPED);
    }

    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::DELIVERED);
    }

    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::CANCELLED);
    }

    public function scopeRefunded(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::REFUNDED);
    }
    public function scopePaid(Builder $query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::PROCESSING,
            OrderStatus::SHIPPED,
            OrderStatus::DELIVERED,
        ]);
    }

    //endregion

    //region Status Helpers

    public function isPending(): bool
    {
        return $this->status === OrderStatus::PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->status === OrderStatus::PROCESSING;
    }

    public function isShipped(): bool
    {
        return $this->status === OrderStatus::SHIPPED;
    }

    public function isDelivered(): bool
    {
        return $this->status === OrderStatus::DELIVERED;
    }

    public function isCancelled(): bool
    {
        return $this->status === OrderStatus::CANCELLED;
    }

    public function isRefunded(): bool
    {
        return $this->status === OrderStatus::REFUNDED;
    }

    //endregion


}
