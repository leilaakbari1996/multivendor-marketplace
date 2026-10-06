<?php

namespace App\Queries;

use App\Constants\Client\ProductConstant;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductQuery
{
    private function query(): Builder
    {
        return Product::query()
            ->withHomeRelations();
    }

    public function bestSelling(int $perPage = 8): LengthAwarePaginator
    {
        return $this->query()
            ->where(function ($query) {
                $query
                    ->bestSelling()
                    ->orWhereHas('orderItems', function ($query) {
                        $query->whereHas('order', function ($query) {
                            $query->paid();
                        });
                    });
            })
            ->withSum([
                'orderItems as sold_quantity' => function ($query) {
                    $query->whereHas('order', function ($query) {
                        $query->paid();
                    });
                },
            ], 'quantity')
            ->orderBySoldQuantity()
            ->paginate($perPage);
    }

    public function featured(int $perPage = 8): LengthAwarePaginator
    {
        return $this->query()
            ->publishedFeatured()
            ->paginate($perPage);
    }


    public function paginate(
        array $filters = ProductConstant::DEFAULT_FILTERS,
        int $perPage = ProductConstant::PER_PAGE,
    ): LengthAwarePaginator {
        return $this->query()
            ->published()
            ->when(
                $filters['search'] ?? null,
                fn (Builder $query, string $search) => $query->where(
                    'name',
                    'like',
                    "%{$search}%"
                )
            )
            ->when(
                $filters['category'] ?? null,
                fn (Builder $query, int $categoryId) => $query->where(
                    'category_id',
                    $categoryId
                )
            )
            ->when(
                $filters['min_price'] ?? null,
                fn (Builder $query, int $minPrice) => $query->whereRaw(
                    'COALESCE(NULLIF(discount_price, 0), price) >= ?',
                    [$minPrice]
                )
            )
            ->when(
                $filters['is_best_selling'] ?? false,
                function (Builder $query) {
                    $query->where(function (Builder $query) {
                        $query
                            ->bestSelling()
                            ->orWhereHas('orderItems', function (Builder $query) {
                                $query->whereHas('order', function (Builder $query) {
                                    $query->paid();
                                });
                            });
                    });
                }
            )
            ->when(
                $filters['max_price'] ?? null,
                fn (Builder $query, int $maxPrice) => $query->whereRaw(
                    'COALESCE(NULLIF(discount_price, 0), price) <= ?',
                    [$maxPrice]
                )
            )
            ->when(
                $filters['in_stock'] ?? false,
                fn (Builder $query) => $query->where('stock', '>', 0)
            )
            ->when(
                $filters['on_sale'] ?? false,
                fn (Builder $query) => $query->whereNotNull('discount_price')
            )
            ->when(
                $filters['is_featured'] ?? false,
                fn (Builder $query) => $query->featured()
            )
            ->when(
                $filters['sort'] ?? null,
                function (Builder $query, string $sort) {
                    return match ($sort) {
                        'price_asc' => $query->orderByRaw(
                            'COALESCE(NULLIF(discount_price, 0), price) asc'
                        ),
                        'price_desc' => $query->orderByRaw(
                            'COALESCE(NULLIF(discount_price, 0), price) desc'
                        ),
                        default => $query->latest(),
                    };
                },
                fn (Builder $query) => $query->latest()
            )
            ->paginate($perPage);
    }


}
