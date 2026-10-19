<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

abstract class AppException extends RuntimeException
{
    /** Translation key of the message shown to the user. */
    abstract protected function translationKey(): string;

    /** HTTP status code: 4xx for user mistakes, 5xx for server failures. */
    abstract protected function statusCode(): int;

    /**
     * Extra data attached to the log entry (Laravel reads this automatically).
     *
     * @return array<string, mixed>
     */
    public function context(): array
    {
        return [];
    }

    public function render(Request $request): JsonResponse|RedirectResponse
    {
        // The technical message goes to the logs only; the user sees a translated one.
        $message = __($this->translationKey());

        if ($request->expectsJson()) {
            return ApiResponse::error($message, status: $this->statusCode());
        }

        return back()->withInput()->with('error', $message);
    }
}
