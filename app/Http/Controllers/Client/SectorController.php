<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\IranCounty;
use App\Queries\SectorQuery;
use Illuminate\Http\JsonResponse;

class SectorController extends Controller
{
    public function index(
        IranCounty $county,
        SectorQuery $sectorQuery
    ): JsonResponse {
        return ApiResponse::success(
            message: 'بخش‌ها دریافت شدند.',
            data: [
                'sectors' => $sectorQuery->getByCounty($county->id),
            ],
        );
    }
}
