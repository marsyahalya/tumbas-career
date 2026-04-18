<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rider Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 border-b border-stone-100 flex flex-col md:flex-row items-center gap-10 bg-gradient-to-br from-white to-stone-50">
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-3xl font-black text-gray-900 tracking-tight mb-3">Selamat Datang, Rider!</h3>
                        <p class="text-gray-500 font-medium leading-relaxed max-w-lg">Jadilah bagian dari revolusi kopi keliling di Solo. Kelola pendaftaran Anda dan pantau status kerjasama Anda bersama Tumbas Coffee.</p>
                        
                        <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4">
                            @if(auth()->user()->riderProfile)
                                <a href="{{ route('rider.show') }}" class="inline-flex items-center gap-2 bg-tumbas text-white px-6 py-3 rounded-full font-black text-sm shadow-xl shadow-tumbas/20 hover:bg-tumbas-dark transition-all hover:-translate-y-1 uppercase tracking-wider">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    Cek Status Pendaftaran
                                </a>

                                @if(auth()->user()->riderProfile->auto_employment_status === 'alumni')
                                    <form action="{{ route('rider.reapply') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 bg-orange-500 text-white px-6 py-3 rounded-full font-black text-sm shadow-xl shadow-orange-200 hover:bg-orange-600 transition-all hover:-translate-y-1 uppercase tracking-wider">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Daftar Ulang (Alumni)
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('rider.create') }}" class="inline-flex items-center gap-2 bg-tumbas text-white px-8 py-4 rounded-full font-black shadow-2xl shadow-tumbas/30 hover:bg-tumbas-dark transition-all hover:scale-105 uppercase tracking-widest text-sm">
                                    Mulai Pendaftaran 🚀
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="relative w-full md:w-80 h-64 group">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-tumbas/10 rounded-full blur-2xl animate-pulse"></div>
                        <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-orange-400/10 rounded-full blur-2xl animate-pulse delay-700"></div>
                        
                        <div class="relative w-full h-full bg-white rounded-3xl border border-stone-100 shadow-2xl overflow-hidden p-4 flex items-center justify-center group-hover:shadow-tumbas/5 transition-all duration-500">
                            <img src="{{ asset('images/admin/gerobak.jpg') }}" alt="Gerobak Tumbas" class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-700" onerror="this.onerror=null; this.src='https://placehold.co/400x300?text=Tumbas+Coffee'">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
