<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRiderStatusRequest;
use App\Models\RiderProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya admin yang bisa akses semua method
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->isAdmin()) {
                abort(403, 'Akses ditolak. Hanya admin yang diperbolehkan.');
            }
            return $next($request);
        });
    }

    /**
     * Tampilkan daftar semua rider beserta status terbaru
     */
    public function index(): View
    {
        // Sync alumni status (simple cleanup)
        RiderProfile::where('application_status', 'accepted')
            ->whereNotNull('contract_end_date')
            ->where('contract_end_date', '<', today())
            ->update(['application_status' => 'accepted']); // Still accepted, but the compute logic will show alumni.

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
     *
     * Alur status yang valid:
     * submitted → document_verification → interview → final_approval → accepted
     *                                                                 → rejected (kapan saja)
     */
    public function updateStatus(UpdateRiderStatusRequest $request, RiderProfile $riderProfile): RedirectResponse
    {
        $oldStatus = $riderProfile->application_status;
        $data = $request->validated();

        // Logic: Jika baru saja di-set 'accepted', isi otomatis contract_start_date ke hari ini (jika belum ada)
        if ($data['application_status'] === 'accepted' && $oldStatus !== 'accepted') {
            if (!$riderProfile->contract_start_date) {
                $data['contract_start_date'] = now();
            }
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
        $document = $riderProfile->document;

        if (!$document || !$document->cv_path || !Storage::disk('public')->exists($document->cv_path)) {
            return back()->with('error', 'File CV tidak tersedia atau gagal diunduh.');
        }

        return Storage::disk('public')->response($document->cv_path);
    }
}
