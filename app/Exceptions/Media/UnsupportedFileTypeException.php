<?php

declare(strict_types=1);

namespace App\Exceptions\Media;

use InvalidArgumentException;

final class UnsupportedFileTypeException extends InvalidArgumentException
{
    public static function forExtension(string $extension): self
    {
        return new self("File type [{$extension}] is not allowed.");
    }
}
