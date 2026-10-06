<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'product_name',
        'price',
        'discount_amount',
        'quantity',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'discount_amount' => 'integer',
            'quantity' => 'integer',
            'total' => 'integer',
        ];
    }

    //region Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
    //endregion
}
