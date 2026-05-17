<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Rider') }}
        </h2>
    </x-slot>

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.5/css/intlTelInput.css">
    
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-rider.registration-form 
                        :action="route('rider.store')" 
                        :areas="$areas" 
                    />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

