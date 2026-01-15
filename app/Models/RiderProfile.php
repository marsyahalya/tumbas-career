<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'interview_attendance',
        'interview_sent_at',
        'interview_attendance_count',
        'interview_attendance_updated_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'interview_sent_at' => 'datetime',
        'interview_attendance_updated_at' => 'datetime',
    ];

    const STATUS_LABELS = [
        'submit'            => 'Pendaftaran Terkirim',
        'verifikasi_berkas' => 'Verifikasi Data',
        'wawancara'         => 'Wawancara',
        'final_approval'    => 'Persetujuan Akhir',
    ];

    const EMPLOYMENT_STATUS_LABELS = [
        'terima'  => 'Diterima',
        'ditolak' => 'Ditolak',
    ];

    const STATUSES = [
        'submit',
        'verifikasi_berkas',
        'wawancara',
        'final_approval',
    ];

    public function getStatusLabelAttribute(): string
    {
        $label = self::STATUS_LABELS[$this->application_status] ?? $this->application_status;
        $employmentStatus = $this->contract?->status;

        if ($employmentStatus === 'ditolak') {
            return $label . ' (Ditolak)';
        }

        if ($this->application_status === 'final_approval' && $employmentStatus === 'terima') {
            return $this->auto_employment_status === 'alumni' ? 'Alumni' : 'Diterima';
        }

        return $label;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function document(): HasOne
    {
        return $this->hasOne(Document::class);
    }

    public function education(): HasOne
    {
        return $this->hasOne(RiderEducation::class);
    }

    public function contract(): HasOne
    {
        return $this->hasOne(RiderContract::class);
    }

    public function selectedArea(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'selected_area_id');
    }

    public function canAddExperience(): bool
    {
        return $this->experiences()->count() < 3;
    }

    public function getEducationLevelAttribute()
    {
        return $this->education?->level;
    }

    public function getEducationInstitutionAttribute()
    {
        return $this->education?->institution;
    }

    public function getGraduationYearAttribute()
    {
        return $this->education?->graduation_year;
    }

    public function getEmploymentStatusAttribute()
    {
        return $this->contract?->status;
    }

    public function getContractStartDateAttribute()
    {
        return $this->contract?->start_date;
    }

    public function getContractEndDateAttribute()
    {
        return $this->contract?->end_date;
    }

    public function getAutoEmploymentStatusAttribute()
    {
        $contract = $this->contract;

        if ($this->application_status !== 'final_approval' || $contract?->status !== 'terima') {
            return null;
        }

        if (!$contract->end_date) {
            return 'active';
        }

        return today()->isAfter($contract->end_date) ? 'alumni' : 'active';
    }

    public function getEffectiveAttendanceAttribute()
    {
        if ($this->application_status === 'wawancara' && 
            !$this->interview_attendance && 
            $this->interview_sent_at && 
            $this->interview_sent_at->addDay()->isPast()) {
            
            $this->update([
                'interview_attendance' => 'tidak_hadir',
                'interview_attendance_updated_at' => now(),
            ]);
            return 'tidak_hadir';
        }

        return $this->interview_attendance;
    }

    public function scopeOrderByApplicationStatus($query)
    {
        return $query->leftJoin('rider_contracts', 'rider_profiles.id', '=', 'rider_contracts.rider_profile_id')
            ->select('rider_profiles.*')
            ->orderByRaw("
                CASE 
                    WHEN application_status = 'submit' THEN 1
                    WHEN application_status = 'verifikasi_berkas' AND (rider_contracts.status IS NULL OR rider_contracts.status = 'terima') THEN 2
                    WHEN application_status = 'wawancara' THEN 3
                    WHEN application_status = 'final_approval' AND rider_contracts.status IS NULL THEN 4
                    WHEN application_status = 'final_approval' AND rider_contracts.status = 'terima' AND (rider_contracts.end_date >= CURRENT_DATE OR rider_contracts.end_date IS NULL) THEN 5
                    WHEN application_status = 'final_approval' AND rider_contracts.status = 'terima' AND rider_contracts.end_date < CURRENT_DATE THEN 6
                    WHEN rider_contracts.status = 'ditolak' THEN 7
                    ELSE 8
                END ASC
            ")->latest('rider_profiles.updated_at');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('full_name', 'like', '%' . $search . '%');
    }
}
