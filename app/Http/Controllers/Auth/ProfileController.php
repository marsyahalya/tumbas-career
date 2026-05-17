<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $riderService;

    public function __construct(\App\Services\RiderService $riderService)
    {
        $this->riderService = $riderService;
    }

    public function edit(Request $request): View
    {
        return view('auth.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->only('email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($user->isRider() && $user->riderProfile) {
            $this->riderService->updateProfile(
                $user->riderProfile,
                $request->validated(),
                $request->file('cv'),
                $request->file('photo')
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->riderProfile) {
            $document = $user->riderProfile->document;
            if ($document) {
                if ($document->cv_path) Storage::disk('public')->delete($document->cv_path);
                if ($document->photo_path) Storage::disk('public')->delete($document->photo_path);
            }
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
