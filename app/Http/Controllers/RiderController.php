<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRiderProfileRequest;
use App\Http\Requests\UpdateRiderProfileRequest;
use App\Models\Area;
use App\Models\Document;
use App\Models\Experience;
use App\Models\RiderProfile;
use App\Models\RiderEducation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RiderController extends Controller
{
    protected $riderService;
    
    public function __construct(\App\Services\RiderService $riderService)
    {
        $this->riderService = $riderService;
    }

    public function create(): View|RedirectResponse
    {
        if (auth()->user()->riderProfile) {
            return redirect()->route('rider.edit');
        }

        $areas = Area::active()->get();
        
        return view('rider.create', compact('areas'));
    }

    public function store(StoreRiderProfileRequest $request): RedirectResponse
    {
        $this->riderService->createProfile(
            $request->validated(),
            $request->file('cv'),
            $request->file('photo')
        );

        return redirect()->route('rider.show')
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu proses verifikasi.');
    }

    public function show(): View
    {
        $profile = auth()->user()
            ->riderProfile()
            ->with(['experiences', 'document', 'education', 'contract'])
            ->firstOrFail();

        return view('rider.show', compact('profile'));
    }

    public function edit(): View
    {
        $profile = auth()->user()
            ->riderProfile()
            ->with(['experiences', 'document', 'education', 'contract'])
            ->firstOrFail();

        $areas = Area::active()->get();
        
        return view('rider.edit', compact('profile', 'areas'));
    }

    public function update(UpdateRiderProfileRequest $request): RedirectResponse
    {
        $this->riderService->updateProfile(
            auth()->user()->riderProfile,
            $request->validated(),
            $request->file('cv'),
            $request->file('photo')
        );

        return redirect()->route('rider.show')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function reapply(): RedirectResponse
    {
        $profile = auth()->user()->riderProfile;

        $isAlumni = $profile?->auto_employment_status === 'alumni';
        $isRejected = $profile?->employment_status === 'ditolak';
        $isReapplying = $profile?->employment_status === 'reapplying';

        if ($isAlumni || $isRejected || $isReapplying) {
            $this->riderService->reapply($profile);

            return redirect()->route('rider.edit', ['step' => 2])
                ->with('success', 'Silakan perbarui data Anda dan pilih area penempatan.');
        }

        return redirect()->route('rider.dashboard');
    }

    public function updateAttendance(\Illuminate\Http\Request $request): RedirectResponse
    {
        $request->validate([
            'attendance' => 'required|in:hadir,tidak_hadir',
        ]);

        $profile = auth()->user()->riderProfile;
        
        if (!$profile) {
            return redirect()->back();
        }

        try {
            $this->riderService->updateAttendance($profile, $request->attendance);
            return redirect()->back()->with('success', 'Konfirmasi kehadiran berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
