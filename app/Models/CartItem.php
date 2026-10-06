<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    //region Relationships
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    //endregion

    //region Price

    public function unitPrice(): int
    {
        $product = $this->product;

        if (! $product) {
            return 0;
        }

        // discount_price برابر 0 یا null یعنی تخفیف ندارد
        return (int) ($product->discount_price ?: $product->price);
    }

    public function totalPrice(): int
    {
        return $this->unitPrice() * $this->quantity;
    }

    //endregion

    //region Helpers

    public function hasDiscount(): bool
    {
        return (int) $this->product?->discount_price > 0;
    }

    public function isAvailable(): bool
    {
        return $this->product !== null
            && $this->product->stock >= $this->quantity;
    }

    //endregion

    //region Scopes

    public function scopeForCart($query, int $cartId)
    {
        return $query->where('cart_id', $cartId);
    }

    public function scopeForProduct($query, int $productId)
    {
        return $query->where('product_id', $productId);
    }

    //endregion
}
