<x-app-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 transition">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            Rekap Absensi Santri
                        </h1>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Wali Santri</div>
                    </div>
                    <a href="/dashboard" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">
                        Kembali
                    </a>
                </div>

                <div class="p-6">
                    <div class="mb-6 flex flex-wrap items-center gap-3">
                        <input type="date" id="tanggal"
                            value="{{ $tanggal ?? now()->format('Y-m-d') }}"
                            min="{{ $minTanggal ?? now()->subDays(7)->format('Y-m-d') }}"
                            max="{{ $maxTanggal ?? now()->format('Y-m-d') }}"
                            class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-blue-500">

                        <input type="text" id="search" placeholder="Cari nama atau NIS..."
                            class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-2 w-72 focus:ring-2 focus:ring-blue-500"
                            value="{{ $search ?? '' }}">
                    </div>

                    <div id="loading" class="hidden text-center py-6 text-gray-500 dark:text-gray-300">Memuat data...</div>

                    <div id="rekap-container">
                        @include('wali.partials.rekap-table', [
                            'tanggal' => $tanggal ?? now()->toDateString(),
                            'rows' => $rows ?? collect(),
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const tanggal = document.getElementById('tanggal');
    const search = document.getElementById('search');
    const rekapContainer = document.getElementById('rekap-container');
    const loading = document.getElementById('loading');

    let typingTimer;
    const delay = 350;

    async function fetchRekap() {
        loading.classList.remove('hidden');
        rekapContainer.innerHTML = '';

        const query = new URLSearchParams({
            tanggal: tanggal.value,
            search: search.value,
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

    search.addEventListener('input', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(fetchRekap, delay);
    });

    tanggal.addEventListener('change', fetchRekap);
    </script>
</x-app-layout>
