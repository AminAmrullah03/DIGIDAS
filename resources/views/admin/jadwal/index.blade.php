<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Jadwal Absen
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif
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
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <a href="{{ route('jadwal.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                + Tambah Jadwal
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-left font-semibold">Nama Kegiatan</th>
                                    <th class="px-3 py-2 text-left font-semibold">Jam</th>
                                    <th class="px-3 py-2 text-left font-semibold">Hari</th>
                                    <th class="px-3 py-2 text-left font-semibold">Kode</th>
                                    <th class="px-3 py-2 text-left font-semibold">Aktif</th>
                                    <th class="px-3 py-2 text-right font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($jadwals as $j)
                                    <tr>
                                        <td class="px-3 py-2">{{ $j->nama_kegiatan }}</td>
                                        <td class="px-3 py-2">{{ \Illuminate\Support\Str::of($j->jam_mulai)->substr(0,5) }} - {{ \Illuminate\Support\Str::of($j->jam_selesai)->substr(0,5) }}</td>
                                        <td class="px-3 py-2">
                                            @php($days = [1=>'Sen',2=>'Sel',3=>'Rab',4=>'Kam',5=>'Jum',6=>'Sab',7=>'Min'])
                                            @if(empty($j->hari))
                                                Setiap hari
                                            @else
                                                {{ collect($j->hari)->map(fn($d) => $days[$d] ?? $d)->implode(', ') }}
                                            @endif
                                        </td>
                                        <td class="px-3 py-2">{{ $j->kode ?? '-' }}</td>
                                        <td class="px-3 py-2">
                                            <button data-id="{{ $j->id }}" data-active="{{ $j->aktif ? '1':'0' }}" class="toggle-aktif px-3 py-1 rounded text-white {{ $j->aktif ? 'bg-green-600 hover:bg-green-700':'bg-gray-500 hover:bg-gray-600' }}">
                                                {{ $j->aktif ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </td>
                                        <td class="px-3 py-2 text-right space-x-2">
                                            <a href="{{ route('jadwal.edit', $j->id) }}" class="inline-flex px-3 py-1 rounded bg-indigo-600 hover:bg-indigo-700 text-white">Edit</a>
                                            <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada jadwal.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            document.querySelectorAll('.toggle-aktif').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.getAttribute('data-id');
                    btn.disabled = true;
                    try {
                        const res = await fetch(`{{ url('jadwal') }}/${id}/toggle`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();
                        if (data.ok) {
                            const active = !!data.aktif;
                            btn.textContent = active ? 'Aktif' : 'Nonaktif';
                            btn.classList.toggle('bg-green-600', active);
                            btn.classList.toggle('hover:bg-green-700', active);
                            btn.classList.toggle('bg-gray-500', !active);
                            btn.classList.toggle('hover:bg-gray-600', !active);
                        } else {
                            alert('Gagal toggle.');
                        }
                    } catch (e) {
                        alert('Terjadi kesalahan jaringan.');
                    } finally {
                        btn.disabled = false;
                    }
                });
            });
        });
    </script>
</x-app-layout>
