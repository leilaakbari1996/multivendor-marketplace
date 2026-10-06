<?php

namespace App\Constants\Client;

class ProductConstant
{
    public const int PER_PAGE = 12;

    public const array DEFAULT_FILTERS = [
        'search'             => null,
        'category'           => null,
        'min_price'          => null,
        'max_price'          => null,
        'in_stock'           => false,
        'on_sale'            => false,
        'is_featured'        => false,
        'is_best_selling'    => false,
    ];
}
