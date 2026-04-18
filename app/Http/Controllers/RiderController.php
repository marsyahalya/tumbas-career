<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Http\Requests\StoreRiderProfileRequest;
use App\Http\Requests\UpdateRiderProfileRequest;
use App\Models\RiderProfile;
use App\Services\RiderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RiderController extends Controller
{
    private RiderService $riderService;

    public function __construct(RiderService $riderService)
    {
        $this->riderService = $riderService;
    }

    /**
     * Tampilkan form pendaftaran rider.
     */
    public function create(): View|RedirectResponse
    {
        if (auth()->user()->riderProfile) {
            return redirect()->route('rider.edit');
        }

        return view('rider.create', [
            'areas' => \App\Models\Area::active()->get()
        ]);
    }

    /**
     * Simpan data pendaftaran rider baru menggunakan RiderService.
     */
    public function store(StoreRiderProfileRequest $request): RedirectResponse
    {
        $this->riderService->register($request->user(), $request->all());

        return redirect()->route('rider.show')
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu proses verifikasi.');
    }

    /**
     * Tampilkan detail profil rider yang sedang login.
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
     * Tampilkan form edit profil rider.
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
     * Update data profil rider menggunakan RiderService.
     */
    public function update(UpdateRiderProfileRequest $request): RedirectResponse
    {
        $this->riderService->updateProfile($request->user()->riderProfile, $request->all());

        return redirect()->route('rider.show')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Ajukan pendaftaran ulang untuk eks-rider (alumni).
     */
    public function reapply(): RedirectResponse
    {
        $profile = auth()->user()->riderProfile;

        if ($profile?->auto_employment_status === 'alumni') {
            $profile->update([
                'application_status'  => ApplicationStatus::SUBMITTED,
                'contract_start_date' => null,
                'contract_end_date'   => null,
            ]);

            return redirect()->route('rider.edit', ['step' => 2])
                ->with('success', 'Silakan pilih area penempatan baru Anda.');
        }

        return redirect()->route('rider.dashboard');
    }
}
