<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Experience;
use App\Models\RiderEducation;
use App\Models\RiderProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class RiderService
{
    public function createProfile(array $data, ?UploadedFile $cv, ?UploadedFile $photo): RiderProfile
    {
        return DB::transaction(function () use ($data, $cv, $photo) {
            $profile = RiderProfile::create([
                'user_id' => auth()->id(),
                'full_name' => $data['full_name'],
                'phone_number' => $data['phone_number'],
                'birth_date' => $data['birth_date'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'city' => $data['city'],
                'selected_area_id' => $data['selected_area_id'],
                'application_status' => 'submit',
            ]);

            $this->updateEducation($profile, $data);
            $this->updateExperiences($profile, $data['experiences'] ?? []);
            $this->updateDocuments($profile, $cv, $photo);

            return $profile;
        });
    }

    public function updateProfile(RiderProfile $profile, array $data, ?UploadedFile $cv, ?UploadedFile $photo): void
    {
        DB::transaction(function () use ($profile, $data, $cv, $photo) {
            $profile->update(collect($data)->only([
                'full_name',
                'phone_number',
                'birth_date',
                'gender',
                'address',
                'city',
                'selected_area_id',
                'application_status',
                'interview_message',
                'interview_sent_at',
            ])->toArray());

            $this->updateEducation($profile, $data);
            
            if (isset($data['experiences'])) {
                $this->updateExperiences($profile, $data['experiences']);
            }

            if ($profile->contract?->status === 'reapplying') {
                $profile->contract()->update(['status' => null]);
            }

            $this->updateDocuments($profile, $cv, $photo);
        });
    }

    protected function updateEducation(RiderProfile $profile, array $data): void
    {
        $profile->education()->updateOrCreate(
            ['rider_profile_id' => $profile->id],
            [
                'level' => $data['education_level'] ?? null,
                'institution' => $data['education_institution'] ?? null,
                'graduation_year' => $data['graduation_year'] ?? null,
            ]
        );
    }

    protected function updateExperiences(RiderProfile $profile, array $experiences): void
    {
        $profile->experiences()->delete();
        
        foreach ($experiences as $exp) {
            if (!empty($exp['company_name'])) {
                Experience::create([
                    'rider_profile_id' => $profile->id,
                    'company_name' => $exp['company_name'],
                    'position' => $exp['position'] ?? null,
                    'start_date' => $exp['start_date'],
                    'end_date' => $exp['end_date'] ?? null,
                ]);
            }
        }
    }

    protected function updateDocuments(RiderProfile $profile, ?UploadedFile $cv, ?UploadedFile $photo): void
    {
        $document = $profile->document;
        $updates = [];

        if ($cv) {
            $updates['cv_path'] = $this->uploadDocument($cv, 'documents/cv', $document?->cv_path);
        }

        if ($photo) {
            $updates['photo_path'] = $this->uploadDocument($photo, 'documents/photo', $document?->photo_path);
        }

        if (!empty($updates)) {
            $profile->document()->updateOrCreate(
                ['rider_profile_id' => $profile->id],
                $updates
            );
        }
    }

    protected function uploadDocument(UploadedFile $file, string $directory, ?string $oldPath = null): string
    {
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $file->store($directory, 'public');
    }

    public function reapply(RiderProfile $profile): void
    {
        DB::transaction(function () use ($profile) {
            $profile->update([
                'application_status' => 'submit',
                'interview_message' => null,
            ]);

            $profile->contract()->updateOrCreate(
                ['rider_profile_id' => $profile->id],
                ['status' => 'reapplying']
            );
        });
    }

    public function updateStatus(RiderProfile $riderProfile, array $data): bool
    {
        $sendEmail = $this->shouldSendEmailNotification($riderProfile, $data);

        if ($sendEmail && $data['application_status'] === 'wawancara') {
            $data['interview_sent_at'] = now();
        }

        $contractData = $this->prepareContractData($riderProfile, $data);

        if (!empty($contractData)) {
            $riderProfile->contract()->updateOrCreate(
                ['rider_profile_id' => $riderProfile->id],
                $contractData
            );
        }

        $mainData = collect($data)->except(['employment_status', 'contract_start_date', 'contract_end_date'])->toArray();
        $riderProfile->update($mainData);

        return $sendEmail;
    }

    protected function shouldSendEmailNotification(RiderProfile $profile, array $data): bool
    {
        $status = $data['application_status'];

        if ($status === 'wawancara') {
            $statusChanged = $profile->application_status !== 'wawancara';
            $messageChanged = isset($data['interview_message']) && $profile->interview_message !== $data['interview_message'];
            return $statusChanged || $messageChanged;
        }

        if (in_array($status, ['verifikasi_berkas', 'final_approval'])) {
            if (isset($data['employment_status'])) {
                $statusChanged = $profile->application_status !== $status;
                $employmentChanged = $profile->employment_status !== $data['employment_status'];
                return $statusChanged || $employmentChanged;
            }
        }

        return false;
    }

    protected function prepareContractData(RiderProfile $profile, array $data): array
    {
        $status = $data['application_status'];
        
        if (in_array($status, ['submit', 'wawancara'])) {
            return ['status' => null];
        }

        $contractData = [];
        
        if (isset($data['employment_status'])) {
            $contractData['status'] = $data['employment_status'];
        }
        
        if (isset($data['contract_start_date'])) {
            $contractData['start_date'] = $data['contract_start_date'];
        }
        
        if (isset($data['contract_end_date'])) {
            $contractData['end_date'] = $data['contract_end_date'];
        }
        
        // Auto set start date if accepted and not already set
        if ($status === 'final_approval' && ($data['employment_status'] ?? '') === 'terima') {
            if (!$profile->contract_start_date && !isset($data['contract_start_date'])) {
                $contractData['start_date'] = now()->format('Y-m-d');
            }
        }

        return $contractData;
    }

    public function updateAttendance(RiderProfile $profile, string $attendance): bool
    {
        if ($profile->application_status !== 'wawancara') {
            return false;
        }

        if ($profile->interview_attendance_count >= 3) {
            throw new \Exception('Batas maksimal perubahan konfirmasi (3x) telah tercapai.');
        }

        return $profile->update([
            'interview_attendance' => $attendance,
            'interview_attendance_count' => $profile->interview_attendance_count + 1,
            'interview_attendance_updated_at' => now(),
        ]);
    }
}
