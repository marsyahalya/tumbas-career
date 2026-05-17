<x-layouts.app title="Beranda Rider">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beranda Rider') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-stone-100">
                <div class="p-8 md:p-12 text-gray-900 flex flex-col md:flex-row items-center gap-12">
                    <div class="flex-1">
                        <h3 class="text-3xl font-black text-gray-900 tracking-tight mb-4">Selamat Datang, Rider!</h3>
                        <p class="text-gray-500 font-medium leading-relaxed max-w-lg mb-10">Jadilah bagian dari revolusi kopi keliling di Solo bersama Tumbas Coffee. Pantau status pendaftaran dan kelola informasi Anda di sini.</p>
                        
                        <div class="space-y-8 mb-10">
                            <!-- Kriteria -->
                            <div class="space-y-4">
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-3">
                                    <svg class="w-5 h-5 text-tumbas" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Kriteria Bergabung
                                </h4>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3">
                                    @foreach([
                                        'Pria/Wanita, Jujur & Bertanggung Jawab',
                                        'Semangat tinggi, Sopan & Ramah',
                                        'Mampu mengendarai motor listrik',
                                        'Domisili wilayah Surakarta'
                                    ] as $item)
                                        <li class="text-sm text-gray-600 font-bold block mb-1">
                                            {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Benefit - Now Below Kriteria -->
                            <div class="space-y-4">
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-3">
                                    <svg class="w-5 h-5 text-tumbas-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Benefit Rider
                                </h4>
                                <div class="flex flex-wrap gap-3">
                                    @foreach(['Gaji Pokok', 'Uang Makan', 'Bonus Penjualan', 'Motor Listrik'] as $label)
                                        <div class="bg-stone-50 px-4 py-2 rounded-full border border-stone-100 shadow-sm">
                                            <p class="text-[10px] font-black text-gray-700 uppercase tracking-tight">{{ $label }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4 pt-4">
                            @if(auth()->user()->riderProfile)
                                <a href="{{ route('rider.show') }}" class="inline-flex items-center gap-3 bg-tumbas text-white px-8 py-4 rounded-full font-black text-xs shadow-xl shadow-tumbas/20 hover:bg-tumbas-dark transition-all hover:-translate-y-1 uppercase tracking-widest">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    Cek Status Pendaftaran
                                </a>

                                @php
                                    $profile = auth()->user()->riderProfile;
                                    $isAlumni = $profile->auto_employment_status === 'alumni';
                                    $isRejected = $profile->employment_status === 'ditolak';
                                    $isReapplying = $profile->employment_status === 'reapplying';
                                @endphp

                                @if($isAlumni || $isRejected || $isReapplying)
                                    <form action="{{ route('rider.reapply') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-3 bg-white border-2 border-tumbas text-tumbas-dark px-8 py-3.5 rounded-full font-black text-xs hover:bg-red-50 transition-all hover:-translate-y-1 uppercase tracking-widest">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Daftar Kembali
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('rider.create') }}" class="inline-flex items-center gap-3 bg-stone-900 text-white px-10 py-5 rounded-full font-black shadow-xl hover:bg-stone-800 transition-all hover:-translate-y-1 uppercase tracking-[0.2em] text-xs">
                                    <svg class="w-5 h-5 text-tumbas" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Mulai Pendaftaran
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Side Image - Straightened -->
                    <div class="relative w-full md:w-80 h-80 hidden md:block group">
                        <div class="absolute inset-0 bg-stone-50 rounded-[3rem] border border-stone-100"></div>
                        <div class="relative w-full h-full bg-white rounded-[3rem] border border-stone-200 shadow-xl overflow-hidden p-8 flex items-center justify-center transition-transform duration-500 group-hover:scale-105">
                            <img src="{{ asset('images/admin/gerobak.jpg') }}" alt="Tumbas Coffee" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='https://placehold.co/400x300?text=Tumbas'">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

