<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MediaCollection;
use App\Services\LocalFileUploader;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
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

    protected static function booted(): void
    {
        // Whenever a media record is deleted, its file goes with it.
        static::deleted(function (self $media): void {
            $path = $media->file_path;
            $disk = $media->disk;

            // Remove the file only if the surrounding transaction commits.
            DB::afterCommit(
                fn () => app(LocalFileUploader::class)->delete($path, $disk)
            );
        });
    }

    protected function casts(): array
    {
        return [
            'collection' => MediaCollection::class,
            'size' => 'integer',
        ];
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Public URL of the file: $media->url
     */
    protected function url(): Attribute
    {
        return Attribute::get(
            fn (): string => Storage::disk($this->disk)->url($this->file_path)
        );
    }
}
