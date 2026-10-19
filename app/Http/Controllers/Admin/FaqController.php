<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Faq\DeleteFaqAction;
use App\Actions\Admin\Faq\StoreFaqAction;
use App\Actions\Admin\Faq\UpdateFaqAction;
use App\Constants\AdminView;
use App\Datatables\Admin\FaqDatatable;
use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\StoreFaqRequest;
use App\Http\Requests\Admin\Faq\UpdateFaqRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Category;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class FaqController extends Controller
{
    public function __construct(
        private readonly StoreFaqAction $storeFaqAction,
        private readonly UpdateFaqAction $updateFaqAction,
        private readonly DeleteFaqAction $deleteFaqAction,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Faq::class);

        return view(AdminView::PREFIX . 'faqs.index', [
            'title' => __('faq.title'),
        ]);
    }

    public function data(
        FaqDatatable $datatable
    ): JsonResponse
    {
        $this->authorize('viewAny', Faq::class);

        return $datatable->toJson();
    }

    public function create(): View
    {
        $this->authorize('create', Faq::class);

        return view(AdminView::PREFIX . 'faqs.create', [
            'title' => __('faq.create'),
            'categories' => $this->faqCategories(),
        ]);
    }

    public function store(
        StoreFaqRequest $request
    ): RedirectResponse
    {
        $this->authorize('create', Faq::class);

        $this->storeFaqAction->execute($request->validated());

        return to_route(AdminView::PREFIX_ROUTE . 'faq.index')
            ->with('success', __('faq.created'));
    }

    public function edit(Faq $faq): View
    {
        $this->authorize('update', $faq);

        return view(AdminView::PREFIX . 'faqs.edit', [
            'title' => __('faq.edit'),
            'faq' => $faq,
            'categories' => $this->faqCategories(),
            'selectedCategories' => $faq->categories()
                ->pluck('categories.id')
                ->all(),
        ]);
    }

    public function update(
        UpdateFaqRequest $request,
        Faq $faq,
    ): RedirectResponse {
        $this->authorize('update', $faq);

        $this->updateFaqAction->execute(
            faq: $faq,
            data: $request->validated(),
        );

        return to_route(AdminView::PREFIX_ROUTE . 'faq.index')
            ->with('success', __('faq.updated'));
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $this->authorize('delete', $faq);

        $this->deleteFaqAction->execute($faq);

        return ApiResponse::success(__('faq.deleted'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Category>
     */
    private function faqCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::query()
            ->active()
            ->ofType(CategoryType::Faq)
            ->orderBy('sort_order')
            ->get(['id', 'name']);
    }
}
