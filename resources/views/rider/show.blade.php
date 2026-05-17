<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Progres Pendaftaran Rider') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 md:p-12 border border-stone-100 relative">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-tumbas to-tumbas-400"></div>

                <!-- Session Flash Message -->

                
                <!-- Header: Top Left (Info) | Top Right (Area & Button) -->
                <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-16">
                    <!-- Left: Nama, Status, Masa Kontrak -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight leading-tight">Halo, {{ $profile->full_name }}!</h3>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Status Anda: {{ $profile->status_label }}</p>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="px-4 py-1.5 bg-tumbas text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-tumbas/20">
                                {{ $profile->status_label }}
                            </span>
                            
                            @if($profile->application_status === 'final_approval' && $profile->employment_status === 'terima')
                                <div class="flex items-center gap-2 text-xs font-bold text-gray-500 bg-stone-50 px-4 py-1.5 rounded-full border border-stone-100">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Masa Kontrak: {{ $profile->contract_start_date ? $profile->contract_start_date->format('d/m/Y') : '-' }} - {{ $profile->contract_end_date ? $profile->contract_end_date->format('d/m/Y') : 'Selesai' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Area Card & Reapply Button -->
                    <div class="flex flex-col items-end gap-4 w-full md:w-auto">
                        <div class="w-full md:w-64 flex items-center gap-4 py-3 px-5 bg-red-50 border border-red-100 rounded-2xl shadow-sm">
                            <svg class="w-6 h-6 text-tumbas" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <div>
                                <p class="text-[9px] text-red-400 uppercase tracking-widest leading-none mb-1">Area Operasional Pilihan</p>
                                <p class="text-base font-black text-gray-900">{{ $profile->selectedArea->name ?? '-' }}</p>
                            </div>
                        </div>

                        @php
                            $isAlumni = $profile->auto_employment_status === 'alumni';
                            $isRejected = $profile->employment_status === 'ditolak';
                            $isReapplying = $profile->employment_status === 'reapplying';
                        @endphp

                        @if($isAlumni || $isRejected || $isReapplying)
                            <form action="{{ route('rider.reapply') }}" method="POST" onsubmit="return confirm('Apakah Anda ingin mendaftar kembali sebagai rider?')">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 bg-tumbas hover:bg-tumbas-dark text-white text-[10px] font-black px-6 py-2.5 rounded-full shadow-md transition-all hover:-translate-y-0.5 uppercase tracking-widest leading-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Daftar Kembali
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Status Stepper -->
                @php
                    $stages = [
                        'submit' => 'Pendaftaran Terkirim',
                        'verifikasi_berkas' => 'Verifikasi Data',
                        'wawancara' => 'Tahap Wawancara',
                        'final_approval' => 'Persetujuan Akhir'
                    ];
                    $currentStatus = $profile->application_status;
                    $isRejected = $profile->employment_status === 'ditolak';
                    $isAccepted = $profile->application_status === 'final_approval' && $profile->employment_status === 'terima';
                    $statusKeys = array_keys($stages);
                    $currentIndex = array_search($currentStatus, $statusKeys);
                @endphp

                <div class="relative ml-5 border-l-2 border-stone-100 pl-10 space-y-12 mb-16">
                    @foreach($stages as $key => $label)
                        @php
                            $i = $loop->index;
                            $isActive = ($currentIndex === $i && !$isRejected) || ($isAccepted && $i === 3);
                            $isDone = ($currentIndex > $i) || ($isAccepted && $i < 4);
                            $isFail = $isRejected && $currentIndex === $i;
                        @endphp
                        
                        <div class="relative">
                            <!-- Indicator Circle -->
                            <div class="absolute -left-[3.1rem] flex items-center justify-center w-8 h-8 rounded-full border-4 border-white shadow-sm transition-all duration-500
                                {{ $isDone ? 'bg-green-500' : ($isActive ? 'bg-tumbas ring-4 ring-tumbas-100' : ($isFail ? 'bg-red-500' : 'bg-stone-200')) }}
                            ">
                                @if($isDone)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @elseif($isFail)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-white opacity-40"></div>
                                @endif
                            </div>

                            <div class="flex flex-col gap-1">
                                <h4 class="text-sm font-black uppercase tracking-widest {{ $isActive ? 'text-gray-900' : ($isDone ? 'text-green-600' : ($isFail ? 'text-red-500' : 'text-gray-300')) }}">
                                    {{ $label }}
                                </h4>
                                
                                <div class="w-full pr-4 md:pr-12">
                                    @if($key === 'final_approval' && ($isAccepted || $isRejected))
                                        <div class="mt-4">
                                            @if($isAccepted)
                                                <div class="p-6 bg-white border border-stone-100 rounded-2xl shadow-sm">
                                                    <p class="text-sm text-gray-700 font-bold mb-4">Selamat! Anda telah resmi menjadi bagian dari keluarga Tumbas Coffee. Silakan hubungi supervisor area untuk pembagian unit:</p>
                                                    <a href="https://wa.me/6283512345678?text=Halo%20Mas%20Arya,%20saya%20Rider%20baru%20Tumbas%20Coffee%20siap%20untuk%20bertugas." target="_blank" class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl transition-all font-black text-sm shadow-lg shadow-green-100 group uppercase tracking-widest text-[10px]">
                                                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.432 L.057 24l6.305-1.654a11.802 11.802 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                        <span>Konfirmasi Supervisor</span>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="bg-red-50 p-5 rounded-2xl border border-red-100 text-xs font-bold text-red-800 italic leading-relaxed">
                                                    Mohon maaf, pendaftaran Anda belum memenuhi kriteria kami untuk saat ini. Anda dapat mencoba mendaftar kembali dengan memperbarui informasi data Anda. Tetap semangat Rider!
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-xs font-bold leading-relaxed {{ $isActive ? 'text-gray-500' : 'text-gray-300' }}">
                                            @if($i === 0) 
                                                @if($isDone) 
                                                    Data formulir Anda telah resmi terdaftar di sistem.
                                                @elseif($profile->employment_status === 'reapplying')
                                                    <span class="text-tumbas font-bold">Sedang memperbarui data pendaftaran ulang...</span>
                                                @else
                                                    Data formulir pendaftaran Anda telah kami terima.
                                                @endif
                                            @endif
                                            @if($i === 1) 
                                                @if($isFail) 
                                                    <span class="text-gray-500 font-bold italic">Mohon maaf, data pendaftaran Anda ditolak.</span>
                                                @elseif($isDone || ($isActive && $profile->employment_status === 'terima'))
                                                    <span class="text-gray-500 font-bold">Terima kasih, data pendaftaran Anda telah berhasil diverifikasi dan diterima. Silahkan tunggu informasi tahap wawancara secara berkala.</span>
                                                @else
                                                    Tim rekrutmen kami sedang meninjau dokumen resmi Tumbas Coffee Anda.
                                                @endif
                                            @endif
                                            @if($i === 2) 
                                                @if($isDone) 
                                                    <span class="text-gray-500 font-bold">Tahap wawancara telah selesai dilaksanakan.</span>
                                                @elseif($isActive && $profile->interview_message)
                                                    <div class="mt-4">
                                                        <div class="bg-tumbas-50 border border-tumbas-100 p-6 rounded-3xl shadow-sm space-y-3">
                                                            <div class="flex items-center gap-2 text-tumbas">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.068-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                                                <span class="font-black text-[10px] uppercase tracking-widest">Pesan Interview:</span>
                                                            </div>
                                                            <div class="text-[11px] font-bold text-gray-700 leading-relaxed whitespace-pre-line">{{ $profile->interview_message }}</div>
                                                        </div>

                                                        <div class="mt-6 flex flex-col gap-4" x-data="{ showDeclineForm: false, declineReason: '' }">
                                                            <div class="flex justify-between items-end">
                                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Konfirmasi Kehadiran Wawancara:</p>
                                                                <p class="text-[9px] font-bold text-tumbas-400 uppercase tracking-tighter">Sisa Kesempatan: {{ max(0, 3 - $profile->interview_attendance_count) }}x</p>
                                                            </div>
                                                            <div class="flex flex-wrap gap-4" x-show="!showDeclineForm">
                                                                <form action="{{ route('rider.interview.attendance') }}" method="POST" class="inline">
                                                                    @csrf
                                                                    <input type="hidden" name="attendance" value="hadir">
                                                                    <button type="submit" 
                                                                        {{ $profile->interview_attendance_count >= 3 ? 'disabled' : '' }}
                                                                        class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ $profile->effective_attendance === 'hadir' ? 'bg-green-500 text-white shadow-lg shadow-green-100' : 'bg-white border-2 border-green-500 text-green-600 hover:bg-green-50' }} {{ $profile->interview_attendance_count >= 3 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                                        Hadir
                                                                    </button>
                                                                </form>
                                                                <button type="button" @click="showDeclineForm = true"
                                                                    {{ $profile->interview_attendance_count >= 3 ? 'disabled' : '' }}
                                                                    class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ $profile->effective_attendance === 'tidak_hadir' ? 'bg-red-500 text-white shadow-lg shadow-red-100' : 'bg-white border-2 border-red-500 text-red-600 hover:bg-red-50' }} {{ $profile->interview_attendance_count >= 3 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                                    Tidak Hadir
                                                                </button>
                                                            </div>

                                                            <div x-show="showDeclineForm" style="display: none;" x-transition class="bg-red-50 p-5 rounded-2xl border border-red-100 mt-2">
                                                                <form action="{{ route('rider.interview.attendance') }}" method="POST" class="space-y-4">
                                                                    @csrf
                                                                    <input type="hidden" name="attendance" value="tidak_hadir">
                                                                    
                                                                    <div>
                                                                        <label class="block text-[10px] font-black text-red-800 uppercase mb-2">Alasan Tidak Hadir*</label>
                                                                        <select name="decline_reason" x-model="declineReason" required class="w-full text-xs rounded-xl border-red-200 text-red-700 bg-white focus:ring-red-500 focus:border-red-500 py-2">
                                                                            <option value="">-- Pilih Alasan --</option>
                                                                            <option value="Perubahan Jadwal">Minta Perubahan Jadwal (Reschedule)</option>
                                                                            <option value="Kepentingan Pribadi">Kepentingan Pribadi / Keluarga</option>
                                                                            <option value="Sudah Diterima Kerja Lain">Sudah Diterima Kerja di Tempat Lain</option>
                                                                            <option value="Lainnya">Alasan Lainnya</option>
                                                                        </select>
                                                                    </div>

                                                                    <div x-show="declineReason === 'Perubahan Jadwal'" style="display: none;" x-transition>
                                                                        <label class="block text-[10px] font-black text-red-800 uppercase mb-2">Usulan Tanggal Pengganti*</label>
                                                                        <input type="date" name="reschedule_date" :required="declineReason === 'Perubahan Jadwal'" class="w-full text-xs rounded-xl border-red-200 text-red-700 bg-white focus:ring-red-500 focus:border-red-500 py-2">
                                                                    </div>

                                                                    <div x-show="declineReason && declineReason !== 'Perubahan Jadwal'" style="display: none;" x-transition>
                                                                        <label class="block text-[10px] font-black text-red-800 uppercase mb-2">Detail Keterangan</label>
                                                                        <textarea name="decline_details" rows="2" class="w-full text-xs rounded-xl border-red-200 text-red-700 bg-white focus:ring-red-500 focus:border-red-500 py-2" placeholder="Tuliskan alasan Anda secara detail di sini..."></textarea>
                                                                    </div>

                                                                    <div class="flex justify-end gap-3 pt-2">
                                                                        <button type="button" @click="showDeclineForm = false; declineReason = ''" class="px-5 py-2 rounded-full text-xs font-bold text-red-500 hover:bg-red-100 transition-colors">Batal</button>
                                                                        <button type="submit" class="px-5 py-2 rounded-full text-[10px] font-black uppercase text-white bg-red-600 hover:bg-red-700 shadow-lg shadow-red-200 transition-transform hover:-translate-y-0.5">Kirim Konfirmasi</button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            @if($profile->effective_attendance === 'tidak_hadir' && $profile->interview_decline_reason)
                                                                <div class="mt-2 p-4 bg-red-50 border border-red-100 rounded-2xl">
                                                                    <p class="text-[9px] font-bold text-red-400 uppercase tracking-widest mb-1">Informasi Penolakan Anda:</p>
                                                                    <p class="text-xs font-black text-red-700 mb-2">{{ $profile->interview_decline_reason }}</p>
                                                                    @if($profile->interview_reschedule_date)
                                                                        <p class="text-[10px] text-red-600 mb-1"><span class="font-bold opacity-75">Usulan Jadwal Baru:</span> {{ \Carbon\Carbon::parse($profile->interview_reschedule_date)->format('d F Y') }}</p>
                                                                    @endif
                                                                    @if($profile->interview_decline_details)
                                                                        <p class="text-[10px] text-red-600 italic bg-white/50 p-2 rounded-lg mt-2">"{{ $profile->interview_decline_details }}"</p>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                            @if($profile->interview_attendance_count >= 3)
                                                                <p class="text-[9px] text-red-500 font-bold italic mt-2">*Anda telah mencapai batas maksimal perubahan (3x).</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    Undangan wawancara tatap muka atau daring akan segera dikirim.
                                                @endif
                                            @endif
                                            @if($i === 3) 
                                                @if($isAccepted) Keputusan akhir: Diterima sebagai Rider. @elseif($isRejected) Mohon maaf, pendaftaran Anda belum berhasil. @else Menunggu keputusan final hak kemitraan Rider. @endif
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Recap Informasi -->
                <div class="bg-stone-50 p-8 rounded-3xl border border-stone-100 mb-8">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6 border-b border-stone-200 pb-2">Recap Informasi</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-16">
                        <!-- Left COLUMN: Identity Details -->
                        <div class="space-y-4 text-xs font-bold text-gray-700">
                            <div class="px-2 space-y-3">
                                <p class="flex justify-between border-b border-stone-100 pb-2"><span class="text-gray-400 font-medium">Nama Lengkap</span> <span>{{ $profile->full_name }}</span></p>
                                <p class="flex justify-between border-b border-stone-100 pb-2"><span class="text-gray-400 font-medium">Nomor WhatsApp</span> <span>{{ $profile->phone_number }}</span></p>
                                <p class="flex justify-between border-b border-stone-100 pb-2"><span class="text-gray-400 font-medium">Jenis Kelamin</span> <span>{{ $profile->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</span></p>
                                <p class="flex justify-between border-b border-stone-100 pb-2"><span class="text-gray-400 font-medium">Tanggal Lahir</span> <span>{{ $profile->birth_date ? $profile->birth_date->format('d M Y') : '-' }}</span></p>
                                <p class="flex justify-between border-b border-stone-100 pb-2"><span class="text-gray-400 font-medium">Pendidikan Terakhir</span> <span>{{ $profile->education_level }} - {{ $profile->education_institution }}</span></p>
                                <div class="flex justify-between gap-4 py-2">
                                    <span class="text-gray-400 font-medium shrink-0">Alamat Lengkap</span>
                                    <span class="text-right leading-relaxed">{{ $profile->address }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right COLUMN: Experiences & Documents -->
                        <div class="space-y-8 text-xs font-bold text-gray-700">
                            <!-- Experience List -->
                            <div class="px-2">
                                <p class="text-[9px] text-gray-400 uppercase tracking-widest mb-4 font-medium">Daftar Pengalaman Kerja</p>
                                <div class="space-y-3">
                                    @forelse($profile->experiences as $exp)
                                        <div class="p-3 bg-white border border-stone-100 rounded-xl flex justify-between items-center">
                                            <div>
                                                <p class="text-gray-900">{{ $exp->company_name }}</p>
                                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">{{ $exp->position ?? '-' }}</p>
                                            </div>
                                            <span class="text-[8px] text-tumbas font-black px-2 py-0.5 bg-stone-50 border border-stone-100 rounded">{{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} - {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : 'Sekarang' }}</span>
                                        </div>
                                    @empty
                                        <p class="text-[10px] text-gray-300 italic">Tidak ada pengalaman yang tercatat.</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Document Buttons -->
                            <div class="px-2">
                                <p class="text-[9px] text-gray-400 uppercase tracking-widest mb-4 font-medium">Dokumen Pendukung</p>
                                <div class="flex flex-wrap gap-3">
                                    @if($profile->document?->cv_path)
                                        <a href="{{ Storage::url($profile->document->cv_path) }}" target="_blank" class="inline-block px-4 py-2 bg-white border border-stone-200 rounded-xl text-[9px] font-black text-tumbas hover:bg-tumbas hover:text-white transition shadow-sm uppercase tracking-widest">Curriculum Vitae (PDF)</a>
                                    @endif
                                    @if($profile->document?->photo_path)
                                        <a href="{{ Storage::url($profile->document->photo_path) }}" target="_blank" class="inline-block px-4 py-2 bg-white border border-stone-200 rounded-xl text-[9px] font-black text-tumbas hover:bg-tumbas hover:text-white transition shadow-sm uppercase tracking-widest">Pas Foto</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <p class="text-[9px] font-black text-stone-200 uppercase tracking-[0.4em]">Tumbas Coffee ecosystem 2025</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

