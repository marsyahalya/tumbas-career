<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 border-b border-stone-100 flex flex-col md:flex-row items-center gap-10 bg-gradient-to-br from-white to-stone-50">
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-3xl font-black text-gray-900 tracking-tight mb-3">Selamat Datang, Admin!</h3>
                        <p class="text-gray-500 font-medium leading-relaxed max-w-lg">Kelola pendaftaran rider, pantau kontrak aktif, dan optimasikan area operasional Tumbas Coffee Solo melalui panel kendali ini.</p>
                        
                        <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4">
                            <a href="{{ route('admin.areas.index') }}" class="inline-flex items-center gap-2 bg-tumbas text-white px-6 py-3 rounded-full font-black text-sm shadow-xl shadow-tumbas/20 hover:bg-tumbas-dark transition-all hover:-translate-y-1 uppercase tracking-wider">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Manajemen Area
                            </a>
                            <a href="{{ route('admin.riders.index') }}" class="inline-flex items-center gap-2 bg-white border-2 border-stone-100 text-gray-700 px-6 py-3 rounded-full font-black text-sm shadow-sm hover:border-tumbas hover:text-tumbas transition-all hover:-translate-y-1 uppercase tracking-wider">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Manajemen Rider
                            </a>
                        </div>
                    </div>
                    <div class="relative w-full md:w-80 h-64 group">
                        <!-- Decorative Orbs -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-tumbas/10 rounded-full blur-2xl animate-pulse"></div>
                        <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-orange-400/10 rounded-full blur-2xl animate-pulse delay-700"></div>
                        
                        <div class="relative w-full h-full bg-white rounded-3xl border border-stone-100 shadow-2xl overflow-hidden p-4 flex items-center justify-center group-hover:shadow-tumbas/5 transition-all duration-500">
                            <img src="{{ asset('images/admin/gerobak.jpg') }}" alt="Gerobak Tumbas" class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-700" onerror="this.onerror=null; this.src='https://placehold.co/400x300?text=Gerobak+Tumbas'">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
