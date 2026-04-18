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
                        <h3 class="text-xl font-extrabold text-gray-900 leading-none">Daftar Pendaftar Rider</h3>
                        <p class="text-xs text-gray-400 font-bold mt-1 uppercase tracking-widest">Tumbas Coffee Solo Ecosystem</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-stone-50 text-[10px] font-extrabold uppercase tracking-widest text-gray-400">
                                <th class="border-b border-stone-100 p-4">Rider Info</th>
                                <th class="border-b border-stone-100 p-4">Tanggal Daftar</th>
                                <th class="border-b border-stone-100 p-4 text-center">Status Berkas</th>
                                <th class="border-b border-stone-100 p-4 text-center">Employ. Status</th>
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
                                        @if($rider->application_status === 'submitted') bg-orange-100 text-orange-600
                                        @elseif($rider->application_status === 'accepted') bg-green-100 text-green-600
                                        @elseif($rider->application_status === 'rejected') bg-red-100 text-red-600
                                        @else bg-blue-100 text-blue-600
                                        @endif
                                    ">
                                        {{ $rider->status_label }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    @if($rider->application_status === 'accepted')
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
