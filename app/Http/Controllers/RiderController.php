<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRiderProfileRequest;
use App\Http\Requests\UpdateRiderProfileRequest;
use App\Models\Document;
use App\Models\Experience;
use App\Models\RiderProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RiderController extends Controller
{
    /**
     * Tampilkan form pendaftaran rider
     */
    public function create(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        // Jika sudah punya profil, redirect ke halaman edit
        if (auth()->user()->riderProfile) {
            return redirect()->route('rider.edit');
        }

        $areas = \App\Models\Area::active()->get();
        return view('rider.create', compact('areas'));
    }

    /**
     * Simpan data pendaftaran rider baru (semua tabel sekaligus)
     */
    public function store(StoreRiderProfileRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            // 1. Simpan Rider Profile
            $profile = RiderProfile::create([
                'user_id'             => auth()->id(),
                'full_name'           => $request->full_name,
                'phone_number'        => $request->phone_number,
                'birth_date'          => $request->birth_date,
                'gender'              => $request->gender,
                'address'             => $request->address,
                'city'                => $request->city,
                'selected_area_id'    => $request->selected_area_id,
                'application_status'  => 'submitted',
            ]);

            // 2. Simpan Experiences (maks 3)
            if ($request->has('experiences')) {
                foreach ($request->experiences as $exp) {
                    if (empty($exp['company_name'])) continue;
                    Experience::create([
                        'rider_profile_id' => $profile->id,
                        'company_name'     => $exp['company_name'],
                        'position'         => $exp['position'] ?? null,
                        'start_date'       => $exp['start_date'],
                        'end_date'         => $exp['end_date'] ?? null,
                    ]);
                }
            }

            // 3. Upload & simpan Dokumen
            $cvPath    = $request->file('cv')->store('documents/cv', 'public');
            $photoPath = $request->file('photo')->store('documents/photo', 'public');

            Document::create([
                'rider_profile_id' => $profile->id,
                'cv_path'          => $cvPath,
                'photo_path'       => $photoPath,
            ]);
        });

        return redirect()->route('rider.show')
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu proses verifikasi.');
    }

    /**
     * Tampilkan detail profil rider yang sedang login
     */
    public function show(): View
    {
        $profile = auth()->user()
            ->riderProfile()
            ->with(['experiences', 'document'])
            ->firstOrFail();

        return view('rider.show', compact('profile'));
    }

    /**
     * Tampilkan form edit profil rider
     */
    public function edit(): View
    {
        $profile = auth()->user()
            ->riderProfile()
            ->with(['experiences', 'document'])
            ->firstOrFail();

        $areas = \App\Models\Area::active()->get();
        return view('rider.edit', compact('profile', 'areas'));
    }

    /**
     * Update data profil rider sebelum submit final
     */
    public function update(UpdateRiderProfileRequest $request): RedirectResponse
    {
        $profile = auth()->user()->riderProfile;

        DB::transaction(function () use ($request, $profile) {
            // 1. Update Rider Profile
            $profile->update($request->only([
                'full_name', 'phone_number', 'birth_date', 'gender',
                'address', 'city', 'selected_area_id',
            ]));

            // 2. Update Experiences: hapus semua lalu buat ulang
            if ($request->has('experiences')) {
                $profile->experiences()->delete();
                foreach ($request->experiences as $exp) {
                    if (empty($exp['company_name'])) continue;
                    Experience::create([
                        'rider_profile_id' => $profile->id,
                        'company_name'     => $exp['company_name'],
                        'position'         => $exp['position'] ?? null,
                        'start_date'       => $exp['start_date'],
                        'end_date'         => $exp['end_date'] ?? null,
                    ]);
                }
            }

            // 3. Update Dokumen (jika ada file baru)
            $document = $profile->document;

            if ($request->hasFile('cv')) {
                // Hapus file lama
                if ($document && $document->cv_path) {
                    Storage::disk('public')->delete($document->cv_path);
                }
                $cvPath = $request->file('cv')->store('documents/cv', 'public');
                $document ? $document->update(['cv_path' => $cvPath])
                          : Document::create(['rider_profile_id' => $profile->id, 'cv_path' => $cvPath, 'photo_path' => '']);
            }

            if ($request->hasFile('photo')) {
                // Hapus file lama
                if ($document && $document->photo_path) {
                    Storage::disk('public')->delete($document->photo_path);
                }
                $photoPath = $request->file('photo')->store('documents/photo', 'public');
                $document ? $document->update(['photo_path' => $photoPath])
                          : Document::create(['rider_profile_id' => $profile->id, 'cv_path' => '', 'photo_path' => $photoPath]);
            }
        });

        return redirect()->route('rider.show')
            ->with('success', 'Data berhasil diperbarui.');
    }
    /**
     * Re-apply for alumni riders
     */
    public function reapply(): RedirectResponse
    {
        $profile = auth()->user()->riderProfile;

        // Cek jika sudah alumni
        if ($profile && $profile->auto_employment_status === 'alumni') {
            DB::transaction(function () use ($profile) {
                $profile->update([
                    'application_status'  => 'submitted',
                    'contract_start_date' => null,
                    'contract_end_date'   => null,
                ]);
            });

            return redirect()->route('rider.edit', ['step' => 2])
                ->with('success', 'Silakan pilih area penempatan baru Anda.');
        }

        return redirect()->route('rider.dashboard');
    }
}
