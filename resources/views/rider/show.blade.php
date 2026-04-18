<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Progres Pendaftaran Rider') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-stone-100 relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-tumbas to-orange-400"></div>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 text-green-700 border border-green-200 p-4 rounded-xl text-sm font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 leading-tight">Halo, {{ $profile->full_name }}!</h3>
                        <p class="text-gray-500 font-medium mt-1">Status Anda saat ini: <span class="text-tumbas font-bold uppercase">{{ str_replace('_', ' ', $profile->application_status) }}</span></p>
                    </div>
                    @if($profile->application_status === 'accepted')
                        <div class="flex items-center gap-4 bg-stone-50 px-6 py-3 rounded-2xl border border-stone-100 shadow-sm">
                             <div class="text-center">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Status Kontrak</p>
                                <p class="text-sm font-extrabold text-green-600 uppercase">{{ $profile->auto_employment_status }}</p>
                             </div>
                             <div class="w-px h-8 bg-stone-200"></div>
                             <div class="text-center">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Berakhir</p>
                                <p class="text-sm font-extrabold text-gray-800">{{ $profile->contract_end_date ? $profile->contract_end_date->format('d/m/y') : 'Penuh' }}</p>
                             </div>
                        </div>
                    @endif
                </div>

                @php
                    $stages = [
                        'submitted' => 'Pendaftaran Diterima',
                        'document_verification' => 'Verifikasi Dokumen',
                        'interview' => 'Wawancara',
                        'final_approval' => 'Final Approval'
                    ];
                    $currentStatus = $profile->application_status;
                    $isRejected = $currentStatus === 'rejected';
                    $isAccepted = $currentStatus === 'accepted';
                    
                    $statusKeys = array_keys($stages);
                    $currentIndex = array_search($currentStatus, $statusKeys);
                    
                    if ($isAccepted || $isRejected) {
                        $currentIndex = 4;
                    }
                @endphp

                <!-- Stepper UI -->
                <div class="relative ml-4 border-l-2 border-stone-100">
                    
                    @foreach($stages as $key => $label)
                        @php
                            $i = $loop->index;
                            $isCompleted = $currentIndex > $i || $isAccepted || ($isRejected && $currentIndex > $i);
                            $isActive = $currentIndex === $i && !$isRejected;
                        @endphp
                        <div class="mb-10 ml-8 relative group">
                            <!-- Circle Marker -->
                            <span class="absolute -left-11 flex items-center justify-center w-6 h-6 rounded-full -ml-px transition-all duration-300
                                {{ $isCompleted ? 'bg-green-500 shadow-lg shadow-green-100' : ($isActive ? 'bg-tumbas ring-8 ring-orange-50 shadow-lg shadow-tumbas/20' : 'bg-stone-200') }}
                            ">
                                @if($isCompleted)
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                <span class="w-1.5 h-1.5 rounded-full bg-white {{ $isActive ? 'scale-125' : '' }}"></span>
                                @endif
                            </span>
                            
                            <h4 class="font-extrabold transition-colors duration-300 uppercase tracking-tight text-sm {{ $isActive ? 'text-tumbas' : ($isCompleted ? 'text-green-600' : 'text-stone-300') }}">
                                {{ $label }}
                            </h4>
                            
                            <div class="mt-2">
                                @if($isActive && $key === 'interview' && $profile->interview_message)
                                    <div class="p-4 bg-tumbas/5 border border-tumbas/10 rounded-xl text-sm mb-2 shadow-sm">
                                        <p class="font-bold text-tumbas mb-1">📢 Pesan Interview:</p>
                                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $profile->interview_message }}</p>
                                    </div>
                                @endif

                                <p class="text-xs font-semibold {{ $isActive ? 'text-gray-600' : 'text-stone-300' }}">
                                    @if($i === 0) Data formulir Anda berhasil kami amankan di sistem Tumbas. @endif
                                    @if($i === 1) Tim rekrutmen kami sedang meninjau kelengkapan CV & Foto diri Anda. @endif
                                    @if($i === 2) Selamat! Anda terpilih untuk tahap wawancara. Cek pesan di atas. @endif
                                    @if($i === 3) Dokumen & hasil interview Anda sedang dalam tahap persetujuan akhir. @endif
                                </p>
                            </div>
                        </div>
                    @endforeach

                    <!-- Result Stage -->
                    <div class="ml-8 relative">
                        <span class="absolute -left-11 flex items-center justify-center w-6 h-6 rounded-full -ml-px
                            {{ $isAccepted ? 'bg-green-600 ring-8 ring-green-50 shadow-lg' : ($isRejected ? 'bg-red-600 ring-8 ring-red-50 shadow-lg' : 'bg-stone-200') }}
                        ">
                            <span class="w-2 h-2 rounded-full bg-white"></span>
                        </span>
                        
                        <h4 class="font-black uppercase tracking-tight text-sm {{ $isAccepted ? 'text-green-600' : ($isRejected ? 'text-red-600' : 'text-stone-300') }}">
                            Hasil Akhir Pendaftaran
                        </h4>
                        
                        @if($isAccepted)
                             <div class="mt-6 p-6 bg-white border border-stone-100 rounded-2xl shadow-sm">
                                <p class="text-sm text-gray-700 font-bold mb-4">🎉 Selamat! Anda telah resmi menjadi bagian dari keluarga Tumbas Coffee. Silakan hubungi supervisor untuk mulai bertugas:</p>
                                <a href="https://wa.me/6283512345678?text=Halo%20Mas%20Arya,%20saya%20Rider%20baru%20Tumbas%20Coffee%20siap%20untuk%20bertugas." target="_blank" class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl transition-all font-black text-sm shadow-lg shadow-green-100 group">
                                    <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.432 L.057 24l6.305-1.654a11.802 11.802 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    <span>WhatsApp Arya (0835-1234-5678)</span>
                                </a>
                            </div>
                        @elseif($isRejected)
                            <div class="mt-4 p-5 bg-red-50 border border-red-200 rounded-2xl">
                                <p class="text-sm text-red-800 font-bold italic">Mohon maaf, pendaftaran Anda belum dapat kami proses lebih lanjut untuk saat ini. Tetap semangat!</p>
                            </div>
                        @else
                            <p class="text-xs font-bold text-stone-300 mt-2 italic">Status keputusan final belum diterbitkan.</p>
                        @endif
                    </div>
                </div>

                <hr class="my-10 border-stone-100">
                
                <h4 class="font-black text-gray-900 mb-6 uppercase tracking-wider text-xs">Rekap Data Pendaftaran</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm bg-stone-50 p-8 rounded-3xl border border-stone-100 mb-8">
                    <!-- Kolom 1: Informasi Pribadi -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-[0.2em] mb-1">Informasi Pribadi</p>
                            <div class="space-y-2 text-gray-800">
                                <p><span class="text-gray-400 font-medium inline-block w-24">Nama</span> <span class="font-bold">: {{ $profile->full_name }}</span></p>
                                <p><span class="text-gray-400 font-medium inline-block w-24">No. HP</span> <span class="font-bold">: {{ $profile->phone_number }}</span></p>
                                <p><span class="text-gray-400 font-medium inline-block w-24">Gender</span> <span class="font-bold">: {{ $profile->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</span></p>
                                <p><span class="text-gray-400 font-medium inline-block w-24">Tgl Lahir</span> <span class="font-bold">: {{ $profile->birth_date ? $profile->birth_date->format('d M Y') : '-' }}</span></p>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-stone-200">
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-[0.2em] mb-2">Dokumen Terlampir</p>
                            <div class="flex gap-3">
                                @if($profile->document?->cv_path)
                                    <a href="{{ Storage::url($profile->document->cv_path) }}" target="_blank" class="px-3 py-1.5 bg-white border border-stone-200 rounded-lg text-[10px] font-black text-tumbas hover:bg-tumbas hover:text-white transition shadow-sm uppercase tracking-tighter">📄 Lihat CV PDF</a>
                                @endif
                                @if($profile->document?->photo_path)
                                    <a href="{{ Storage::url($profile->document->photo_path) }}" target="_blank" class="px-3 py-1.5 bg-white border border-stone-200 rounded-lg text-[10px] font-black text-tumbas hover:bg-tumbas hover:text-white transition shadow-sm uppercase tracking-tighter">📸 Lihat Foto</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 2: Lokasi & Area -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-[0.2em] mb-1">Lokasi Domisili</p>
                            <div class="space-y-2 text-gray-800">
                                <p><span class="text-gray-400 font-medium inline-block w-24">Kota</span> <span class="font-bold">: {{ $profile->city ?? '-' }}</span></p>
                                <p><span class="text-gray-400 font-medium inline-block w-24">Alamat</span> <span class="font-bold">: {{ $profile->address }}</span></p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-stone-200">
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-[0.2em] mb-1">Area Operasional</p>
                            <div class="p-4 bg-white border border-stone-200 rounded-xl">
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Pilihan Area:</p>
                                <p class="font-black text-tumbas text-base tracking-tight">{{ $profile->selectedArea->name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h5 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Daftar Pengalaman Kerja</h5>
                    <div class="space-y-3">
                        @forelse($profile->experiences as $exp)
                            <div class="flex items-center justify-between p-4 bg-white border border-stone-100 rounded-2xl shadow-sm hover:border-tumbas/20 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-stone-50 flex items-center justify-center text-tumbas border border-stone-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-black text-gray-900 leading-tight">{{ $exp->company_name }}</p>
                                        <p class="text-[10px] text-tumbas font-extrabold uppercase tracking-widest">{{ $exp->position ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="text-[10px] font-black text-gray-400 bg-stone-50 px-3 py-1.5 rounded-full border border-stone-100 uppercase tracking-tighter">
                                    {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Sekarang' }}
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 italic">Tidak ada pengalaman yang tercatat.</p>
                        @endforelse
                    </div>
                </div>

            </div>
            
            <p class="text-center mt-8 text-[10px] font-black text-stone-300 uppercase tracking-[0.3em]">Tumbas Coffee Rider Portal</p>
        </div>
    </div>
</x-app-layout>
