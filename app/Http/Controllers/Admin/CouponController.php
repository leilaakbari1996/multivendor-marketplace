<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Coupon\DeleteCouponAction;
use App\Actions\Admin\Coupon\StoreCouponAction;
use App\Actions\Admin\Coupon\UpdateCouponAction;
use App\Constants\AdminView;
use App\Datatables\Admin\CouponDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\StoreRequest;
use App\Http\Requests\Admin\Coupon\UpdateRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Coupon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CouponController extends Controller
{
    public function __construct(
        private readonly StoreCouponAction $storeCouponAction,
        private readonly UpdateCouponAction $updateCouponAction,
        private readonly DeleteCouponAction $deleteCouponAction,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Coupon::class);

        return view(AdminView::PREFIX . 'coupons.index', [
            'title' => __('coupon.title'),
        ]);
    }

    public function data(CouponDatatable $datatable): JsonResponse
    {
        $this->authorize('viewAny', Coupon::class);

        return $datatable->toJson();
    }

    public function create(): View
    {
        $this->authorize('create', Coupon::class);

        return view(AdminView::PREFIX . 'coupons.create', [
            'title' => __('coupon.create'),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Coupon::class);

        $this->storeCouponAction->execute($request->validated());

        return to_route(AdminView::PREFIX_ROUTE . 'coupon.index')
            ->with('success', __('coupon.created'));
    }

    public function edit(Coupon $coupon): View
    {
        $this->authorize('update', $coupon);

        return view(AdminView::PREFIX . 'coupons.edit', [
            'title' => __('coupon.edit'),
            'coupon' => $coupon,
        ]);
    }

    public function update(
        UpdateRequest $request,
        Coupon $coupon,
    ): RedirectResponse {
        $this->authorize('update', $coupon);

        $this->updateCouponAction->execute(
            coupon: $coupon,
            data: $request->validated(),
        );

        return to_route(AdminView::PREFIX_ROUTE . 'coupon.index')
            ->with('success', __('coupon.updated'));
    }

    public function destroy(Coupon $coupon): JsonResponse
    {
        $this->authorize('delete', $coupon);

        $this->deleteCouponAction->execute($coupon);

        return ApiResponse::success(__('coupon.deleted'));
    }
}
