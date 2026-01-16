<x-app-layout>
    <div class="py-12 transition-colors duration-300 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">📋 Rekap Perizinan</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Daftar santri yang sedang izin</p>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('izin.rekap') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                        <select name="kelas" id="kelas"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $kelasFilter == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Semua Status</option>
                            <option value="Belum Kembali" {{ $statusFilter == 'Belum Kembali' ? 'selected' : '' }}>Belum Kembali</option>
                            <option value="Sudah Kembali" {{ $statusFilter == 'Sudah Kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white font-medium transition-colors">
                            Filter
                        </button>
                    </div>
                </form>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-4 border border-purple-200 dark:border-purple-700">
                        <p class="text-sm text-purple-600 dark:text-purple-400">Total Izin</p>
                        <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ $izinList->count() }}</p>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-900/30 rounded-lg p-4 border border-amber-200 dark:border-amber-700">
                        <p class="text-sm text-amber-600 dark:text-amber-400">Belum Kembali</p>
                        <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $izinList->where('status', 'Belum Kembali')->count() }}</p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4 border border-green-200 dark:border-green-700">
                        <p class="text-sm text-green-600 dark:text-green-400">Sudah Kembali</p>
                        <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $izinList->where('status', 'Sudah Kembali')->count() }}</p>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 rounded-tl-lg">No</th>
                                <th class="px-4 py-3">NIS</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Kelas</th>
                                <th class="px-4 py-3">Keperluan</th>
                                <th class="px-4 py-3">Waktu Keluar</th>
                                <th class="px-4 py-3">Waktu Kembali</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($izinList as $index => $izin)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50" data-id="{{ $izin->id }}">
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $izin->nis }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $izin->santri->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $izin->santri->kelas ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white max-w-xs truncate" title="{{ $izin->keperluan }}">{{ $izin->keperluan }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $izin->waktu_keluar->format('H:i') }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $izin->waktu_kembali ? $izin->waktu_kembali->format('H:i') : '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if($izin->status == 'Belum Kembali')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300">
                                                Belum Kembali
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                                Sudah Kembali
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <button type="button" onclick="openEditModal({{ $izin->id }}, '{{ $izin->status }}', '{{ addslashes($izin->keterangan ?? '') }}')"
                                            class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 font-medium">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada data izin untuk tanggal ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('izin.index') }}" class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 font-medium">
                        ← Kembali ke halaman izin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeEditModal()"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full p-6 z-10">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Edit Status Izin</h3>
                
                <input type="hidden" id="edit-id">
                
                <div class="mb-4">
                    <label for="edit-status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select id="edit-status"
                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="Belum Kembali">Belum Kembali</option>
                        <option value="Sudah Kembali">Sudah Kembali</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="edit-keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keterangan (Opsional)</label>
                    <textarea id="edit-keterangan" rows="3" placeholder="Tambahkan keterangan jika perlu..."
                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        Batal
                    </button>
                    <button type="button" onclick="saveStatus()" id="btn-save-status"
                        class="flex-1 px-4 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium text-sm shadow-md hover:shadow-lg transition-all duration-200">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function openEditModal(id, status, keterangan) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-status').value = status;
        document.getElementById('edit-keterangan').value = keterangan;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function saveStatus() {
        const id = document.getElementById('edit-id').value;
        const status = document.getElementById('edit-status').value;
        const keterangan = document.getElementById('edit-keterangan').value;
        const btn = document.getElementById('btn-save-status');

        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        fetch('/izin/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id, status, keterangan })
        })
        .then(async res => {
            const data = await res.json();
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Gagal menyimpan');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan');
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'Simpan';
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });
    </script>
</x-app-layout>
