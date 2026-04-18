<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'rider_profile_id',
        'cv_path',
        'photo_path',
    ];

    /**
     * Relasi: document dimiliki 1 rider_profile
     */
    public function riderProfile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RiderProfile::class);
    }
}
