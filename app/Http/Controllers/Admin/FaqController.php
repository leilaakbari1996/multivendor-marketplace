<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Faq\DeleteFaqAction;
use App\Actions\Admin\Faq\StoreFaqAction;
use App\Actions\Admin\Faq\UpdateFaqAction;
use App\Constants\AdminView;
use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\StoreRequest;
use App\Http\Requests\Admin\Faq\UpdateRequest;
use App\Models\Category;
use App\Models\Faq;
use App\Support\BadgeHelper;
use App\Traits\HasDatatable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class FaqController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreFaqAction $storeFaqAction,
        private readonly UpdateFaqAction $updateFaqAction,
        private readonly DeleteFaqAction $deleteFaqAction,
    ) {}

    public function index(): View
    {
        $title = 'سوالات متداول';

        return view(
            AdminView::FAQ_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Faq::query()
                ->select([
                    'id',
                    'question',
                    'icon',
                    'sort_order',
                    'is_active',
                ])
                ->with('categories:id,name'),
            actionsView: 'admin.pages.faqs.partials._actions',
            extraColumns: [
                'categories' => fn ($row) => e(
                    $row->categories->pluck('name')->implode('، ') ?: '-'
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
        $title = 'ایجاد سوال متداول';

        $categories = $this->faqCategories();

        return view(
            AdminView::FAQ_CREATE,
            compact('title', 'categories')
        );
    }

    public function store(
        StoreRequest $request
    ): RedirectResponse {
        $this->storeFaqAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'faq.index')
            ->with('success', 'سوال متداول با موفقیت ایجاد شد.');
    }

    public function edit(Faq $faq): View
    {
        $title = 'ویرایش سوال متداول';

        $categories = $this->faqCategories();

        $selectedCategories = $faq->categories()
            ->pluck('categories.id')
            ->all();

        return view(
            AdminView::FAQ_EDIT,
            compact('title', 'faq', 'categories', 'selectedCategories')
        );
    }

    public function update(
        UpdateRequest $request,
        Faq $faq
    ): RedirectResponse {
        $this->updateFaqAction->execute(
            faq: $faq,
            data: $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'faq.index')
            ->with('success', 'سوال متداول با موفقیت بروزرسانی شد.');
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $this->deleteFaqAction->execute($faq);

        return response()->json([
            'message' => 'سوال متداول با موفقیت حذف شد.',
        ]);
    }

    /**
     * دسته‌های فعال از نوع «سوالات متداول» برای فرم‌ها
     */
    private function faqCategories()
    {
        return Category::query()
            ->active()
            ->ofType(CategoryType::Faq)
            ->orderBy('sort_order')
            ->get(['id', 'name']);
    }
}
