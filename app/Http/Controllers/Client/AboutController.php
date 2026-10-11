<?php

namespace App\Http\Controllers\Client;

use App\Constants\ClientView;
use App\Queries\AboutQuery;
use App\Queries\ShopBenefitQuery;

class AboutController
{
    public function __construct(
        private readonly AboutQuery $aboutQuery,
    ) {
    }
    public function index()
    {
        return view(
            ClientView::PREFIX.'about',
            $this->aboutQuery->get()
        );
    }
}
