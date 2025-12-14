<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Jadwal Absen
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                    <ul class="list-disc ps-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('jadwal.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium mb-1">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" required>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Jam Mulai</label>
                                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Jam Selesai</label>
                                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Kode (opsional)</label>
                                <input type="text" name="kode" value="{{ old('kode') }}" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Mis. NGP">
                            </div>
                            <div class="flex items-center gap-2 pt-6">
                                <input id="aktif" type="checkbox" name="aktif" value="1" class="rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" {{ old('aktif', '1') ? 'checked' : '' }}>
                                <label for="aktif" class="text-sm">Aktif</label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Keterangan (opsional)</label>
                            <textarea name="keterangan" rows="3" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-4">
                            <a href="{{ route('jadwal.index') }}" class="px-4 py-2 rounded border border-gray-300 dark:border-gray-700">Batal</a>
                            <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
