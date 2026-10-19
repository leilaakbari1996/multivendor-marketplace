<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MediaCollection;
use App\Exceptions\Media\FileStorageException;
use App\Exceptions\Media\InvalidImageException;
use App\Exceptions\Media\UnsupportedFileTypeException;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Exceptions\DecoderException;
use Intervention\Image\ImageManager;

class LocalFileUploader
{
    /**
     * Extensions accepted by upload() for non-image files.
     * Adjust this list to what your project really needs.
     */
    private const ALLOWED_FILE_EXTENSIONS = ['pdf', 'txt', 'csv', 'zip', 'docx', 'xlsx'];

    /** Images wider than this are scaled down (aspect ratio is kept). */
    private const MAX_IMAGE_WIDTH = 1920;

    private const WEBP_QUALITY = 85;

    protected string $disk;

    protected ImageManager $imageManager;

    public function __construct(?string $disk = null)
    {
        $this->disk = $disk ?? config('filesystems.upload_disk', 'public');

        $this->imageManager = ImageManager::usingDriver(Driver::class);
    }

    public function disk(): string
    {
        return $this->disk;
    }

    /**
     * Store a non-image file.
     *
     * @throws UnsupportedFileTypeException when the type is not whitelisted (programmer error)
     * @throws FileStorageException when writing to disk fails
     */
    public function upload(
        UploadedFile $file,
        string $directory,
        bool $dated = true
    ): string {
        // extension() is guessed from the file content, not from the
        // client-supplied name, so "shell.php" cannot slip through.
        $extension = strtolower((string) $file->extension());

        if (! in_array($extension, self::ALLOWED_FILE_EXTENSIONS, true)) {
            throw UnsupportedFileTypeException::forExtension($extension);
        }

        $directory = $this->resolveDirectory($directory, $dated);

        $path = $file->storeAs($directory, $this->filename($extension), $this->disk);

        if ($path === false) {
            throw FileStorageException::failedToStore($directory, $this->disk);
        }

        return $path;
    }

    /**
     * Decode, resize and re-encode an image as webp.
     * Re-encoding strips anything hidden inside the original file.
     *
     * @throws InvalidImageException when the file is not a readable image
     * @throws FileStorageException when writing to disk fails
     */
    public function uploadImage(
        UploadedFile $file,
        string $directory,
        ?int $width = null,
        ?int $height = null,
        bool $dated = true
    ): string {
        $directory = $this->resolveDirectory($directory, $dated);
        $path = $directory.'/'.$this->filename('webp');

        try {
            $image = $this->imageManager->decodeSplFileInfo($file);
        } catch (DecoderException $e) {
            throw InvalidImageException::fromPrevious($e);
        }

        if ($width !== null && $height !== null) {
            // Fixed size requested: crop to fill it.
            $image = $image->cover($width, $height);
        } else {
            // No fixed size: keep the aspect ratio, only shrink, never enlarge.
            $image = $image->scaleDown(width: self::MAX_IMAGE_WIDTH);
        }

        $encoded = $image->encode(new WebpEncoder(quality: self::WEBP_QUALITY));

        // put() returns false on failure instead of throwing.
        if (! Storage::disk($this->disk)->put($path, (string) $encoded)) {
            throw FileStorageException::failedToStore($path, $this->disk);
        }

        return $path;
    }

    /**
     * Delete a file. A failure here must not break the user's operation,
     * so it is logged instead of thrown.
     */
    public function delete(?string $path, ?string $disk = null): void
    {
        if (! $path) {
            return;
        }

        $disk ??= $this->disk;

        if (! Storage::disk($disk)->delete($path)) {
            Log::warning('Could not delete file from disk.', [
                'path' => $path,
                'disk' => $disk,
            ]);
        }
    }

    public function url(?string $path, string $default = '', ?string $disk = null): string
    {
        if (! $path) {
            return $default;
        }

        return Storage::disk($disk ?? $this->disk)->url($path);
    }

    // Consider moving this to a "url" accessor on the Media model.
    public function getImageUrl(
        ?int $mediaId,
        ?MediaCollection $collection = MediaCollection::IMAGE,
    ): ?string {
        if (! $mediaId) {
            return null;
        }

        $query = Media::query()->whereKey($mediaId);

        if ($collection) {
            $query->where('collection', $collection->value);
        }

        $media = $query->first();

        return $media
            ? $this->url(path: $media->file_path, disk: $media->disk)
            : null;
    }

    protected function filename(string $extension): string
    {
        return Str::uuid()->toString().'.'.$extension;
    }

    protected function resolveDirectory(string $directory, bool $dated): string
    {
        $directory = rtrim($directory, '/');

        return $dated
            ? $directory.'/'.now()->format('Y/m')
            : $directory;
    }
}
