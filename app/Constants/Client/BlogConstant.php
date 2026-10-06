<?php

namespace App\Constants\Client;

class BlogConstant
{
    public const int PER_PAGE = 9;

    public const array DEFAULT_FILTERS = [
        'search'   => null,
    ];

    public const int RECENT_POSTS_LIMIT = 5;
}
