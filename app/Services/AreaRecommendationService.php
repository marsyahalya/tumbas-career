<?php

namespace App\Services;

use App\Models\Area;

class AreaRecommendationService
{
    public function allActive(): \Illuminate\Database\Eloquent\Collection
    {
        return Area::active()->orderBy('name')->get();
    }
}
