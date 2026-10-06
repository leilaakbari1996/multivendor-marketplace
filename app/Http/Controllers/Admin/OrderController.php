<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminView;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Support\BadgeHelper;
use App\Support\DateHelper;
use App\Traits\HasDatatable;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    use HasDatatable;

    public function index(): View
    {
        return view(
            AdminView::ORDER_INDEX,
            [
                'title' => 'سفارش‌ها',
            ]
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Order::query()
                ->select([
                    'id',
                    'user_id',
                    'coupon_id',
                    'order_number',
                    'total',
                    'status',
                    'created_at',
                ])
                ->with('user'),

            actionsView: 'admin.pages.orders.partials._actions',

            extraColumns: [
                'user' => fn ($row) => $row->user
                    ? sprintf(
                        '<a href="%s">%s</a>',
                        route('panel.user.edit', $row->user->id),
                        e($row->user->user_name ?? $row->user->mobile)
                    )
                    : '-',

                'coupon' => fn ($row) => BadgeHelper::booleanButton(
                    value: (bool) $row->coupon_id,
                    trueLabel: 'دارد',
                    falseLabel: 'ندارد',
                ),

                'created_at' => fn ($row) => DateHelper::toJalali(
                    $row->created_at
                ),

                'total' => fn ($row) => number_format($row->total) . ' تومان',

                'status' => fn ($row) => BadgeHelper::button($row->status),
            ],
        );
    }

    public function show(Order $order): View
    {
        $order->load([
            'user',
            'items.product',
            'items.vendor',
            'coupon',
        ]);

        $subtotal = $order->items->sum(
            fn ($item) => $item->price * $item->quantity
        );

        $itemDiscountAmount = $order->items->sum(
            fn ($item) => $item->discount_price * $item->quantity
        );

        $couponDiscountAmount = 0;

        if (
            $order->coupon
            && $order->coupon->is_active
            && (!$order->coupon->starts_at || now()->greaterThanOrEqualTo($order->coupon->starts_at))
            && (!$order->coupon->expires_at || now()->lessThanOrEqualTo($order->coupon->expires_at))
            && (!$order->coupon->min_order_amount || $subtotal >= $order->coupon->min_order_amount)
        ) {
            $coupon = $order->coupon;

            if ($coupon->type->isPercentage()) {
                $couponDiscountAmount = $subtotal * ($coupon->value / 100);
            } else {
                $couponDiscountAmount = $coupon->value;
            }

            if ($coupon->max_discount_amount !== null) {
                $couponDiscountAmount = min(
                    $couponDiscountAmount,
                    $coupon->max_discount_amount
                );
            }

            $couponDiscountAmount = min(
                $couponDiscountAmount,
                $subtotal - $itemDiscountAmount
            );


        }

        $discountAmount = $itemDiscountAmount + $couponDiscountAmount;

        $itemsTotal = $subtotal - $discountAmount;

        return view(
            AdminView::ORDER_SHOW,
            [
                'title' => 'جزئیات سفارش',
                'order' => $order,
                'subtotal' => $subtotal,
                'discountAmount' => $discountAmount,
                'itemsTotal' => $itemsTotal,
                'couponDiscountAmount' => $couponDiscountAmount,
                'itemDiscountAmount' => $itemDiscountAmount
            ]
        );
    }
}
