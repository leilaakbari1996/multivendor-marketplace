<?php

namespace App\Http\Controllers\Client;

use App\Http\Responses\ApiResponse;
use App\Models\IranProvince;
use App\Queries\ProvinceQuery;
use Illuminate\Contracts\View\View;

class ProvinceController
{
    public function __construct(
        private readonly ProvinceQuery $provinceQuery,
    ) {
    }
    public function index()
    {
        return ApiResponse::success(
            message: 'اطلاعات با موفقیت دریافت شد.',
            data: [
                'provinces' => $this->provinceQuery->getForSelect(),
            ],
        );
    }
}
