<?php

namespace App\Models;

use App\Enums\MediaCollection;
use App\Services\LocalFileUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'collection',
        'disk',
        'file_name',
        'file_path',
        'mime_type',
        'size',
    ];

    protected function casts(): array
    {
        return [
            'collection' => MediaCollection::class,
        ];
    }

    //region Morphs
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
    //endregion

    //region Attribute
    public function getUrlAttribute(): string
    {
        return app(LocalFileUploader::class)->url(
            $this->file_path,
            '',
            $this->disk
        );
    }
    //endregion
}
