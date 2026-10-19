<?php

declare(strict_types=1);

namespace App\Exceptions\Media;

use Throwable;

final class InvalidImageException extends MediaException
{
    public static function fromPrevious(Throwable $previous): self
    {
        // Keep the original exception so the real cause is never lost.
        return new self('The uploaded file could not be decoded as an image.', 0, $previous);
    }

    protected function translationKey(): string
    {
        return 'exceptions.media.invalid_image';
    }

    protected function statusCode(): int
    {
        return 422;
    }
}
