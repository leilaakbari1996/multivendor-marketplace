<?php

declare(strict_types=1);

namespace App\Datatables\Admin;

use App\Models\Faq;
use App\Support\BadgeHelper;
use Illuminate\Database\Eloquent\Builder;

final class FaqDatatable extends BaseDatatable
{
    protected function query(): Builder
    {
        return Faq::query()
            ->select([
                'id',
                'question',
                'icon',
                'sort_order',
                'is_active',
            ])
            ->with('categories:id,name');
    }

    protected function actionsView(): string
    {
        return 'admin.pages.faqs.partials._actions';
    }

    protected function columns(): array
    {
        return [
            'categories' => fn (Faq $row): string => e(
                $row->categories->pluck('name')->implode(', ') ?: '-',
            ),

            'is_active' => fn (Faq $row): string => BadgeHelper::booleanButton(
                value: (bool) $row->is_active,
                trueLabel: __('common.active'),
                falseLabel: __('common.inactive'),
            ),
        ];
    }

    protected function rawColumns(): array
    {
        return ['is_active'];
    }
}
