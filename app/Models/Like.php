<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;

class Like extends Model
{
    protected $fillable = [
        'user_id',
    ];

    //region Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //endregion

    //region Scopes
    public function scopeForUser(
        Builder $query,
        int $userId
    ): Builder {
        return $query->where('user_id', $userId);
    }
    //endregion


    //region Morphs
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
    //endregion
}
