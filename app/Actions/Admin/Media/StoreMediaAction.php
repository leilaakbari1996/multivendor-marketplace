<?php

declare(strict_types=1);

namespace App\Actions\Admin\Media;

use App\Contracts\HasMedia;
use App\Enums\MediaCollection;
use App\Models\Media;
use App\Services\LocalFileUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class StoreMediaAction
{
    public function __construct(
        private readonly LocalFileUploader $fileUploader,
    ) {}

    public function execute(
        HasMedia $model,
        UploadedFile $file,
        MediaCollection $collection,
        string $directory,
        bool $replaceExisting = false,
        ?int $width = null,
        ?int $height = null,
    ): Media {
        $oldMedia = $replaceExisting
            ? $model->media()->where('collection', $collection)->get()
            : collect();

        // 1. Store the new file first, so the old one stays intact if this fails.
        $path = $this->fileUploader->uploadImage(
            file: $file,
            directory: $directory,
            width: $width,
            height: $height,
        );

        $disk = $this->fileUploader->disk();

        // 2. Create the new record. If it fails, remove the uploaded file
        // so we do not leave an orphan on disk.
        try {
            $media = $model->media()->create([
                'collection' => $collection,
                'disk' => $disk,
                'file_name' => basename($path),
                'file_path' => $path,
                // The stored file is always webp, so record its real values.
                'mime_type' => 'image/webp',
                'size' => Storage::disk($disk)->size($path),
            ]);
        } catch (Throwable $e) {
            $this->fileUploader->delete($path);

            throw $e;
        }

        // 3. Remove the old media last. Each Media model deletes its own
        // file after the surrounding transaction commits.
        $oldMedia->each->delete();

        return $media;
    }
}
