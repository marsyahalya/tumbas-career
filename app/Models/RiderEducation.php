<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiderEducation extends Model
{
    use HasFactory;

    protected $table = 'rider_educations';

    protected $fillable = [
        'rider_profile_id',
        'level',
        'institution',
        'graduation_year',
    ];

    public function riderProfile(): BelongsTo
    {
        return $this->belongsTo(RiderProfile::class);
    }
}
