<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Coupon\DeleteCouponAction;
use App\Actions\Admin\Coupon\StoreCouponAction;
use App\Actions\Admin\Coupon\UpdateCouponAction;
use App\Constants\AdminView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\StoreRequest;
use App\Http\Requests\Admin\Coupon\UpdateRequest;
use App\Models\Coupon;
use App\Support\BadgeHelper;
use App\Support\DateHelper;
use App\Traits\HasDatatable;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

class CouponController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreCouponAction $storeCouponAction,
        private readonly UpdateCouponAction $updateCouponAction,
        private readonly DeleteCouponAction $deleteCouponAction,
    ) {
    }

    public function index(): View
    {
        $title = 'کدهای تخفیف';

        return view(
            AdminView::COUPON_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Coupon::query()
                ->select([
                    'id',
                    'code',
                    'type',
                    'value',
                    'usage_limit',
                    'used_count',
                    'starts_at',
                    'expires_at',
                    'is_active',
                ]),
            actionsView: 'admin.pages.coupons.partials._actions',
            extraColumns: [
                'type' => fn ($row) => $row->type->label($row->value),

                'usage' => fn ($row) => $row->usage_limit
                    ? sprintf(
                        '%s / %s',
                        number_format($row->used_count),
                        number_format($row->usage_limit)
                    )
                    : sprintf(
                        '%s / نامحدود',
                        number_format($row->used_count)
                    ),

                'starts_at' => fn ($row) => DateHelper::toJalali(
                    $row->starts_at
                ),

                'expires_at' => fn ($row) => DateHelper::toJalali(
                    $row->expires_at
                ),

                'is_active' => fn ($row) => BadgeHelper::booleanButton(
                    value: (bool) $row->is_active,
                    trueLabel: 'فعال',
                    falseLabel: 'غیرفعال',
                ),
            ],
        );
    }

    public function create(): View
    {
        $title = 'ایجاد کد تخفیف';

        return view(
            AdminView::COUPON_CREATE,
            compact('title')
        );
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->storeCouponAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'coupon.index')
            ->with('success', 'کد تخفیف با موفقیت ایجاد شد.');
    }

    public function edit(Coupon $coupon): View
    {
        $title = 'ویرایش کد تخفیف';

        return view(
            AdminView::COUPON_EDIT,
            compact(
                'title',
                'coupon'
            )
        );
    }

    public function update(
        UpdateRequest $request,
        Coupon $coupon
    ): RedirectResponse {
        $this->updateCouponAction->execute(
            $coupon,
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'coupon.index')
            ->with('success', 'کد تخفیف با موفقیت ویرایش شد.');
    }

    public function destroy(Coupon $coupon)
    {
        $this->deleteCouponAction->execute($coupon);

        return response()->json([
            'message' => 'کد تخفیف با موفقیت حذف شد.',
        ]);
    }
}
