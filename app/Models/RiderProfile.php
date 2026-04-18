<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone_number',
        'birth_date',
        'gender',
        'address',
        'city',
        'selected_area_id',
        'application_status',
        'interview_message',
        'contract_start_date',
        'contract_end_date',
        'employment_status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'application_status' => \App\Enums\ApplicationStatus::class,
    ];

    /**
     * Get label for current status
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->application_status->label();
    }


    /**
     * Relasi: 1 rider_profile dimiliki 1 user
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: 1 rider_profile memiliki banyak experiences (max 3)
     */
    public function experiences(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Relasi: 1 rider_profile memiliki 1 document
     */
    public function document(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Document::class);
    }

    /**
     * Cek apakah masih bisa menambah pengalaman (max 3)
     */
    public function canAddExperience(): bool
    {
        return $this->experiences()->count() < 3;
    }

    /**
     * Relasi: RiderProfile belongsTo Area (selected_area)
     */
    public function selectedArea(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Area::class, 'selected_area_id');
    }

    /**
     * Get updated employment status based on dates
     */
    public function getAutoEmploymentStatusAttribute()
    {
        if ($this->application_status !== 'accepted')
            return null;
        if (!$this->contract_end_date)
            return 'active';

        // Menjadi alumni hanya jika sudah melewati tanggal akhir (besoknya)
        return today()->isAfter($this->contract_end_date) ? 'alumni' : 'active';
    }
}
