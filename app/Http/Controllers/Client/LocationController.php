<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
class LocationController extends Controller
{
    public function provinces(): JsonResponse
    {
        return response()->json([
            'provinces' => DB::table('iran_provinces')
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function counties(int $province): JsonResponse
    {
        return response()->json([
            'counties' => DB::table('iran_counties')
                ->where('province_id', $province)
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function sectors(int $county): JsonResponse
    {
        return response()->json([
            'sectors' => DB::table('iran_sectors')
                ->where('county_id', $county)
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function cities(int $sector): JsonResponse
    {
        return response()->json([
            'cities' => DB::table('iran_cities')
                ->where('sector_id', $sector)
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }
}
