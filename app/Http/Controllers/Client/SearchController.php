<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\Product\SuggestProductsAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * پیشنهاد زنده هنگام تایپ در کادر جستجو (GET /search/suggest?q=...)
     */
    public function suggest(Request $request, SuggestProductsAction $action): JsonResponse
    {
        $term = mb_substr(trim((string) $request->query('q')), 0, 50);

        // ورودی کوتاه: خطا نمی‌دهیم، فقط نتیجه خالی
        if (mb_strlen($term) < 2) {
            return response()->json(['products' => [], 'categories' => [], 'all_url' => null]);
        }

        return response()->json($action->execute($term) + [
                // لینک «مشاهده همه نتایج» به صفحه محصولات با فیلتر جستجو
                'all_url' => route('products.index', ['search' => $term]),
            ]);
    }
}
