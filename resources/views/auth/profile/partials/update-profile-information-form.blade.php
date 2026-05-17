<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi profil akun dan alamat email Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tumbas-light">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Rider Specific Fields --}}
        @if($user->isRider() && $user->riderProfile)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-forms.input-label for="phone_number" :value="__('Nomor HP')" />
                    <x-forms.text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->riderProfile->phone_number)" />
                    <x-forms.input-error class="mt-2" :messages="$errors->get('phone_number')" />
                </div>
                <div>
                     <x-forms.input-label for="city" :value="__('Kota Domisili')" />
                     <x-forms.text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->riderProfile->city)" />
                     <x-forms.input-error class="mt-2" :messages="$errors->get('city')" />
                </div>
            </div>

            <div>
                <x-forms.input-label for="address" :value="__('Alamat Lengkap')" />
                <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 focus:border-tumbas focus:ring-tumbas rounded-md shadow-sm" rows="3">{{ old('address', $user->riderProfile->address) }}</textarea>
                <x-forms.input-error class="mt-2" :messages="$errors->get('address')" />
            </div>

            {{-- Pendidikan --}}
            <div class="pt-4 border-t border-stone-100">
                <h4 class="text-xs font-bold text-stone-500 mb-4 uppercase tracking-widest">Informasi Pendidikan</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-forms.input-label for="education_level" :value="__('Jenjang Terakhir')" />
                        <select id="education_level" name="education_level" class="mt-1 block w-full border-gray-300 focus:border-stone-500 focus:ring-stone-500 rounded-md shadow-sm text-sm">
                            <option value="">Pilih Jenjang</option>
                            @foreach(['SMA', 'SMK', 'D3', 'S1', 'S2'] as $level)
                                <option value="{{ $level }}" {{ (old('education_level', $user->riderProfile->education_level) == $level) ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                        <x-forms.input-error class="mt-2" :messages="$errors->get('education_level')" />
                    </div>
                    <div>
                        <x-forms.input-label for="education_institution" :value="__('Institusi')" />
                        <x-forms.text-input id="education_institution" name="education_institution" type="text" class="mt-1 block w-full" :value="old('education_institution', $user->riderProfile->education_institution)" />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('education_institution')" />
                    </div>
                    <div>
                        <x-forms.input-label for="graduation_year" :value="__('Thn Lulus')" />
                        <x-forms.text-input id="graduation_year" name="graduation_year" type="number" class="mt-1 block w-full" :value="old('graduation_year', $user->riderProfile->graduation_year)" min="1990" max="{{ date('Y') }}" />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('graduation_year')" />
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-stone-100">
                <div class="space-y-4">
                    <div>
                        <x-forms.input-label for="cv" :value="__('Update CV (PDF)')" />
                        <input id="cv" name="cv" type="file" class="mt-1 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-stone-50 file:text-stone-700 hover:file:bg-stone-100" accept=".pdf" />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('cv')" />
                    </div>
                    
                    @if($user->riderProfile->document && $user->riderProfile->document->cv_path)
                        <div class="p-3 bg-stone-50 border border-stone-200 rounded-xl">
                            <p class="text-[10px] font-bold text-gray-500 mb-2 uppercase">Preview CV Saat Ini:</p>
                            <iframe src="{{ Storage::url($user->riderProfile->document->cv_path) }}" class="w-full h-40 rounded border border-stone-100 bg-white shadow-inner"></iframe>
                        </div>
                    @endif
                </div>

                <div class="space-y-4">
                    <div>
                        <x-forms.input-label for="photo" :value="__('Update Foto Diri')" />
                        <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-stone-50 file:text-stone-700 hover:file:bg-stone-100" accept="image/*" />
                        <x-forms.input-error class="mt-2" :messages="$errors->get('photo')" />
                    </div>
                    
                    @if($user->riderProfile->document && $user->riderProfile->document->photo_path)
                        <div class="p-3 bg-stone-50 border border-stone-200 rounded-xl flex flex-col items-center">
                            <p class="text-[10px] font-bold text-gray-500 mb-2 uppercase">Foto Saat Ini:</p>
                            <img src="{{ Storage::url($user->riderProfile->document->photo_path) }}" class="h-40 w-40 object-cover rounded-xl shadow-md border border-stone-100 bg-white">
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-buttons.primary-button>{{ __('Simpan') }}</x-buttons.primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

