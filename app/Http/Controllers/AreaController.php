<?php

namespace App\Http\Controllers;

use App\Services\AreaRecommendationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function __construct(private AreaRecommendationService $service) {}

    /**
     * GET /api/areas/recommend?lat=&lng=
     * Kembalikan top-3 area rekomendasi berdasarkan koordinat user
     */
    public function recommend(Request $request): JsonResponse
    {
        $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $recommendations = $this->service->recommend(
            (float) $request->lat,
            (float) $request->lng
        );

        return response()->json([
            'success' => true,
            'data'    => $recommendations,
        ]);
    }

    /**
     * GET /api/areas
     * Kembalikan semua area aktif (untuk dropdown manual)
     */
    public function index(): JsonResponse
    {
        $areas = $this->service->allActive();

        return response()->json([
            'success' => true,
            'data'    => $areas,
        ]);
    }
}
