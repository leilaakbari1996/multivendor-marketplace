<?php

declare(strict_types=1);

namespace App\Datatables\Admin;

use App\Models\Banner;
use App\Support\BadgeHelper;
use Illuminate\Database\Eloquent\Builder;

final class BannerDatatable extends BaseDatatable
{
    protected function query(): Builder
    {
        return Banner::query()->select([
            'id',
            'title',
            'subtitle',
            'position',
            'sort_order',
            'is_active',
        ]);
    }

    protected function actionsView(): string
    {
        return 'admin.pages.banners.partials._actions';
    }

    protected function columns(): array
    {
        return [
            'position' => fn (Banner $row): string => $row->position->label(),
            'is_active' => fn (Banner $row): string => BadgeHelper::booleanButton(
                value: (bool) $row->is_active,
                trueLabel: __('common.active'),
                falseLabel: __('common.inactive'),
            ),
        ];
    }

    protected function rawColumns(): array
    {
        // Only the badge returns HTML; "position" is plain text and stays escaped.
        return ['is_active'];
    }
}
