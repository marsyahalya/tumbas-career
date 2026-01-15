<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Rider') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 border border-stone-100">

                <div class="flex flex-col md:flex-row justify-between mb-8 items-center gap-4">

                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 leading-none">Daftar Pendaftar Rider</h>
                    </div>

                    <div class="flex flex-wrap items-center gap-2" x-data="{ status: '{{ request('status') }}' }">
                        <form action="{{ route('admin.riders.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="text-xs font-bold rounded-xl border-stone-200 focus:ring-tumbas focus:border-tumbas pl-8 w-40 md:w-64">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <select name="status" x-model="status" class="text-xs font-bold rounded-xl border-stone-200 focus:ring-tumbas focus:border-tumbas">
                                <option value="">Semua Tahapan</option>
                                <option value="submit">Pendaftaran Terkirim</option>
                                <option value="verifikasi_berkas">Verifikasi Data</option>
                                <option value="wawancara">Wawancara</option>
                                <option value="final_approval">Persetujuan Akhir</option>
                            </select>
                            
                            <template x-if="status === 'verifikasi_berkas' || status === 'final_approval'">
                                <select name="employment_status" class="text-xs font-bold rounded-xl border-stone-200 focus:ring-tumbas focus:border-tumbas" x-transition>
                                    <option value="" x-text="status === 'verifikasi_berkas' ? 'Semua Hasil Verifikasi' : 'Semua Hasil Persetujuan'"></option>
                                    <option value="terima" x-text="status === 'verifikasi_berkas' ? 'Data Diterima (Lolos)' : 'Diterima (Kerja)'" {{ request('employment_status') == 'terima' ? 'selected' : '' }}></option>
                                    <option value="ditolak" x-text="status === 'verifikasi_berkas' ? 'Data Ditolak' : 'Ditolak (Gagal)'" {{ request('employment_status') == 'ditolak' ? 'selected' : '' }}></option>
                                </select>
                            </template>

                            <button type="submit" class="bg-stone-900 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-stone-800 transition">Filter</button>
                            @if(request()->hasAny(['status', 'employment_status', 'search']))
                                <a href="{{ route('admin.riders.index') }}" class="text-xs text-red-500 font-bold hover:underline">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-stone-50 text-[10px] font-extrabold uppercase tracking-widest text-gray-400">
                                <th class="border-b border-stone-100 p-4">Info Rider</th>
                                <th class="border-b border-stone-100 p-4">Tanggal Daftar</th>
                                <th class="border-b border-stone-100 p-4 text-center">Tahapan Pendaftaran</th>
                                <th class="border-b border-stone-100 p-4 text-center">Status Kerja</th>
                                <th class="border-b border-stone-100 p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($riders as $rider)
                            <tr class="hover:bg-stone-50 transition-colors border-b border-stone-50">
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800">{{ $rider->full_name }}</span>
                                        <span class="text-[10px] text-gray-400 font-medium">{{ $rider->phone_number }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="text-gray-500 font-medium">{{ $rider->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 text-[10px] font-bold rounded-full uppercase
                                        @if($rider->employment_status === 'ditolak') bg-red-100 text-red-600
                                        @elseif($rider->application_status === 'final_approval' && $rider->employment_status === 'terima')
                                            {{ $rider->auto_employment_status === 'active' ? 'bg-green-100 text-green-600' : 'bg-stone-100 text-stone-500' }}
                                        @elseif($rider->application_status === 'submit') bg-tumbas-100 text-tumbas-600
                                        @else bg-blue-100 text-blue-600
                                        @endif
                                    ">
                                        {{ $rider->status_label }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                     @if($rider->application_status === 'final_approval' && $rider->employment_status === 'terima')
                                        <span class="px-2 py-0.5 text-[9px] font-extrabold border rounded uppercase
                                            @if($rider->auto_employment_status === 'active') border-green-200 text-green-600 bg-green-50
                                            @else border-stone-200 text-gray-400 bg-stone-100
                                            @endif
                                        ">
                                            {{ $rider->auto_employment_status === 'active' ? 'Aktif' : 'Alumni' }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                     <a href="{{ route('admin.riders.show', $rider->id) }}" class="inline-block bg-white border border-stone-200 text-tumbas px-4 py-1.5 rounded-full text-[10px] font-extrabold hover:bg-tumbas hover:text-white transition shadow-sm uppercase tracking-wider">Kelola</a>
                                 </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-400 font-medium italic">Belum ada pendaftar rider untuk saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(method_exists($riders, 'links'))
                <div class="mt-8">
                    {{ $riders->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
