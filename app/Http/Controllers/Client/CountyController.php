<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Queries\CountyQuery;
use App\Models\IranProvince;
use Illuminate\Http\JsonResponse;

class CountyController extends Controller
{
    public function index(
        IranProvince $province,
        CountyQuery $countyQuery
    ): JsonResponse {
        return ApiResponse::success(
            message: 'شهرستان‌ها دریافت شدند.',
            data: [
                'counties' => $countyQuery->getByProvince($province->id),
            ],
        );
    }
}
