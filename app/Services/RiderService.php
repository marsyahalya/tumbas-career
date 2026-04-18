<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
use App\Models\Document;
use App\Models\Experience;
use App\Models\RiderProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RiderService
{
    /**
     * Handle the registration of a new rider profile.
     */
    public function register(User $user, array $data): RiderProfile
    {
        return DB::transaction(function () use ($user, $data) {
            // 1. Create Profile
            $profile = $user->riderProfile()->create(
                collect($data)->only([
                    'full_name', 'phone_number', 'birth_date', 'gender',
                    'address', 'city', 'selected_area_id'
                ])->toArray() + ['application_status' => ApplicationStatus::SUBMITTED]
            );

            // 2. Handle Experiences
            if (isset($data['experiences'])) {
                $this->syncExperiences($profile, $data['experiences']);
            }

            // 3. Handle Documents
            $this->storeDocuments($profile, $data['cv'], $data['photo']);

            return $profile;
        });
    }

    /**
     * Handle updating an existing rider profile.
     */
    public function updateProfile(RiderProfile $profile, array $data): void
    {
        DB::transaction(function () use ($profile, $data) {
            $profile->update(
                collect($data)->only([
                    'full_name', 'phone_number', 'birth_date', 'gender',
                    'address', 'city', 'selected_area_id',
                ])->toArray()
            );

            if (isset($data['experiences'])) {
                $profile->experiences()->delete();
                $this->syncExperiences($profile, $data['experiences']);
            }

            if (isset($data['cv']) || isset($data['photo'])) {
                $this->updateDocuments($profile, $data['cv'] ?? null, $data['photo'] ?? null);
            }
        });
    }

    protected function syncExperiences(RiderProfile $profile, array $experiencesData): void
    {
        $experiences = collect($experiencesData)
            ->filter(fn($exp) => !empty($exp['company_name']))
            ->map(fn($exp) => [
                'company_name' => $exp['company_name'],
                'position'     => $exp['position'] ?? null,
                'start_date'   => $exp['start_date'],
                'end_date'     => $exp['end_date'] ?? null,
            ]);

        $profile->experiences()->createMany($experiences->toArray());
    }

    protected function storeDocuments(RiderProfile $profile, $cvFile, $photoFile): void
    {
        $profile->document()->create([
            'cv_path'    => $cvFile->store('documents/cv', 'public'),
            'photo_path' => $photoFile->store('documents/photo', 'public'),
        ]);
    }

    protected function updateDocuments(RiderProfile $profile, $cvFile = null, $photoFile = null): void
    {
        $document = $profile->document;

        if ($cvFile) {
            if ($document->cv_path) Storage::disk('public')->delete($document->cv_path);
            $document->update(['cv_path' => $cvFile->store('documents/cv', 'public')]);
        }

        if ($photoFile) {
            if ($document->photo_path) Storage::disk('public')->delete($document->photo_path);
            $document->update(['photo_path' => $photoFile->store('documents/photo', 'public')]);
        }
    }
}
