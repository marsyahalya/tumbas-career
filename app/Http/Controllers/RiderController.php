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
    public function create(): View|RedirectResponse
    {
        // Jika sudah punya profil, redirect ke halaman edit
        if (auth()->user()->riderProfile) {
            return redirect()->route('rider.edit');
        }

        return view('rider.create', [
            'areas' => \App\Models\Area::active()->get()
        ]);
    }

    /**
     * Simpan data pendaftaran rider baru (semua tabel sekaligus)
     */
    public function store(StoreRiderProfileRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $user = $request->user();

            // 1. Simpan Rider Profile
            $profile = $user->riderProfile()->create(
                $request->safe()->only([
                    'full_name', 'phone_number', 'birth_date', 'gender',
                    'address', 'city', 'selected_area_id'
                ]) + ['application_status' => 'submitted']
            );

            // 2. Simpan Experiences (maks 3)
            if ($request->has('experiences')) {
                $experiences = collect($request->experiences)
                    ->filter(fn($exp) => !empty($exp['company_name']))
                    ->map(fn($exp) => [
                        'company_name' => $exp['company_name'],
                        'position'     => $exp['position'] ?? null,
                        'start_date'   => $exp['start_date'],
                        'end_date'     => $exp['end_date'] ?? null,
                    ]);

                $profile->experiences()->createMany($experiences->toArray());
            }

            // 3. Upload & simpan Dokumen
            $profile->document()->create([
                'cv_path'    => $request->file('cv')->store('documents/cv', 'public'),
                'photo_path' => $request->file('photo')->store('documents/photo', 'public'),
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

        return view('rider.edit', [
            'profile' => $profile,
            'areas'   => \App\Models\Area::active()->get()
        ]);
    }

    /**
     * Update data profil rider sebelum submit final
     */
    public function update(UpdateRiderProfileRequest $request): RedirectResponse
    {
        $profile = $request->user()->riderProfile;

        DB::transaction(function () use ($request, $profile) {
            // 1. Update Rider Profile
            $profile->update($request->safe()->only([
                'full_name', 'phone_number', 'birth_date', 'gender',
                'address', 'city', 'selected_area_id',
            ]));

            // 2. Update Experiences: hapus semua lalu buat ulang
            if ($request->has('experiences')) {
                $profile->experiences()->delete();
                
                $experiences = collect($request->experiences)
                    ->filter(fn($exp) => !empty($exp['company_name']))
                    ->map(fn($exp) => [
                        'company_name' => $exp['company_name'],
                        'position'     => $exp['position'] ?? null,
                        'start_date'   => $exp['start_date'],
                        'end_date'     => $exp['end_date'] ?? null,
                    ]);

                $profile->experiences()->createMany($experiences->toArray());
            }

            // 3. Update Dokumen (jika ada file baru)
            $document = $profile->document;

            foreach (['cv', 'photo'] as $fileType) {
                if ($request->hasFile($fileType)) {
                    $pathField = $fileType . '_path';
                    
                    // Delete old file
                    if ($document && $document->$pathField) {
                        Storage::disk('public')->delete($document->$pathField);
                    }

                    $newPath = $request->file($fileType)->store("documents/$fileType", 'public');
                    
                    if ($document) {
                        $document->update([$pathField => $newPath]);
                    } else {
                        $profile->document()->create([$pathField => $newPath]);
                    }
                }
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

        if ($profile?->auto_employment_status === 'alumni') {
            $profile->update([
                'application_status'  => 'submitted',
                'contract_start_date' => null,
                'contract_end_date'   => null,
            ]);

            return redirect()->route('rider.edit', ['step' => 2])
                ->with('success', 'Silakan pilih area penempatan baru Anda.');
        }

        return redirect()->route('rider.dashboard');
    }

}
