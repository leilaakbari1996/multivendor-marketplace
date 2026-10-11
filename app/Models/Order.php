<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id', // ← در fillable قبلی نبود
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

    /** سفارش‌های یک کاربر مشخص (مدل یا id) */
    public function scopeForUser(Builder $query, User|int $user): Builder
    {
        return $query->where('user_id', $user instanceof User ? $user->getKey() : $user);
    }

    /** فیلتر وضعیت؛ اگر null باشد هیچ فیلتری اعمال نمی‌شود (برای تب «همه») */
    public function scopeOfStatus(Builder $query, ?OrderStatus $status): Builder
    {
        return $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }

    /** جستجو با شماره سفارش */
    public function scopeByNumber(Builder $query, string $orderNumber): Builder
    {
        return $query->where('order_number', $orderNumber);
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

    public function statusAt(OrderStatus $status): ?Carbon
    {
        return $this->statusHistories->last(fn ($h) => $h->status === $status)?->created_at;
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

    /** برای نمایش دکمه «لغو سفارش» (قانون کسب‌وکار را در صورت نیاز تغییر بده) */
    public function canBeCancelled(): bool
    {
        return $this->isPending() || $this->isProcessing();
    }

    //endregion
}
