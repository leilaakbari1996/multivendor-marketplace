<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:newsletter_subscribers,email'],
        ]);

        NewsletterSubscriber::create($validated);

        return response()->json([
            'message' => 'عضویت شما در خبرنامه با موفقیت انجام شد.',
        ]);
    }
}

