<?php

declare(strict_types=1);

namespace App\Datatables\Admin;

use App\Models\Category;
use App\Support\BadgeHelper;
use App\Traits\HasDatatable;
use Illuminate\Http\JsonResponse;

class CategoryDatatable
{
    use HasDatatable;

    public function toJson(): JsonResponse
    {
        return $this->renderDatatable(
            query: Category::query()
                ->select([
                    'id',
                    'name',
                    'slug',
                    'parent_id',
                    'type',
                    'is_active',
                    'is_main',
                ])
                ->withCount(['products', 'faqs'])
                ->with('parent:id,name,slug')
                ->when(
                    request('type'),
                    fn ($query, $type) => $query->where('type', $type),
                ),
            actionsView: 'admin.pages.categories.partials._actions',
            extraColumns: [
                'type' => fn (Category $row) => e($row->type->label()),

                'is_active' => fn (Category $row) => BadgeHelper::booleanButton(
                    value: (bool) $row->is_active,
                    trueLabel: __('common.active'),
                    falseLabel: __('common.inactive'),
                ),

                'is_main' => fn (Category $row) => BadgeHelper::booleanButton(
                    value: (bool) $row->is_main,
                    trueLabel: __('category.main'),
                    falseLabel: __('category.regular'),
                ),

                'parent.name' => fn (Category $row) => $row->parent
                    ? sprintf(
                        '<a href="%s">%s</a>',
                        route('panel.category.edit', $row->parent),
                        e($row->parent->name),
                    )
                    : '-',
            ],
        );
    }
}
