<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rider: ') }} {{ $riderProfile->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Data Detail Rider -->
            <div class="w-full md:w-2/3 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-stone-100">
                    <h3 class="text-lg font-bold border-b pb-2 mb-4">Informasi Lengkap Rider</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <!-- Data Pribadi -->
                        <div>
                            <h4 class="font-bold text-tumbas mb-3 uppercase tracking-wider text-xs">Data Pribadi</h4>
                            <div class="space-y-2">
                                <p><span class="text-gray-500 w-24 inline-block font-medium">Nama</span>: <span class="font-bold text-gray-900">{{ $riderProfile->full_name }}</span></p>
                                <p><span class="text-gray-500 w-24 inline-block font-medium">Email</span>: {{ $riderProfile->user->email ?? '-' }}</p>
                                <p><span class="text-gray-500 w-24 inline-block font-medium">No HP</span>: {{ $riderProfile->phone_number }}</p>
                                <p><span class="text-gray-500 w-24 inline-block font-medium">Kelamin</span>: {{ ucfirst($riderProfile->gender) }}</p>
                                <p><span class="text-gray-500 w-24 inline-block font-medium">Tgl Lahir</span>: {{ \Carbon\Carbon::parse($riderProfile->birth_date)->format('d M Y') }}</p>
                            </div>
                        </div>

                        <!-- Lokasi & Area -->
                        <div>
                            <h4 class="font-bold text-tumbas mb-3 uppercase tracking-wider text-xs">Lokasi & Area</h4>
                            <div class="space-y-2">
                                <p><span class="text-gray-500 w-32 inline-block font-medium">Alamat</span>: {{ $riderProfile->address }}</p>
                                <p><span class="text-gray-500 w-32 inline-block font-medium">Pilihan Area</span>: <span class="font-bold text-green-600">{{ $riderProfile->selectedArea->name ?? 'Belum ada' }}</span></p>
                            </div>
                        </div>
                    </div>

                    @if($riderProfile->status === 'accepted')
                    <hr class="my-6 border-stone-100">
                    <div class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                        <h4 class="font-bold text-tumbas mb-3 uppercase tracking-wider text-xs">Informasi Kontrak & Keanggotaan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mt-2">
                            <p><span class="text-gray-500 w-32 inline-block font-medium">Status Kerja</span>: 
                                <span class="font-bold uppercase {{ $riderProfile->auto_employment_status === 'active' ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $riderProfile->auto_employment_status === 'active' ? 'Aktif' : 'Alumni' }}
                                </span>
                            </p>
                            <p><span class="text-gray-500 w-32 inline-block font-medium">Mulai Kontrak</span>: {{ $riderProfile->contract_start_date ? $riderProfile->contract_start_date->format('d M Y') : '-' }}</p>
                            <p><span class="text-gray-500 w-32 inline-block font-medium">Akhir Kontrak</span>: <span class="font-bold">{{ $riderProfile->contract_end_date ? $riderProfile->contract_end_date->format('d M Y') : 'Open Ended' }}</span></p>
                        </div>
                    </div>
                    @endif

                    <hr class="my-6 border-stone-100">

                    <!-- Pengalaman -->
                    <h4 class="font-black text-gray-900 mb-6 uppercase tracking-[0.2em] text-[10px] flex items-center gap-2">
                        <svg class="w-4 h-4 text-tumbas" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Riwayat Pengalaman ({{ $riderProfile->experiences->count() }})
                    </h4>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @forelse($riderProfile->experiences as $exp)
                        <div class="group relative bg-white border border-stone-100 p-5 rounded-2xl hover:border-tumbas/30 transition-all duration-300 shadow-sm hover:shadow-md overflow-hidden">
                            <!-- Status Indicator -->
                            <div class="absolute top-0 left-0 w-1 h-full bg-stone-100 group-hover:bg-tumbas transition-colors"></div>
                            
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h5 class="font-black text-gray-900 text-base leading-tight">{{ $exp->company_name }}</h5>
                                    </div>
                                    <div class="flex items-center gap-2 text-tumbas font-bold text-xs uppercase tracking-wider">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $exp->position ?? 'Posisi tidak disebutkan' }}
                                    </div>
                                </div>
                                <div class="flex flex-col md:items-end">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-orange-50 text-tumbas text-[10px] font-black uppercase tracking-widest border border-orange-100 shadow-sm">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Sekarang' }}
                                    </div>
                                    @php
                                        $duration = \Carbon\Carbon::parse($exp->start_date)->diffInMonths($exp->end_date ?? now());
                                        $years = floor($duration / 12);
                                        $months = $duration % 12;
                                    @endphp
                                    <p class="text-[9px] text-gray-400 mt-1 font-bold italic uppercase tracking-tighter">
                                        Durasi: {{ $years > 0 ? $years . ' Thn ' : '' }}{{ $months }} Bln
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10 bg-stone-50 rounded-2xl border border-dashed border-stone-200">
                            <p class="text-sm text-gray-400 font-medium italic">Data pengalaman kerja masih kosong.</p>
                        </div>
                        @endforelse
                    </div>

                    <hr class="my-6 border-stone-100">

                    <!-- Dokumen -->
                    <h4 class="font-bold text-tumbas mb-3 uppercase tracking-wider text-xs">Dokumen Terlampir</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if($riderProfile->document)
                            @if($riderProfile->document->cv_path)
                            <div class="border border-stone-200 p-4 rounded-xl flex flex-col justify-center items-center h-44 bg-gray-50 hover:bg-white transition shadow-sm">
                                <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Curriculum Vitae (CV)</p>
                                <a href="{{ route('admin.riders.download-cv', $riderProfile) }}" target="_blank" class="bg-tumbas hover:bg-tumbas-dark text-white text-[10px] font-black px-4 py-2 rounded-full transition shadow-md uppercase tracking-wider">
                                    🔍 Download CV (PDF)
                                </a>
                                @if(session('error'))
                                    <p class="text-[10px] text-red-500 mt-2">{{ session('error') }}</p>
                                @endif
                            </div>
                            @else
                            <div class="border border-stone-100 p-2 rounded-xl text-center text-sm text-gray-400 py-6">CV Tidak Ada</div>
                            @endif

                            @if($riderProfile->document->photo_path)
                            <div class="border border-stone-200 p-4 rounded-xl flex flex-col items-center shadow-sm">
                                <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Pas Foto</p>
                                <img src="{{ Storage::url($riderProfile->document->photo_path) }}" class="h-32 w-32 object-cover bg-stone-100 rounded-2xl shadow-inner border border-stone-200">
                            </div>
                            @else
                            <div class="border border-stone-100 p-2 rounded-xl text-center text-sm text-gray-400 py-6">Foto Tidak Ada</div>
                            @endif
                        @else
                            <div class="col-span-2 text-sm text-gray-400 italic">Dokumen belum diupload.</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Panel Akses & Status Admin -->
            <div class="w-full md:w-1/3 space-y-4" x-data="{ selectedStatus: '{{ $riderProfile->application_status }}' }">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 border border-tumbas/10 relative">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-tumbas to-orange-400 rounded-t-2xl"></div>
                    <h3 class="text-lg font-bold border-b border-stone-100 pb-2 mb-4">Update Management</h3>
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 p-3 text-sm rounded-xl font-bold flex items-center gap-2">
                             <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                             {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-6 flex flex-col items-center justify-center py-4 bg-stone-50 rounded-2xl border border-stone-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Saat Ini</span>
                        <span class="px-4 py-1.5 text-xs font-extrabold rounded-full bg-tumbas text-white shadow-sm ring-4 ring-orange-50 uppercase tracking-tighter">{{ $riderProfile->status_label }}</span>
                        @if($riderProfile->application_status === 'accepted')
                            <span class="mt-2 px-3 py-1 text-[10px] font-bold rounded bg-green-100 text-green-800 uppercase tracking-widest">{{ $riderProfile->auto_employment_status }}</span>
                        @endif
                    </div>

                    <form action="{{ route('admin.riders.update-status', $riderProfile->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Ubah Status Rider</label>
                            <select name="application_status" x-model="selectedStatus" class="w-full rounded-xl border-stone-200 text-sm mb-1 focus:ring-tumbas focus:border-tumbas" {{ $riderProfile->application_status === 'accepted' ? 'disabled' : '' }}>
                                @foreach($riderProfile::STATUS_LABELS as $key => $label)
                                    <option value="{{ $key }}">{{ $loop->iteration }} - {{ $label }}</option>
                                @endforeach
                            </select>
                            @if($riderProfile->application_status === 'accepted')
                                <input type="hidden" name="application_status" value="accepted">
                                <p class="text-[9px] text-gray-400 mt-1 italic font-medium">*Status diterima tidak dapat diubah kembali.</p>
                            @endif
                        </div>

                        <!-- Special Field for Interview -->
                        <div x-show="selectedStatus === 'interview'" x-transition class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <label class="block text-xs font-bold text-blue-800 uppercase mb-2">Pesan Interview (Link Zoom/WA)</label>
                            <textarea name="interview_message" class="w-full rounded-xl border-blue-200 text-sm focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Contoh: Interview jam 10 pagi via Zoom: [Link Zoom Here] atau Hubungi WA: 0812...">{{ $riderProfile->interview_message }}</textarea>
                            <p class="text-[10px] text-blue-600 mt-1 font-medium italic">*Input ini akan terlihat langsung di Dashboard Rider.</p>
                        </div>

                        <!-- Fields for Accepted status (Contract Management) -->
                        <div x-show="selectedStatus === 'accepted'" x-transition class="space-y-4 bg-green-50 p-4 rounded-xl border border-green-100">
                             <div>
                                <label class="block text-xs font-bold text-green-800 uppercase mb-2">Batas Akhir Kontrak</label>
                                <input type="date" name="contract_end_date" value="{{ $riderProfile->contract_end_date ? $riderProfile->contract_end_date->format('Y-m-d') : '' }}" class="w-full rounded-xl border-green-200 text-sm">
                                <p class="text-[10px] text-green-600 mt-1 font-medium italic">Kosongkan jika kontrak terbuka. Jika tanggal lewat, status otomatis Alumni.</p>
                             </div>
                        </div>



                        <button class="w-full bg-tumbas text-white font-extrabold py-3 px-4 rounded-xl hover:bg-tumbas-dark shadow-xl shadow-tumbas/20 transition-all hover:-translate-y-1">Simpan Perubahan</button>
                    </form>
                </div>

                <div class="bg-stone-50 p-4 rounded-2xl border border-stone-200 text-[10px] text-gray-400 text-center uppercase tracking-widest font-bold">
                    Admin Access • Tumbas Group (Solo)
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
