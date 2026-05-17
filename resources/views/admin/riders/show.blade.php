<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.riders.index') }}" class="text-gray-400 hover:text-tumbas transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Rider: ') }} {{ $riderProfile->full_name }}
            </h2>
        </div>
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
                                <p><span class="text-gray-500 w-32 inline-block font-medium">Kota</span>: <span class="font-bold text-gray-900">{{ $riderProfile->city ?? '-' }}</span></p>
                                <p><span class="text-gray-500 w-32 inline-block font-medium">Alamat</span>: {{ $riderProfile->address }}</p>
                                <p><span class="text-gray-500 w-32 inline-block font-medium">Area Operasional</span>: <span class="font-bold text-green-600">{{ $riderProfile->selectedArea->name ?? 'Belum ada' }}</span></p>
                            </div>
                        </div>

                        <!-- Pendidikan -->
                        <div>
                            <h4 class="font-bold text-tumbas mb-3 uppercase tracking-wider text-xs">Pendidikan</h4>
                            <div class="space-y-2">
                                <p><span class="text-gray-500 w-32 inline-block font-medium">Jenjang</span>: {{ $riderProfile->education_level ?? '-' }}</p>
                                <p><span class="text-gray-500 w-32 inline-block font-medium">Institusi</span>: {{ $riderProfile->education_institution ?? '-' }}</p>
                                <p><span class="text-gray-500 w-32 inline-block font-medium">Tahun Lulus</span>: {{ $riderProfile->graduation_year ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($riderProfile->employment_status === 'terima')
                    <hr class="my-6 border-stone-100">
                    <div class="bg-tumbas-50 p-4 rounded-xl border border-tumbas-100">
                        <h4 class="font-bold text-tumbas mb-3 uppercase tracking-wider text-xs">Informasi Kontrak & Keanggotaan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mt-2">
                            <p><span class="text-gray-500 w-32 inline-block font-medium">Status Kerja</span>: 
                                <span class="font-bold uppercase {{ $riderProfile->auto_employment_status === 'active' ? 'text-green-600' : 'text-stone-500' }}">
                                    {{ $riderProfile->auto_employment_status === 'active' ? 'Aktif' : ($riderProfile->auto_employment_status === 'alumni' ? 'Alumni' : 'Pending') }}
                                </span>
                            </p>
                            <p><span class="text-gray-500 w-32 inline-block font-medium">Mulai Kontrak</span>: {{ $riderProfile->contract_start_date ? $riderProfile->contract_start_date->format('d M Y') : '-' }}</p>
                            <p><span class="text-gray-500 w-32 inline-block font-medium">Akhir Kontrak</span>: <span class="font-bold">{{ $riderProfile->contract_end_date ? $riderProfile->contract_end_date->format('d M Y') : 'Open Ended' }}</span></p>
                        </div>
                    </div>
                    @elseif($riderProfile->employment_status === 'ditolak')
                    <hr class="my-6 border-stone-100">
                    <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                        <h4 class="font-bold text-red-600 mb-1 uppercase tracking-wider text-xs">Aplikasi Ditolak</h4>
                        <p class="text-sm text-red-700">Rider ini tidak lolos dalam proses seleksi.</p>
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
                                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-tumbas-50 text-tumbas text-[10px] font-black uppercase tracking-widest border border-tumbas-100 shadow-sm">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Sekarang' }}
                                    </div>
                                    @php
                                        $duration = \Carbon\Carbon::parse($exp->start_date)->diffInMonths($exp->end_date ?? now());
                                        $years = floor($duration / 12);
                                        $months = $duration % 12;
                                    @endphp
                                    @if($duration > 0)
                                    <p class="text-[9px] text-gray-400 mt-1 font-bold italic uppercase tracking-tighter">
                                        Durasi: {{ $years > 0 ? $years . ' Thn ' : '' }}{{ $months }} Bln
                                    </p>
                                    @endif
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
            <div class="w-full md:w-1/3 space-y-4" x-data="{ 
                selectedStatus: '{{ old('application_status', $riderProfile->application_status) }}', 
                empStatus: '{{ old('employment_status', $riderProfile->employment_status) }}',
                initialStatus: '{{ $riderProfile->application_status }}',
                contractStartDate: '{{ old('contract_start_date', ($riderProfile->contract_end_date && $riderProfile->contract_end_date->isPast()) ? now()->format('Y-m-d') : ($riderProfile->contract_start_date ? $riderProfile->contract_start_date->format('Y-m-d') : now()->format('Y-m-d'))) }}',
                contractEndDate: '{{ old('contract_end_date', ($riderProfile->contract_end_date && $riderProfile->contract_end_date->isPast()) ? now()->addMonths(3)->format('Y-m-d') : ($riderProfile->contract_end_date ? $riderProfile->contract_end_date->format('Y-m-d') : now()->addMonths(3)->format('Y-m-d'))) }}',
                jsError: '',
                // Structured Interview Fields
                interviewMethod: 'Offline',
                interviewDate: '',
                interviewTime: '',
                interviewLocation: '',
                interviewAdditional: 'Mohon mempersiapkan CV dan berpakaian rapi.',
                candidateName: '{{ $riderProfile->full_name }}',

                get formattedInterviewMessage() {
                    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    
                    let dateStr = '-';
                    if (this.interviewDate) {
                        const [year, month, day] = this.interviewDate.split('-').map(Number);
                        const d = new Date(year, month - 1, day);
                        dateStr = `${days[d.getDay()]}, ${day} ${months[month - 1]} ${year}`;
                    }

                    let locationLabel = this.interviewMethod === 'Offline' ? '📍 Lokasi Wawancara' : '🔗 Link Zoom/Google Meet';
                    
                    return `Kami telah meninjau profil Anda dan sangat tertarik untuk mengenal Anda lebih jauh! Dengan senang hati kami mengundang Anda untuk mengikuti tahap wawancara.\n\n` +
                           `Berikut adalah detail jadwal wawancara Anda:\n` +
                           `📌 Metode: ${this.interviewMethod}\n` +
                           `📅 Tanggal: ${dateStr}\n` +
                           `⏰ Waktu: ${this.interviewTime || '-'} WIB\n` +
                           `${locationLabel}: ${this.interviewLocation || '-'}\n\n` +
                           `Catatan tambahan:\n` +
                           `${this.interviewAdditional || '-'}\n\n` +
                           `Harap konfirmasi kehadiran Anda melalui sistem. Kami tunggu kehadirannya!`;
                }
            }">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 border border-tumbas/10 relative">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-tumbas to-tumbas-400 rounded-t-2xl"></div>
                    <h3 class="text-lg font-bold border-b border-stone-100 pb-2 mb-4">Update Management</h3>
                    


                    <div class="mb-6 flex flex-col items-center justify-center py-4 bg-stone-50 rounded-2xl border border-stone-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Saat Ini</span>
                        <span class="px-4 py-1.5 text-xs font-extrabold rounded-full {{ $riderProfile->auto_employment_status === 'active' ? 'bg-green-600 ring-green-50' : 'bg-tumbas ring-tumbas-50' }} text-white shadow-sm ring-4 uppercase tracking-tighter">{{ $riderProfile->status_label }}</span>
                        
                        @if($riderProfile->application_status === 'wawancara')
                            <div class="mt-4 flex flex-col items-center">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Konfirmasi Kehadiran:</span>
                                @if($riderProfile->effective_attendance === 'hadir')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase tracking-widest border border-green-200">
                                        ✅ Hadir
                                    </span>
                                @elseif($riderProfile->effective_attendance === 'tidak_hadir')
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-full uppercase tracking-widest border border-red-200 mb-2">
                                        ❌ Tidak Hadir
                                    </span>
                                    @if($riderProfile->interview_decline_reason)
                                        <div class="bg-red-50 p-2.5 rounded-xl border border-red-100 w-full text-center mt-1">
                                            <p class="text-[9px] font-black text-red-400 uppercase tracking-widest">Alasan Penolakan</p>
                                            <p class="text-[10px] font-bold text-red-700 leading-tight mb-1">{{ $riderProfile->interview_decline_reason }}</p>
                                            
                                            @if($riderProfile->interview_reschedule_date)
                                                <p class="text-[9px] text-red-600 font-bold bg-white/60 py-1 px-2 rounded mt-1 border border-red-50">
                                                    Usulan Reschedule:<br>
                                                    {{ \Carbon\Carbon::parse($riderProfile->interview_reschedule_date)->format('d F Y') }}
                                                </p>
                                            @endif
                                            
                                            @if($riderProfile->interview_decline_details)
                                                <p class="text-[9px] text-red-600 mt-1.5 italic leading-tight px-1">"{{ $riderProfile->interview_decline_details }}"</p>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <span class="px-3 py-1 bg-stone-100 text-stone-500 text-[10px] font-black rounded-full uppercase tracking-widest border border-stone-200">
                                        ⏳ Belum Respon
                                    </span>
                                @endif

                                @if($riderProfile->interview_attendance_updated_at)
                                    <p class="mt-2 text-[9px] text-gray-400 font-bold uppercase tracking-tighter">
                                        Diperbarui: {{ $riderProfile->interview_attendance_updated_at->format('d/m/Y H:i') }} 
                                        ({{ $riderProfile->interview_attendance_count }}x)
                                    </p>
                                @endif
                            </div>
                        @endif
                        @if($riderProfile->application_status === 'final_approval' && $riderProfile->employment_status === 'terima')
                            @if($riderProfile->auto_employment_status === 'alumni')
                                <span class="mt-2 px-3 py-1 text-[10px] font-bold rounded bg-stone-100 text-stone-500 uppercase tracking-widest">Alumni / Kontrak Habis</span>
                            @else
                                <span class="mt-2 px-3 py-1 text-[10px] font-bold rounded bg-green-100 text-green-800 uppercase tracking-widest">Active Rider</span>
                            @endif
                        @endif

                        {{-- Info Riwayat Kontrak Terakhir (untuk Alumni yang daftar lagi) --}}
                        @if(in_array($riderProfile->application_status, ['submit', 'verifikasi_berkas', 'wawancara']) && $riderProfile->contract_start_date)
                            <div class="mt-4 px-4 py-2 bg-stone-100 border border-stone-200 rounded-lg text-center">
                                <p class="text-[9px] font-bold text-gray-500 uppercase">Riwayat Kontrak:</p>
                                <p class="text-[10px] font-bold text-stone-700">Pernah Aktif: {{ $riderProfile->contract_start_date->format('d M y') }} - {{ $riderProfile->contract_end_date ? $riderProfile->contract_end_date->format('d M y') : 'Selesai' }}</p>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('admin.riders.update-status', $riderProfile->id) }}" method="POST" class="space-y-4"
                          @submit.prevent="
                            jsError = '';
                            if (selectedStatus === 'wawancara' && (!interviewDate || !interviewTime || !interviewLocation)) {
                                jsError = '⚠ Mohon lengkapi data wawancara (Tanggal, Jam, dan Lokasi/Link)!';
                                return;
                            }
                            $el.submit();
                          ">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Ubah Status Rider</label>
                            <select name="application_status" 
                                    x-model="selectedStatus" 
                                    @change="
                                        if (selectedStatus !== initialStatus) { empStatus = '' };
                                        jsError = ''"
                                    class="w-full rounded-xl border-stone-200 text-sm mb-1 focus:ring-tumbas focus:border-tumbas">
                                @foreach($riderProfile::STATUS_LABELS as $key => $label)
                                    <option value="{{ $key }}">{{ $loop->iteration }} - {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Opsi Hasil (Application/Employment Status) -->
                        <div x-show="selectedStatus === 'verifikasi_berkas' || selectedStatus === 'final_approval'" x-transition class="bg-tumbas-50 p-4 rounded-xl border border-tumbas-100">
                             <label class="block text-xs font-bold text-tumbas-800 uppercase mb-2">
                                <span x-show="selectedStatus === 'verifikasi_berkas'">Hasil Verifikasi Data</span>
                                <span x-show="selectedStatus === 'final_approval'">Hasil Persetujuan Akhir</span>
                             </label>

                             <select name="employment_status" x-model="empStatus" class="w-full rounded-xl border-tumbas-200 text-sm">
                                 <option value="">-- Pilih Hasil --</option>
                                 <option value="terima" :selected="empStatus === 'terima'" x-text="selectedStatus === 'verifikasi_berkas' ? 'Data Diterima' : 'Diterima (Lolos Seleksi)'"></option>
                                 <option value="ditolak" :selected="empStatus === 'ditolak'" x-text="selectedStatus === 'verifikasi_berkas' ? 'Data Ditolak' : 'Ditolak'"></option>
                             </select>
                             
                             <!-- Kontrak Dates ONLY FOR Final Approval + Terima -->
                             <div x-show="empStatus === 'terima' && selectedStatus === 'final_approval'" x-transition class="mt-4 space-y-3 pt-3 border-t border-tumbas-200">
                                <div>
                                    <label class="block text-[10px] font-bold text-tumbas-800 uppercase mb-1">Tanggal Kontrak Awal</label>
                                    <input type="date" name="contract_start_date" x-model="contractStartDate" class="w-full rounded-lg border-tumbas-200 text-xs">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-tumbas-800 uppercase mb-1">Tanggal Kontrak Akhir</label>
                                    <input type="date" name="contract_end_date" x-model="contractEndDate" class="w-full rounded-lg border-tumbas-200 text-xs">
                                    <p class="text-[9px] text-tumbas-600 mt-1 italic">*Wajib lebih dari tanggal awal.</p>
                                </div>
                             </div>
                        </div>

                        <!-- Structured Field for Interview -->
                        <div x-show="selectedStatus === 'wawancara'" x-transition class="bg-blue-50 p-4 rounded-xl border border-blue-100 space-y-3">
                            <label class="block text-xs font-bold text-blue-800 uppercase mb-2">Pengaturan Jadwal Wawancara</label>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1">Metode*</label>
                                    <select x-model="interviewMethod" class="w-full rounded-lg border-blue-200 text-xs focus:ring-blue-500 focus:border-blue-500 py-1.5">
                                        <option value="Offline">Offline</option>
                                        <option value="Online">Online</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1">Tanggal*</label>
                                    <input type="date" x-model="interviewDate" class="w-full rounded-lg border-blue-200 text-xs focus:ring-blue-500 focus:border-blue-500 py-1.5">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1">Jam*</label>
                                    <input type="time" x-model="interviewTime" class="w-full rounded-lg border-blue-200 text-xs focus:ring-blue-500 focus:border-blue-500 py-1.5">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1" x-text="interviewMethod === 'Offline' ? 'Lokasi Wawancara*' : 'Link Zoom/GMeet*'"></label>
                                    <input type="text" x-model="interviewLocation" :placeholder="interviewMethod === 'Offline' ? 'Cth: Kantor Tumbas Solo' : 'https://zoom.us/j/...' " class="w-full rounded-lg border-blue-200 text-xs focus:ring-blue-500 focus:border-blue-500 py-1.5">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1">Informasi Tambahan (Optional)</label>
                                <textarea x-model="interviewAdditional" class="w-full rounded-lg border-blue-200 text-xs focus:ring-blue-500 focus:border-blue-500" rows="2" placeholder="Cth: Mohon membawa CV cetak..."></textarea>
                            </div>

                            <div class="pt-2 border-t border-blue-100">
                                <label class="block text-[10px] font-bold text-blue-400 uppercase mb-1 italic">Preview Email:</label>
                                <div class="bg-white/60 p-3 rounded-lg text-[10px] text-gray-600 whitespace-pre-line border border-blue-50 shadow-inner leading-relaxed" x-text="formattedInterviewMessage"></div>
                            </div>

                            <!-- Hidden field that actually gets submitted -->
                            <input type="hidden" name="interview_message" :value="formattedInterviewMessage">
                        </div>

                        <!-- Client-side Error Message (Live) -->
                        <div x-show="jsError" x-transition class="bg-red-50 p-3 rounded-lg border border-red-200">
                            <p class="text-[10px] text-red-700 font-extrabold" x-text="jsError"></p>
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
</x-layouts.app>

