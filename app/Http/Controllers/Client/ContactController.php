<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\Contact\StoreContactMessageAction;
use App\Constants\ClientView;
use App\Http\Requests\Client\Contact\StoreRequest;
use App\Http\Responses\ApiResponse;
use App\Queries\ContactQuery;
use Illuminate\Http\JsonResponse;

class ContactController
{
    public function __construct(
        private readonly ContactQuery $contactQuery,
    ) {
    }

    public function index()
    {
        return view(
            ClientView::PREFIX.'contact',
            $this->contactQuery->get()
        );
    }

    public function store(
        StoreRequest $request,
        StoreContactMessageAction $action
    ): JsonResponse {
        $action->execute($request->validated() + [
                'ip' => $request->ip(),
            ]);

        return ApiResponse::success(
            message: 'پیام شما با موفقیت ارسال شد. به‌زودی با شما در ارتباط خواهیم بود.'
        );
    }
}
