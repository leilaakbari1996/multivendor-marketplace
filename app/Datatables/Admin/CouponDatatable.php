<?php

declare(strict_types=1);

namespace App\Datatables\Admin;

use App\Models\Coupon;
use App\Support\BadgeHelper;
use App\Support\DateHelper;
use Illuminate\Database\Eloquent\Builder;

final class CouponDatatable extends BaseDatatable
{
    protected function query(): Builder
    {
        return Coupon::query()->select([
            'id',
            'code',
            'type',
            'value',
            'usage_limit',
            'used_count',
            'starts_at',
            'expires_at',
            'is_active',
        ]);
    }

    protected function actionsView(): string
    {
        return 'admin.pages.coupons.partials._actions';
    }

    protected function columns(): array
    {
        return [
            'type' => fn (Coupon $row): string => $row->type->label(
                $row->value,
            ),

            'usage' => fn (Coupon $row): string => $row->usage_limit
                ? sprintf(
                    '%s / %s',
                    number_format($row->used_count),
                    number_format($row->usage_limit),
                )
                : sprintf(
                    '%s / نامحدود',
                    number_format($row->used_count),
                ),

            'starts_at' => fn (Coupon $row): string => DateHelper::toJalali(
                $row->starts_at,
            ),

            'expires_at' => fn (Coupon $row): string => DateHelper::toJalali(
                $row->expires_at,
            ),

            'is_active' => fn (Coupon $row): string => BadgeHelper::booleanButton(
                value: (bool) $row->is_active,
                trueLabel: __('common.active'),
                falseLabel: __('common.inactive'),
            ),
        ];
    }

    protected function rawColumns(): array
    {
        // Only the status badge returns HTML.
        return ['is_active'];
    }
}
