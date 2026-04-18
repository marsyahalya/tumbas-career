<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->only('email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Sync with RiderProfile if user is a rider
        if ($user->isRider() && $user->riderProfile) {
            $profile = $user->riderProfile;
            $profile->update($request->only('phone_number', 'address'));

            // Handle Documents
            $document = $profile->document;

            if ($request->hasFile('cv')) {
                if ($document && $document->cv_path) {
                    Storage::disk('public')->delete($document->cv_path);
                }
                $cvPath = $request->file('cv')->store('documents/cv', 'public');
                $document ? $document->update(['cv_path' => $cvPath])
                          : Document::create(['rider_profile_id' => $profile->id, 'cv_path' => $cvPath, 'photo_path' => '']);
            }

            if ($request->hasFile('photo')) {
                if ($document && $document->photo_path) {
                    Storage::disk('public')->delete($document->photo_path);
                }
                $photoPath = $request->file('photo')->store('documents/photo', 'public');
                $document ? $document->update(['photo_path' => $photoPath])
                          : Document::create(['rider_profile_id' => $profile->id, 'cv_path' => '', 'photo_path' => $photoPath]);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
