<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect ke Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }

        // Cari user berdasarkan social_id atau email
        $user = User::where('social_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Update social data jika belum ada
            if (!$user->social_id) {
                $user->update([
                    'social_id'       => $googleUser->getId(),
                    'social_provider' => 'google',
                ]);
            }
        } else {
            // Buat user baru
            $user = User::create([
                'email'           => $googleUser->getEmail(),
                'social_id'       => $googleUser->getId(),
                'social_provider' => 'google',
                'role'            => 'rider',
                'password'        => null,
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended(route('rider.create'));
    }
}
