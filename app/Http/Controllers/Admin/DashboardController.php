<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminView;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = AdminView::DASHBOARD_TITLE;
        return view(AdminView::DASHBOARD_INDEX, compact('title'));
    }
}
