<?php

namespace App\Services;

use App\Enums\MediaCollection;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class LocalFileUploader
{
    protected string $disk;

    protected ImageManager $imageManager;

    public function __construct(?string $disk = null)
    {
        $this->disk = $disk ?? config('filesystems.upload_disk', 'public');

        $this->imageManager = ImageManager::usingDriver(
            Driver::class
        );
    }

    public function upload(
        UploadedFile $file,
        string $directory,
        bool $dated = true
    ): string {
        $directory = $this->resolveDirectory($directory, $dated);

        return $file->storeAs(
            $directory,
            $this->filename($file->getClientOriginalExtension()),
            $this->disk
        );
    }


    public function uploadImage(
        UploadedFile $file,
        string $directory,
        ?int $width = null,
        ?int $height = null,
        bool $dated = true
    ): string {
        $directory = $this->resolveDirectory($directory, $dated);

        $filename = $this->filename('webp');
        $path = $directory . '/' . $filename;

        $image = $this->imageManager
            ->decodeSplFileInfo($file);

        if ($width !== null && $height !== null) {
            $image = $image->cover($width, $height);
        }

        $image = $image->encode(
            new WebpEncoder(quality: 85)
        );

        Storage::disk($this->disk)->put(
            $path,
            (string) $image
        );

        return $path;
    }

    public function delete(
        ?string $path,
        ?string $disk = null
    ): void
    {
        if (!$path) {
            return;
        }

        Storage::disk($disk ?? $this->disk)->delete($path);
    }

    public function url(
        ?string $path,
        string $default = '',
        ?string $disk = null
    ): string {
        if (!$path) {
            return $default;
        }

        return Storage::disk($disk ?? $this->disk)->url($path);
    }

    protected function filename(string $extension): string
    {
        return Str::uuid() . '.' . $extension;
    }

    protected function resolveDirectory(
        string $directory,
        bool $dated
    ): string {
        $directory = rtrim($directory, '/');

        return $dated
            ? $directory . '/' . now()->format('Y/m')
            : $directory;
    }

    public function getImageUrl(
        ?int $mediaId,
        ?MediaCollection $collection = MediaCollection::IMAGE,
    ): ?string {
        if (!$mediaId) {
            return null;
        }

        $query = Media::query()
            ->whereKey($mediaId);

        if ($collection) {
            $query->where('collection', $collection->value);
        }

        $media = $query->first();

        return $media
            ? $this->url(
                path: $media->file_path,
                disk: $media->disk,
            )
            : null;
    }


}
