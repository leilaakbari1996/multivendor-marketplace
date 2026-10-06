<?php

namespace App\Actions\Admin\Media;

use App\Enums\MediaCollection;
use App\Models\Media;
use App\Services\LocalFileUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class StoreMediaAction
{
    public function __construct(
        private readonly LocalFileUploader $fileUploader,
    ) {
    }

    public function execute(
        Model $model,
        UploadedFile $file,
        MediaCollection $collection,
        string $directory,
        bool $replaceExisting = false,
        ?int $width = 800,
        ?int $height = 800
    ): Media {
        if ($replaceExisting) {
            $existingMedia = $model->media()
                ->where('collection', $collection)
                ->get();

            foreach ($existingMedia as $oldMedia) {
                $this->fileUploader->delete($oldMedia->file_path);
                $oldMedia->delete();
            }
        }

        $path = $this->fileUploader->uploadImage(
            file: $file,
            directory: $directory,
            width: $height,
            height: $width,
        );

        return $model->media()->create([
            'collection' => $collection,
            'disk' => config('filesystems.upload_disk', 'public'),
            'file_name' => basename($path),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);
    }
}
