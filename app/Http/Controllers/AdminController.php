<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRiderStatusRequest;
use App\Models\RiderProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Tampilkan daftar semua rider beserta status terbaru
     */
    public function index(): View
    {
        $riders = RiderProfile::with(['user', 'selectedArea'])
            ->latest()
            ->paginate(15);

        return view('admin.riders.index', compact('riders'));
    }

    /**
     * Tampilkan detail lengkap seorang rider
     */
    public function show(RiderProfile $riderProfile): View
    {
        $riderProfile->load(['user', 'experiences', 'document']);

        return view('admin.riders.show', compact('riderProfile'));
    }

    /**
     * Update status rider oleh admin
     */
    public function updateStatus(UpdateRiderStatusRequest $request, RiderProfile $riderProfile): RedirectResponse
    {
        $data = $request->validated();

        // Logic: Jika baru saja di-set 'accepted', isi otomatis contract_start_date ke hari ini (jika belum ada)
        if ($data['application_status'] === 'accepted' && $riderProfile->application_status !== 'accepted') {
            $data['contract_start_date'] ??= now();
        }

        $riderProfile->update($data);

        return redirect()->route('admin.riders.show', $riderProfile)
            ->with('success', "Data rider '{$riderProfile->full_name}' berhasil diperbarui ke status " . $riderProfile->status_label);
    }

    /**
     * Download CV Rider
     */
    public function downloadCv(RiderProfile $riderProfile)
    {
        $cvPath = $riderProfile->document?->cv_path;

        if (!$cvPath || !Storage::disk('public')->exists($cvPath)) {
            return back()->with('error', 'File CV tidak tersedia atau gagal diunduh.');
        }

        return Storage::disk('public')->response($cvPath);
    }

}
