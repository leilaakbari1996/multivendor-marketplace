<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Queries\CategoryQuery;
use App\Queries\ProductQuery;
use Illuminate\Contracts\View\View;
use App\Http\Requests\Client\Product\ProductFilterRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductQuery $productQuery,
        private readonly CategoryQuery $categoryQuery,
    ) {}

    public function index(ProductFilterRequest $request): View|JsonResponse
    {
        $products = $this->productQuery->paginate(
            filters: $request->validated(),
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'total' => $products->total(),
                'grid_html' => view(
                    'client.partials.product.grid',
                    compact('products')
                )->render(),
                'pagination_html' => $products->hasPages()
                    ? view(
                        'components.client.pagination',
                        ['paginator' => $products->withQueryString()]
                    )->render()
                    : '',
            ]);
        }

        $categories = $this->categoryQuery->get();

        return view(
            'client.pages.products.index',
            compact('products', 'categories')
        );
    }

    public function show(Product $product)
    {
        return view(
            'client.pages.products.show',
            compact('product')
        );
    }
}

