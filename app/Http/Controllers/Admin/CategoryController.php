<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Category\DeleteCategoryAction;
use App\Actions\Admin\Category\StoreCategoryAction;
use App\Actions\Admin\Category\UpdateCategoryAction;
use App\Constants\AdminView;
use App\Enums\MediaCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Models\Category;
use App\Services\LocalFileUploader;
use App\Support\BadgeHelper;
use App\Traits\HasDatatable;


class CategoryController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreCategoryAction $storeCategoryAction,
        private readonly UpdateCategoryAction $updateCategoryAction,
        private readonly DeleteCategoryAction $deleteCategoryAction,
        private readonly LocalFileUploader $fileUploader,
    ) {
    }

    public function index()
    {
        $title = 'دسته‌بندی‌ها';

        return view(
            AdminView::CATEGORY_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Category::query()
                ->select([
                    'id',
                    'name',
                    'slug',
                    'parent_id',
                    'type',        // اضافه شد
                    'is_active',
                    'is_main',     // برای ستون is_main لازم است
                ])
                ->withCount(['products', 'faqs'])
                ->with('parent:id,name,slug')
                ->when(request('type'), fn ($q, $type) => $q->where('type', $type)),   // فیلتر اختیاری
            actionsView: 'admin.pages.categories.partials._actions',
            extraColumns: [
                'type' => fn ($row) => e($row->type->label()),
                'is_active' => fn ($row) => BadgeHelper::booleanButton(
                    value: (bool) $row->is_active,
                    trueLabel: 'فعال',
                    falseLabel: 'غیرفعال',
                ),
                'is_main' => fn ($row) => BadgeHelper::booleanButton(
                    value: (bool) $row->is_main,
                    trueLabel: 'اصلی',
                    falseLabel: 'عادی',
                ),
                'parent.name' => function ($row) {
                    if (! $row->parent) {
                        return '-';
                    }

                    return sprintf(
                        '<a href="%s">%s</a>',
                        route('panel.category.edit', $row->parent),
                        e($row->parent->name)
                    );
                },
            ],
        );
    }

    public function create()
    {
        $title = 'دسته‌بندی‌ها';

        $categories = Category::query()
            ->activeParents()
            ->get(['id', 'name']);

        return view(AdminView::CATEGORY_CREATE,compact(
            'title',
            'categories'
        ));
    }

    public function store(StoreRequest $request)
    {
        $this->storeCategoryAction->execute(
            $request->validated()
        );

        return redirect()
            ->route('panel.category.index')
            ->with('success', 'دسته بندی با موفقیت ایجاد شد.');
    }

    public function edit(Category $category)
    {
        $categories = Category::query()
            ->activeParents()
            ->whereKeyNot($category->id)
            ->get(['id', 'name']);

        $title = 'ویرایش دسته بندی';
        $category->load('media', 'tags');
        $imageUrl = null;


        if (!is_null($category->media))
        {
            $image = $category->media
                ->where('collection', MediaCollection::IMAGE)
                ->first();

            $imageUrl = $image
                ? $this->fileUploader->url(
                    path: $image->file_path,
                    disk: $image->disk,
                )
                : null;
        }

        return view(AdminView::CATEGORY_EDIT,compact('title','category','imageUrl','categories'));
    }

    public function update(StoreRequest $request, Category $category)
    {
        $this->updateCategoryAction->execute(
            $category,
            $request->validated()
        );

        return redirect()
            ->route('panel.category.index')
            ->with('success', 'دسته بندی با موفقیت ویرایش شد.');
    }

    public function destroy(Category $category)
    {
        $this->deleteCategoryAction->execute($category);

        return response()->json([
            'message' => 'دسته بندی با موفقیت حذف شد.',
        ]);
    }
}
