<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Client\Like\LikeRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\Product;
use App\Support\AuthUser;
use Illuminate\Http\JsonResponse;

class LikeController
{

    public function toggle(LikeRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $userId = AuthUser::id();

        $modelClass = match ($validated['likeable_type']) {
            'product' => Product::class,
            'post' => Post::class,
        };

        $likeable = $modelClass::findOrFail(
            $validated['likeable_id']
        );

        $like = $likeable->likes()
            ->forUser($userId)
            ->first();

        if ($like) {
            $like->delete();

            return response()->json([
                'liked' => false,
                'message' => 'لایک حذف شد.',
            ]);
        }

        $likeable->likes()->create([
            'user_id' => $userId,
        ]);

        return response()->json([
            'liked' => true,
            'message' => 'لایک ثبت شد.',
        ]);
    }

}
