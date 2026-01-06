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
                            value="{{ now()->format('Y-m-d') }}"
                            class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-blue-500">

                        <input type="text" id="search" placeholder="   Cari nama atau NIS..."
                            class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-2 pl-10 w-64 focus:ring-2 focus:ring-blue-500"
                            style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.5\' stroke=\'gray\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M21 21l-4.35-4.35M9.5 17A7.5 7.5 0 109.5 2a7.5 7.5 0 000 15z\'/></svg>'); background-repeat: no-repeat; background-position: 10px center; background-size: 18px;">

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
    const search = document.getElementById('search');
    const tanggal = document.getElementById('tanggal');
    const rekapContainer = document.getElementById('rekap-container');
    const loading = document.getElementById('loading');
    const resetBtn = document.getElementById('resetBtn');

    let typingTimer;
    const delay = 500; // waktu tunggu setelah berhenti mengetik (ms)

    // Fetch data dari server tanpa reload
    async function fetchRekap() {
        loading.classList.remove('hidden');
        rekapContainer.innerHTML = '';

        const query = new URLSearchParams({
            tanggal: tanggal.value,
            search: search.value
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

    // Event listener pencarian realtime
    search.addEventListener('input', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(fetchRekap, delay);
    });

    // Event listener perubahan tanggal
    tanggal.addEventListener('change', fetchRekap);

    // Reset filter
    resetBtn.addEventListener('click', () => {
        search.value = '';
        tanggal.value = new Date().toISOString().split('T')[0];
        fetchRekap();
    });
    </script>
</x-app-layout>
