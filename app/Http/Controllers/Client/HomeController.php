<?php

namespace App\Http\Controllers\Client;

use App\Constants\ClientView;
use App\Http\Controllers\Controller;
use App\Queries\HomeQuery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomeQuery $homeQuery,
    ) {}

    public function index()
    {
        return view(
            ClientView::PREFIX.'index',
            $this->homeQuery->get()
        );
    }
}
