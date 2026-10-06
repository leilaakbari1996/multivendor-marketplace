<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

final class ApiResponse
{
    public static function success
    (string $message,
     array $data = [],
     int $status = 200
    ): JsonResponse
    {
        return response()
            ->json([
                'message' => $message
                ] + $data,
                $status)
            ;
    }

    public static function error(
        string $message,
        array $errors = [],
        int $status = 422
    ): JsonResponse
    {
        $payload = ['message' => $message];

        if ($errors !== []) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
