<?php

namespace App\Http\Controllers;

use App\Services\AreaRecommendationService;
use Illuminate\Http\JsonResponse;

class AreaController extends Controller
{
    public function __construct(private AreaRecommendationService $service) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->service->allActive(),
        ]);
    }
}
