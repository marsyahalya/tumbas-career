<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRiderStatusRequest;
use App\Models\RiderProfile;
use App\Models\RiderContract;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Mail\RiderStatusUpdatedMail;

class AdminController extends Controller
{
    protected $riderService;
    
    public function __construct(\App\Services\RiderService $riderService)
    {
        $this->riderService = $riderService;
    }

    public function index(Request $request): View
    {
        $query = RiderProfile::with(['user', 'selectedArea', 'contract'])
            ->orderByApplicationStatus();

        if ($request->filled('status')) {
            $query->where('application_status', $request->status);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('employment_status')) {
            $query->whereHas('contract', function ($q) use ($request) {
                $q->where('status', $request->employment_status);
            });
        }

        $riders = $query->paginate(10)->withQueryString();

        return view('admin.riders.index', compact('riders'));
    }

    public function show(RiderProfile $riderProfile): View
    {
        $riderProfile->load(['user', 'experiences', 'document', 'education', 'contract']);

        return view('admin.riders.show', compact('riderProfile'));
    }

    public function updateStatus(UpdateRiderStatusRequest $request, RiderProfile $riderProfile): RedirectResponse
    {
        $sendEmail = $this->riderService->updateStatus($riderProfile, $request->validated());

        if ($sendEmail && $riderProfile->user?->email) {
            Mail::to($riderProfile->user->email)->send(new RiderStatusUpdatedMail($riderProfile->fresh(['user', 'contract'])));
        }

        return redirect()->route('admin.riders.show', $riderProfile)
            ->with('success', "Data rider '{$riderProfile->full_name}' berhasil diperbarui.");
    }

    public function downloadCv(RiderProfile $riderProfile)
    {
        $document = $riderProfile->document;

        if (!$document || !$document->cv_path || !Storage::disk('public')->exists($document->cv_path)) {
            return back()->with('error', 'File CV tidak tersedia atau gagal diunduh.');
        }

        return Storage::disk('public')->response($document->cv_path);
    }
}
