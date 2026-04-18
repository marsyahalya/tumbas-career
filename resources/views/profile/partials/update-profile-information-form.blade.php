<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')


        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tumbas-light">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Rider Specific Fields --}}
        @if($user->isRider() && $user->riderProfile)
            <div>
                <x-input-label for="phone_number" :value="__('Nomor HP')" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->riderProfile->phone_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>



            <div>
                <x-input-label for="address" :value="__('Alamat Lengkap')" />
                <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 focus:border-tumbas focus:ring-tumbas rounded-md shadow-sm" rows="3">{{ old('address', $user->riderProfile->address) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <x-input-label for="cv" :value="__('Update CV (PDF)')" />
                    <input id="cv" name="cv" type="file" class="mt-1 block w-full text-sm" accept=".pdf" />
                    @if($user->riderProfile->document && $user->riderProfile->document->cv_path)
                        <p class="mt-1 text-[10px] text-green-600 font-bold">✓ <a href="{{ Storage::url($user->riderProfile->document->cv_path) }}" target="_blank" class="underline">Lihat CV Saat Ini</a></p>
                    @endif
                    <x-input-error class="mt-2" :messages="$errors->get('cv')" />
                </div>
                <div>
                    <x-input-label for="photo" :value="__('Update Foto Diri')" />
                    <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm" accept="image/*" />
                    @if($user->riderProfile->document && $user->riderProfile->document->photo_path)
                        <p class="mt-1 text-[10px] text-green-600 font-bold">✓ <a href="{{ Storage::url($user->riderProfile->document->photo_path) }}" target="_blank" class="underline">Lihat Foto Saat Ini</a></p>
                    @endif
                    <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
