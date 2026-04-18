<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Area') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, editMode: false, currentArea: {} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Daftar Area Operasional</h3>
                    <button @click="showModal = true; editMode = false; currentArea = {}" class="bg-tumbas text-white px-4 py-2 rounded text-sm font-semibold">
                        + Tambah Area
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border-b p-3">Nama Area</th>
                                <th class="border-b p-3">Deskripsi</th>
                                <th class="border-b p-3 text-center">Status</th>
                                <th class="border-b p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($areas as $area)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="p-3">{{ $area->name }}</td>
                                <td class="p-3 text-sm">{{ $area->description }}</td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded {{ $area->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $area->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="p-3 flex gap-2 justify-center">
                                    <button @click="currentArea = {{ $area }}; editMode = true; showModal = true" class="bg-yellow-500 text-white px-3 py-1 rounded text-xs">Edit</button>
                                    <form action="{{ route('admin.areas.toggle', $area) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 rounded text-xs {{ $area->is_active ? 'bg-stone-500 hover:bg-stone-600' : 'bg-green-600 hover:bg-green-700' }} text-white">
                                            {{ $area->is_active ? 'Matikan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.areas.destroy', $area) }}" method="POST" onsubmit="return confirm('Hapus area ini?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-12 text-center text-gray-400 italic">Data area tidak tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modal Form -->
                <div x-show="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50" style="display: none;">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md" @click.away="showModal = false">
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-4" x-text="editMode ? 'Edit Area' : 'Tambah Area'"></h3>
                            
                            <form :action="editMode ? `/admin/areas/${currentArea.id}` : `{{ route('admin.areas.store') }}`" method="POST">
                                @csrf
                                <!-- Method spoofing for PUT -->
                                <template x-if="editMode">
                                    <input type="hidden" name="_method" value="PUT">
                                </template>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium">Nama Area</label>
                                        <input type="text" name="name" :value="currentArea.name" required class="mt-1 w-full rounded border-gray-300">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium">Deskripsi</label>
                                        <textarea name="description" class="mt-1 w-full rounded border-gray-300" x-text="currentArea.description"></textarea>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" @click="showModal = false" class="bg-gray-300 px-4 py-2 rounded text-sm">Batal</button>
                                    <button type="submit" class="bg-tumbas text-white px-4 py-2 rounded text-sm" x-text="editMode ? 'Simpan Perubahan' : 'Tambah'"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
