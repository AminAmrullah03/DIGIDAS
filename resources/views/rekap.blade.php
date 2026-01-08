<x-app-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 transition">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            📋 Rekap Absensi Santri
                        </h1>
                    </div>
                    <a href="/dashboard" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9m0 0l9 9m-9-9v18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6" x-data="{ loading: false }">
                    <!-- Filter Section -->
                    <div class="mb-6 flex flex-wrap items-center gap-3">
                        <input type="date" id="tanggal"
                            value="{{ $tanggal ?? now()->format('Y-m-d') }}"
                            class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-blue-500">

                        <select id="kelas" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ ($kelasFilter ?? '') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>

                        <select id="kegiatan" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach ($kegiatanList as $kegiatan)
                                <option value="{{ $kegiatan->id }}" {{ ($kegiatanFilter ?? '') == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama_kegiatan }}</option>
                            @endforeach
                        </select>

                        <button id="resetBtn" class="px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Reset
                        </button>
                    </div>

                    <!-- Loading indicator -->
                    <div id="loading" class="hidden text-center py-10 text-gray-500 dark:text-gray-300">
                        <svg class="animate-spin h-6 w-6 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Memuat data...
                    </div>

                    <!-- Table container -->
                    <div id="rekap-container">
                        @include('partials.rekap-table', ['rekap' => $rekap])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const tanggal = document.getElementById('tanggal');
    const kelas = document.getElementById('kelas');
    const kegiatan = document.getElementById('kegiatan');
    const rekapContainer = document.getElementById('rekap-container');
    const loading = document.getElementById('loading');
    const resetBtn = document.getElementById('resetBtn');

    // Fetch data dari server tanpa reload
    async function fetchRekap() {
        // Hanya fetch jika kelas dan kegiatan sudah dipilih
        if (!kelas.value || !kegiatan.value) {
            rekapContainer.innerHTML = `<div class='text-center py-16'>
                <div class='mx-auto mb-3 w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class='text-lg font-semibold text-gray-800 dark:text-gray-200'>Pilih Kelas dan Kegiatan</h3>
                <p class='text-sm text-gray-500 dark:text-gray-400'>Silakan pilih kelas dan kegiatan untuk menampilkan rekap absensi.</p>
            </div>`;
            return;
        }

        loading.classList.remove('hidden');
        rekapContainer.innerHTML = '';

        const query = new URLSearchParams({
            tanggal: tanggal.value,
            kelas: kelas.value,
            kegiatan: kegiatan.value
        }).toString();

        try {
            const res = await fetch(`/rekap-data?${query}`);
            const html = await res.text();
            rekapContainer.innerHTML = html;
        } catch (err) {
            rekapContainer.innerHTML = `<div class='text-center text-red-500 py-6'>Gagal memuat data!</div>`;
        } finally {
            loading.classList.add('hidden');
        }
    }

    // Event listener perubahan filter
    tanggal.addEventListener('change', fetchRekap);
    kelas.addEventListener('change', fetchRekap);
    kegiatan.addEventListener('change', fetchRekap);

    // Reset filter
    resetBtn.addEventListener('click', () => {
        kelas.value = '';
        kegiatan.value = '';
        tanggal.value = new Date().toISOString().split('T')[0];
        fetchRekap();
    });
    </script>
</x-app-layout>
