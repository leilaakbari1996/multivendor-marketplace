<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\IranRuralDistrict;
use App\Models\IranSector;
use App\Queries\CityQuery;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    public function index(
        IranSector $sector,
        CityQuery $cityQuery
    ): JsonResponse {
        return ApiResponse::success(
            message: 'شهرها دریافت شدند.',
            data: [
                'cities' => $cityQuery->getBySector($sector->id),
            ],
        );
    }
}
