<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Product\StoreProductAction;
use App\Actions\Admin\Product\UpdateProductAction;
use App\Constants\AdminView;
use App\Enums\CategoryType;
use App\Enums\MediaCollection;
use App\Enums\ProductStatus;
use App\Enums\VendorStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use App\Services\LocalFileUploader;
use App\Support\BadgeHelper;
use App\Traits\HasDatatable;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreProductAction $storeProductAction,
        private readonly UpdateProductAction $updateProductAction,
        private readonly LocalFileUploader $fileUploader,
    ) {}

    public function index()
    {
        $title = 'محصولات';

        return view(
            AdminView::PRODUCT_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Product::query()
                ->select([
                    'id',
                    'name',
                    'slug',
                    'vendor_id',
                    'category_id',
                    'price',
                    'stock',
                    'status',
                ])
                ->with([
                    'vendor:id,store_name',
                    'category:id,name,slug',
                ]),
            actionsView: 'admin.pages.products.partials._actions',
            extraColumns: [
                'vendor.store_name' => function ($row) {
                    if (!$row->vendor) {
                        return '-';
                    }

                    return sprintf(
                        '<a href="%s">%s</a>',
                        route('panel.vendor.edit', $row->vendor->id),
                        e($row->vendor->store_name)
                    );
                },

                'category.name' => function ($row) {
                    if (!$row->category) {
                        return '-';
                    }

                    return sprintf(
                        '<a href="%s">%s</a>',
                        route('panel.category.edit', $row->category->slug),
                        e($row->category->name)
                    );
                },

                'price' => function ($row) {
                    return number_format($row->price) . ' تومان';
                },

                'status' => fn ($row) => BadgeHelper::button($row->status),
            ],
        );
    }

    public function create()
    {
        $title = 'ایجاد محصول';

        $vendors = Vendor::query()
            ->approved()
            ->orderBy('store_name')
            ->get(['id', 'store_name']);

        $categories = Category::query()
            ->active()
            ->ofType(CategoryType::Product)
            ->orderBy('name')
            ->get(['id', 'name']);

        $statuses = ProductStatus::options();

        return view(
            AdminView::PRODUCT_CREATE,
            compact(
                'title',
                'vendors',
                'categories',
                'statuses',
            )
        );
    }

    public function store(StoreRequest $request)
    {
        $this->storeProductAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE.'product.index')
            ->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    public function edit(Product $product)
    {
        $title = 'ویرایش محصول';

        $vendors = Vendor::query()
            ->where('status', VendorStatus::APPROVED)
            ->orderBy('store_name')
            ->get(['id', 'store_name']);

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $statuses = ProductStatus::options();

        $product->load('image');

        $imageUrl = null;

        if ($product->image) {
            $imageUrl = $this->fileUploader->url(
                path: $product->image->file_path,
                disk: $product->image->disk,
            );
        }

        return view(
            AdminView::PRODUCT_EDIT,
            compact(
                'title',
                'product',
                'vendors',
                'categories',
                'statuses',
                'imageUrl',
            )
        );
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $this->updateProductAction->execute(
            product: $product,
            data: $request->validated(),
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE.'product.index')
            ->with('success', 'محصول با موفقیت ویرایش شد.');
    }

}
