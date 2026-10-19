<?php

declare(strict_types=1);

namespace App\Exceptions\Media;

final class FileStorageException extends MediaException
{
    private function __construct(
        string $message,
        private readonly string $path,
        private readonly string $disk,
    ) {
        parent::__construct($message);
    }

    public static function failedToStore(string $path, string $disk): self
    {
        return new self(
            "Could not store file at [{$path}] on disk [{$disk}].",
            $path,
            $disk,
        );
    }

    protected function translationKey(): string
    {
        return 'exceptions.media.storage_failed';
    }

    protected function statusCode(): int
    {
        return 500;
    }

    public function context(): array
    {
        return ['path' => $this->path, 'disk' => $this->disk];
    }
}
