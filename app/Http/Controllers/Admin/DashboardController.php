<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminView;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = __('sidebar.dashboard');
        return view(AdminView::PREFIX.'dashboard.index', compact('title'));
    }
}
