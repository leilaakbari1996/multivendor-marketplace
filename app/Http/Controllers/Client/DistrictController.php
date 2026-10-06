<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Queries\DistrictQuery;
use App\Models\IranCounty;
use Illuminate\Http\JsonResponse;

class DistrictController extends Controller
{
    public function index(
        IranCounty $county,
        DistrictQuery $districtQuery
    ): JsonResponse {
        return ApiResponse::success(
            message: 'بخش‌ها دریافت شدند.',
            data: [
                'districts' => $districtQuery->getByCounty($county->id),
            ],
        );
    }
}
