<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Category\DeleteCategoryAction;
use App\Actions\Admin\Category\StoreCategoryAction;
use App\Actions\Admin\Category\UpdateCategoryAction;
use App\Constants\AdminView;
use App\Datatables\Admin\CategoryDatatable;
use App\Enums\MediaCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Category;
use App\Services\LocalFileUploader;
use App\Traits\HasDatatable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreCategoryAction $storeCategoryAction,
        private readonly UpdateCategoryAction $updateCategoryAction,
        private readonly DeleteCategoryAction $deleteCategoryAction,
        private readonly LocalFileUploader $fileUploader,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Category::class);

        return view(AdminView::PREFIX . 'categories.index', [
            'title' => __('category.title'),
        ]);
    }

    public function data(CategoryDatatable $datatable): JsonResponse
    {
        $this->authorize('viewAny', Category::class);

        return $datatable->toJson();
    }

    public function create(): View
    {
        $this->authorize('create', Category::class);

        $categories = Category::query()
            ->activeParents()
            ->get(['id', 'name']);

        return view(AdminView::PREFIX . 'categories.create', [
            'title' => __('category.create'),
            'categories' => $categories,
        ]);
    }

    public function store(
        StoreCategoryRequest $request
    ): RedirectResponse
    {
        $this->authorize('create', Category::class);

        $this->storeCategoryAction->execute(
            $request->validated(),
        );

        return to_route(AdminView::PREFIX_ROUTE . 'category.index')
            ->with('success', __('category.created'));
    }

    public function edit(
        Category $category
    ): View
    {
        $this->authorize('update', $category);
        $categories = Category::query()
            ->activeParents()
            ->whereKeyNot($category->id)
            ->get(['id', 'name']);

        $category->load('media', 'tags');

        $image = $category->media
            ->firstWhere('collection', MediaCollection::IMAGE);

        $imageUrl = $image
            ? $this->fileUploader->url(
                path: $image->file_path,
                disk: $image->disk,
            )
            : null;

        return view(AdminView::PREFIX . 'categories.edit', [
            'title' => __('category.edit'),
            'category' => $category,
            'imageUrl' => $imageUrl,
            'categories' => $categories,
        ]);
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category,
    ): RedirectResponse {
        $this->authorize('update', $category);

        $this->updateCategoryAction->execute(
            $category,
            $request->validated(),
        );

        return to_route(AdminView::PREFIX_ROUTE . 'category.index')
            ->with('success', __('category.updated'));
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->authorize('delete', $category);

        $this->deleteCategoryAction->execute($category);

        return ApiResponse::success(__('category.deleted'));
    }
}
