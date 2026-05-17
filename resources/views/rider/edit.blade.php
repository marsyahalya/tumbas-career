<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pendaftaran Rider') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.5/css/intlTelInput.css">
    
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl text-sm font-bold flex items-center gap-2">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             {{ session('success') }}
                        </div>
                    @endif

                    <x-rider.registration-form 
                        :action="route('rider.update')" 
                        method="PATCH" 
                        :profile="$profile" 
                        :areas="$areas" 
                    />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

