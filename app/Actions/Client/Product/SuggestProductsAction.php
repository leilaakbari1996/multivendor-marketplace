<?php

namespace App\Actions\Client\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class SuggestProductsAction
{
    private const PRODUCT_LIMIT  = 6;
    private const CATEGORY_LIMIT = 3;
    private const MAX_WORDS      = 5;

    /**
     * @return array{products: array<int, array>, categories: array<int, array>}
     */
    public function execute(string $term): array
    {
        $term  = $this->normalize($term);
        $words = array_slice(preg_split('/\s+/u', $term, -1, PREG_SPLIT_NO_EMPTY), 0, self::MAX_WORDS);

        if ($words === []) {
            return ['products' => [], 'categories' => []];
        }

        // محصولاتی که اسمشان با عبارت شروع می‌شود، اول بیایند
        $products = Product::query()
            ->published()
            ->where(fn (Builder $q) => $this->matchAllWords($q, 'name', $words))
            ->orderByRaw('CASE WHEN name LIKE ? THEN 0 ELSE 1 END', [$this->escapeLike($term) . '%'])
            ->latest('id')
            ->with('media')
            ->limit(self::PRODUCT_LIMIT)
            ->get();

        $categories = Category::query()
            ->active()
            ->where(fn (Builder $q) => $this->matchAllWords($q, 'name', $words))
            ->orderBy('sort_order')
            ->limit(self::CATEGORY_LIMIT)
            ->get(['id', 'name', 'slug']);

        return [
            'products' => $products->map(function (Product $product) {
                $onSale = (int) $product->discount_price > 0;

                return [
                    'name'      => $product->name,
                    'url'       => route('products.show', $product->slug),
                    'image'     => $product->image?->url,
                    'price'     => $onSale ? (int) $product->discount_price : (int) $product->price,
                    'old_price' => $onSale ? (int) $product->price : null,
                ];
            })->all(),

            'categories' => $categories->map(fn (Category $category) => [
                'name' => $category->name,
                'url'  => route('products.index', ['category' => $category->slug]),
            ])->all(),
        ];
    }

    /** همه کلمات باید در ستون باشند (ترتیب مهم نیست): «سیب قرمز» = «قرمز سیب» */
    private function matchAllWords(Builder $query, string $column, array $words): Builder
    {
        foreach ($words as $word) {
            $variants = $this->variants($word);

            $query->where(function (Builder $q) use ($column, $variants) {
                foreach ($variants as $variant) {
                    $q->orWhere($column, 'like', '%' . $this->escapeLike($variant) . '%');
                }
            });
        }

        return $query;
    }

    /**
     * املاهای مختلف یک کلمه: دیتای قدیمی یا کپی‌شده ممکن است «ي/ك» عربی یا ارقام فارسی داشته باشد.
     *
     * @return array<int, string>
     */
    private function variants(string $word): array
    {
        $persianDigits = ['0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'];

        return array_values(array_unique([
            $word,
            strtr($word, ['ی' => 'ي', 'ک' => 'ك']),
            strtr($word, $persianDigits),
            strtr($word, ['ی' => 'ي', 'ک' => 'ك'] + $persianDigits),
        ]));
    }

    /** یکسان‌سازی ورودی کاربر: حروف عربی → فارسی، ارقام فارسی/عربی → انگلیسی */
    private function normalize(string $term): string
    {
        $term = strtr($term, [
            'ي' => 'ی', 'ك' => 'ک', 'ة' => 'ه',
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
            '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
            '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
        ]);

        return trim($term);
    }

    /** % و _ که کاربر تایپ کند، معنی ویژه LIKE نداشته باشند */
    private function escapeLike(string $value): string
    {
        return addcslashes($value, '%_\\');
    }
}
