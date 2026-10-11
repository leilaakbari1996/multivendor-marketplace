<?php

namespace App\Models;

use App\Enums\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'page'
    ];

    protected $casts = [
        'page' => Page::class
    ];

    //region Morphs

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    //endregion
}
