<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\Cart\DeleteCartAction;
use App\Actions\Client\Cart\StoreCartAction;
use App\Actions\Client\Cart\UpdateCartAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Cart\StoreRequest;
use App\Http\Requests\Client\Cart\UpdateRequest;
use App\Queries\CartQuery;
use App\Support\AuthUser;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(
        private readonly StoreCartAction $storeCartAction,
        private readonly UpdateCartAction $updateCartAction,
        private readonly DeleteCartAction $deleteCartAction,
        private readonly CartQuery $cartQuery,
    ) {}

    public function store(StoreRequest $request): JsonResponse
    {
        $this->storeCartAction->execute(
            productId: $request->integer('product_id'),
            quantity: $request->integer('quantity', 1),
        );

        return $this->respond('محصول با موفقیت به سبد خرید اضافه شد.');
    }

    public function update(UpdateRequest $request, int $productId): JsonResponse
    {
        $this->updateCartAction->execute(
            productId: $productId,
            quantity: $request->integer('quantity'),
        );

        return $this->respond('سبد خرید بروزرسانی شد.');
    }

    public function destroy(int $productId): JsonResponse
    {
        $this->deleteCartAction->execute($productId);

        return $this->respond('محصول از سبد حذف شد.');
    }

    private function respond(string $message): JsonResponse
    {
        $summary = $this->cartQuery->summary(AuthUser::id());

        return response()->json([
            'message' => $message,
            'cart' => [
                'count' => $summary['cartCount'],
                'total' => $summary['cartTotal'],
                'html'  => view('client.partials.cart.cart-body', $summary)->render(),
            ],
        ]);
    }
}
