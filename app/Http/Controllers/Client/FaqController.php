<?php

namespace App\Http\Controllers\Client;

use App\Constants\ClientView;
use App\Queries\FaqQuery;

class FaqController
{
    public function __construct(
        private readonly FaqQuery $faqQuery,
    ) {
    }
    public function index()
    {
        return view(
            ClientView::PREFIX.'faq',
            $this->faqQuery->get()
        );
    }
}
