<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\Address\DestroyAddressAction;
use App\Actions\Client\Address\MakeDefaultAddressAction;
use App\Actions\Client\Address\StoreAddressAction;
use App\Actions\Client\Address\UpdateAddressAction;
use App\Constants\ClientView;
use App\Http\Requests\Client\Address\StoreRequest;
use App\Http\Requests\Client\Address\UpdateRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Address;
use App\Queries\AddressQuery;
use App\Support\AuthUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class AddressController
{
    public function __construct(
        private readonly AddressQuery $addressQuery,
    ) {}

    public function index(): View
    {
        $userId = AuthUser::id();

        return view(
            ClientView::PREFIX . 'address.index',
            [
                'addresses' => $this->addressQuery->forUser($userId),
            ]
        );
    }

    public function store(
        StoreRequest $request,
        StoreAddressAction $action,
        AddressQuery $addressQuery
    ): JsonResponse {
        $action->execute(
            $request->validated()
        );

        return ApiResponse::success(
            message: 'آدرس با موفقیت ثبت شد.',
            data: [
                'addresses' => $addressQuery->forUser(
                    AuthUser::id()
                ),
            ],
            status: 201,
        );
    }

    public function update(
        UpdateRequest $request,
        Address $address,
        UpdateAddressAction $action,
        AddressQuery $addressQuery
    ): JsonResponse {

        $action->execute(
            address: $address,
            data: $request->validated(),
        );

        return ApiResponse::success(
            message: 'آدرس با موفقیت ویرایش شد.',
            data: [
                'addresses' => $addressQuery->forUser(
                    AuthUser::id()
                ),
            ],
        );
    }

    public function destroy(
        int $id,
        DestroyAddressAction $action,
        AddressQuery $addressQuery,
    ): JsonResponse {
        $address = Address::query()
            ->forUser( AuthUser::id())
            ->findOrFail($id);

        $action->execute($address);

        return ApiResponse::success(
            message: 'آدرس با موفقیت حذف شد.',
            data: [
                'addresses' => $addressQuery->forUser(
                   AuthUser::id()
                ),
            ],
        );
    }

    public function makeDefault(
        int $id,
        MakeDefaultAddressAction $action,
        AddressQuery $addressQuery,
    ): JsonResponse {
        $address = Address::query()
            ->forUser(AuthUser::id())
            ->findOrFail($id);

        $action->execute($address);

        return ApiResponse::success(
            message: 'آدرس پیش‌فرض با موفقیت تغییر کرد.',
            data: [
                'addresses' => $addressQuery->forUser(
                    AuthUser::id()
                ),
            ],
        );
    }

}

