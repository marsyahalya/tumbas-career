<?php

namespace App\Services;

use App\Models\Area;

class AreaRecommendationService
{
    /**
     * Dapatkan area (tidak lagi menggunakan latitude longitude)
     */
    public function recommend(float $userLat, float $userLng, int $limit = 3): array
    {
        $areas = Area::active()->take($limit)->get();

        return $areas->map(function (Area $area) {
            return [
                'id'           => $area->id,
                'name'         => $area->name,
                'description'  => $area->description,
            ];
        })->all();
    }

    /**
     * Return semua area aktif (untuk pilihan manual)
     */
    public function allActive(): \Illuminate\Database\Eloquent\Collection
    {
        return Area::active()->orderBy('name')->get();
    }
}
