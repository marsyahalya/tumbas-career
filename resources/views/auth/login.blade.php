<x-layouts.guest title="Masuk">
    <!-- Session Status -->
    <x-ui.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-forms.input-label for="password" :value="__('Kata Sandi')" />

            <x-forms.text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-buttons.primary-button class="ms-3">
                {{ __('Masuk') }}
            </x-buttons.primary-button>
        </div>
    </form>
</x-layouts.guest>


