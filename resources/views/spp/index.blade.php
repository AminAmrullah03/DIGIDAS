<x-app-layout>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <div class="py-12 transition-colors duration-300 bg-gray-50 dark:bg-gray-900 min-h-screen relative">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Card Scanner -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl p-6">
                <div class="mb-4 text-center">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">💰 Pembayaran SPP</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Scan QR atau ketik NIS santri</p>
                </div>

                <div class="flex gap-3">
                    <input id="nis_input" type="text" placeholder="Masukkan NIS..." autofocus
                        class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />
                    <button id="btn-cari" type="button"
                        class="px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow-md hover:shadow-lg transition-all duration-200">
                        Cari
                    </button>
                </div>

                <button id="btn-scan-camera" type="button"
                    class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium shadow-md hover:shadow-lg transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                    </svg>
                    Scan dengan Kamera
                </button>

                <div id="camera-container" class="hidden mt-4">
                    <div class="relative">
                        <div id="qr-reader" class="rounded-lg overflow-hidden"></div>
                        <button id="btn-stop-camera" type="button"
                            class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-medium transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tutup Kamera
                        </button>
                    </div>
                </div>

                <!-- Link ke rekap -->
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between text-sm">
                    <a href="{{ route('spp.rekap') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                        📊 Rekap SPP
                    </a>
                    <a href="{{ route('spp.riwayat') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                        📜 Riwayat Pembayaran
                    </a>
                </div>
            </div>

            <!-- CARD HASIL (muncul di bawah setelah scan/cari) -->
            <div id="card-spp" class="hidden mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl overflow-hidden animate-fade-in">
                <!-- Header Profil -->
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-bold">
                            <span id="card-initial">?</span>
                        </div>
                        <div class="flex-1">
                            <h3 id="card-nama" class="text-lg font-bold text-gray-900 dark:text-white">-</h3>
                            <p id="card-kelas" class="text-sm text-gray-600 dark:text-gray-400">-</p>
                        </div>
                        <button id="btn-close-card" class="p-2 hover:bg-white/50 dark:hover:bg-gray-700 rounded-full transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Status SPP Grid -->
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Status SPP <span id="card-tahun">1446</span> H</h4>
                    </div>
                    <div id="card-spp-grid" class="grid grid-cols-6 gap-2 text-xs">
                        <!-- Grid bulan -->
                    </div>
                    
                    <!-- Ringkasan -->
                    <div class="mt-4 p-3 rounded-lg bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 border border-red-200 dark:border-red-800">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Total Tanggungan</p>
                                <p class="text-xl font-bold text-red-600 dark:text-red-400" id="card-tanggungan">Rp 0</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-600 dark:text-gray-400">Bulan Belum Lunas</p>
                                <p class="text-xl font-bold text-orange-600 dark:text-orange-400" id="card-jumlah-bulan">0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Pembayaran -->
                <div class="p-5">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Input Pembayaran</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">💡 Nominal akan otomatis dialokasikan ke bulan yang belum dibayar</p>
                    <form id="form-bayar" class="space-y-4">
                        <input type="hidden" id="form-nis" name="nis">
                        <input type="hidden" id="form-tahun" name="tahun" value="1446">
                        
                        <!-- Quick amount buttons -->
                        <div class="grid grid-cols-4 gap-2">
                            <button type="button" class="quick-amount px-2 py-2 text-xs rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:border-blue-400 transition-colors" data-amount="50000">50rb</button>
                            <button type="button" class="quick-amount px-2 py-2 text-xs rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:border-blue-400 transition-colors" data-amount="100000">100rb</button>
                            <button type="button" class="quick-amount px-2 py-2 text-xs rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:border-blue-400 transition-colors" data-amount="200000">200rb</button>
                            <button type="button" class="quick-amount px-2 py-2 text-xs rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:border-blue-400 transition-colors" data-amount="600000">600rb</button>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Nominal Bayar</label>
                                <input type="number" id="form-nominal" name="nominal_bayar" required min="1" placeholder="Masukkan nominal..."
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Metode</label>
                                <select name="metode" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="cash">💵 Cash</option>
                                    <option value="transfer">🏦 Transfer</option>
                                </select>
                            </div>
                        </div>

                        <div id="preview-bulan" class="hidden p-3 rounded-lg bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 text-xs text-blue-700 dark:text-blue-300">
                            <span class="font-medium">Akan membayar:</span> <span id="preview-text">-</span>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" id="btn-batal"
                                class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                                Batal
                            </button>
                            <button type="submit" id="btn-simpan"
                                class="flex-1 px-4 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium text-sm shadow-md hover:shadow-lg transition-all duration-200">
                                💾 Bayar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Toast container -->
        <div id="toast-container" class="fixed top-5 right-5 flex flex-col gap-2 z-[60]"></div>
    </div>

    <script>
    const BULAN_SHORT = {
        1: 'Muh', 2: 'Saf', 3: 'R.Aw', 4: 'R.Ak', 5: 'J.Aw', 6: 'J.Ak',
        7: 'Raj', 8: 'Sya', 9: 'Ram', 10: 'Syw', 11: 'Dzq', 12: 'Dzh'
    };

    const input = document.getElementById('nis_input');
    const btnCari = document.getElementById('btn-cari');
    const toastContainer = document.getElementById('toast-container');
    const cardSpp = document.getElementById('card-spp');

    let currentNis = null;
    let currentTagihan = [];
    let currentTahun = 1446;

    // Event listeners
    btnCari.addEventListener('click', () => searchSantri(input.value.trim()));
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') searchSantri(input.value.trim());
    });

    document.getElementById('btn-close-card').addEventListener('click', closeCard);
    document.getElementById('btn-batal').addEventListener('click', closeCard);

    document.getElementById('form-bayar').addEventListener('submit', async (e) => {
        e.preventDefault();
        await submitPembayaran();
    });

    async function searchSantri(nis) {
        if (!nis) {
            showToast('error', 'Masukkan NIS terlebih dahulu!');
            return;
        }

        try {
            const res = await fetch(`/spp/santri?nis=${encodeURIComponent(nis)}&tahun=${currentTahun}`, {
                headers: { 'Accept': 'application/json' }
            });

            const data = await res.json();

            if (!data.success) {
                showToast('error', data.message || 'Santri tidak ditemukan');
                cardSpp.classList.add('hidden');
                return;
            }

            currentNis = data.santri.nis;
            currentTagihan = data.tagihan;
            currentTahun = data.tahun;

            // Update card
            document.getElementById('card-initial').textContent = data.santri.nama.charAt(0).toUpperCase();
            document.getElementById('card-nama').textContent = data.santri.nama;
            document.getElementById('card-kelas').textContent = `${data.santri.kelas} • NIS: ${data.santri.nis}`;
            document.getElementById('card-tahun').textContent = data.tahun;
            document.getElementById('card-tanggungan').textContent = formatRupiah(data.total_tanggungan);
            document.getElementById('card-jumlah-bulan').textContent = data.jumlah_bulan_belum;

            document.getElementById('form-nis').value = data.santri.nis;
            document.getElementById('form-tahun').value = data.tahun;

            renderSppGrid(data.tagihan);

            cardSpp.classList.remove('hidden');
            cardSpp.scrollIntoView({ behavior: 'smooth', block: 'start' });

        } catch (err) {
            console.error(err);
            showToast('error', 'Terjadi kesalahan saat mengambil data');
        }
    }

    function renderSppGrid(tagihan) {
        const container = document.getElementById('card-spp-grid');
        container.innerHTML = '';

        tagihan.forEach(item => {
            const div = document.createElement('div');
            const statusClass = item.status === 'lunas' 
                ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 border-green-300' 
                : item.status === 'sebagian'
                    ? 'bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 border-amber-300'
                    : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 border-red-300';
            
            const icon = item.status === 'lunas' ? '✔' : item.status === 'sebagian' ? '◐' : '✗';
            
            div.className = `p-2 rounded-lg text-center border ${statusClass}`;
            div.innerHTML = `<div class="font-bold">${icon}</div><div>${BULAN_SHORT[item.bulan]}</div>`;
            container.appendChild(div);
        });
    }

    function updatePreview() {
        const nominal = parseInt(document.getElementById('form-nominal').value) || 0;
        const previewDiv = document.getElementById('preview-bulan');
        const previewText = document.getElementById('preview-text');

        if (nominal <= 0) {
            previewDiv.classList.add('hidden');
            return;
        }

        // Calculate how many months can be paid
        const bulanBelumLunas = currentTagihan.filter(t => t.status !== 'lunas');
        let sisa = nominal;
        let bulanAkanDibayar = [];

        for (const t of bulanBelumLunas) {
            if (sisa <= 0) break;
            const sisaTagihan = t.sisa || (t.nominal - (t.total_bayar || 0));
            if (sisaTagihan > 0) {
                const bayar = Math.min(sisa, sisaTagihan);
                bulanAkanDibayar.push(BULAN_SHORT[t.bulan]);
                sisa -= bayar;
            }
        }

        if (bulanAkanDibayar.length > 0) {
            previewText.textContent = bulanAkanDibayar.join(', ') + (sisa > 0 ? ' + sisa ke tahun berikutnya' : '');
            previewDiv.classList.remove('hidden');
        } else {
            previewDiv.classList.add('hidden');
        }
    }

    // Quick amount buttons
    document.querySelectorAll('.quick-amount').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('form-nominal').value = btn.dataset.amount;
            updatePreview();
        });
    });

    document.getElementById('form-nominal').addEventListener('input', updatePreview);

    function closeCard() {
        cardSpp.classList.add('hidden');
        resetForm();
        input.value = '';
        input.focus();
    }

    async function submitPembayaran() {
        const form = document.getElementById('form-bayar');
        const formData = new FormData(form);
        
        const data = {
            nis: formData.get('nis'),
            tahun: parseInt(formData.get('tahun')),
            nominal_bayar: parseFloat(formData.get('nominal_bayar')),
            metode: formData.get('metode'),
        };

        if (!data.nominal_bayar || data.nominal_bayar < 1) {
            showToast('error', 'Masukkan nominal pembayaran!');
            return;
        }

        try {
            const res = await fetch('/spp/bayar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();

            if (result.success) {
                showToast('success', result.message);
                // Refresh data santri
                searchSantri(currentNis);
            } else {
                showToast('error', result.message || 'Gagal menyimpan pembayaran');
            }

        } catch (err) {
            console.error(err);
            showToast('error', 'Terjadi kesalahan saat menyimpan pembayaran');
        }
    }

    function resetForm() {
        document.getElementById('form-nominal').value = '';
        document.getElementById('preview-bulan').classList.add('hidden');
    }

    function formatRupiah(num) {
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function showToast(type, message) {
        const colors = { success: 'bg-green-500', warning: 'bg-amber-500', error: 'bg-red-500' };
        const toast = document.createElement('div');
        toast.className = `${colors[type]} text-white px-4 py-2 rounded-md shadow-md animate-fade-in`;
        toast.innerHTML = `<strong>${type.toUpperCase()}</strong>: ${message}`;
        toastContainer.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ========== CAMERA QR SCANNER ==========
    const btnScanCamera = document.getElementById('btn-scan-camera');
    const btnStopCamera = document.getElementById('btn-stop-camera');
    const cameraContainer = document.getElementById('camera-container');
    let html5QrCode = null;
    let isScanning = false;

    btnScanCamera.addEventListener('click', async function() {
        if (isScanning) return;
        try {
            cameraContainer.classList.remove('hidden');
            btnScanCamera.disabled = true;
            btnScanCamera.innerHTML = `<svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Membuka Kamera...`;
            html5QrCode = new Html5Qrcode("qr-reader");
            const qrConfig = { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 };
            let cameraId = null;
            try {
                const devices = await Html5Qrcode.getCameras();
                if (devices && devices.length > 0) {
                    const backCamera = devices.find(d => d.label.toLowerCase().includes('back'));
                    cameraId = backCamera ? backCamera.id : devices[0].id;
                }
            } catch (e) {}
            await html5QrCode.start(cameraId || { facingMode: "environment" }, qrConfig, onScanSuccess, () => {});
            isScanning = true;
            btnScanCamera.innerHTML = `📷 Kamera Aktif`;
            btnScanCamera.classList.remove('from-blue-600', 'to-indigo-600');
            btnScanCamera.classList.add('from-green-600', 'to-emerald-600');
        } catch (err) {
            showToast('error', 'Gagal membuka kamera');
            stopCamera();
        }
    });

    btnStopCamera.addEventListener('click', stopCamera);

    async function stopCamera() {
        if (html5QrCode && isScanning) { try { await html5QrCode.stop(); } catch (e) {} }
        isScanning = false;
        html5QrCode = null;
        cameraContainer.classList.add('hidden');
        btnScanCamera.disabled = false;
        btnScanCamera.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" /></svg> Scan dengan Kamera`;
        btnScanCamera.classList.remove('from-green-600', 'to-emerald-600');
        btnScanCamera.classList.add('from-blue-600', 'to-indigo-600');
        const qrReader = document.getElementById('qr-reader');
        if (qrReader) qrReader.innerHTML = '';
    }

    function onScanSuccess(decodedText) {
        stopCamera();
        input.value = decodedText;
        searchSantri(decodedText);
    }

    const style = document.createElement('style');
    style.textContent = `@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } } .animate-fade-in { animation: fadeIn 0.3s ease forwards; }`;
    document.head.appendChild(style);

    window.addEventListener('load', () => input.focus());
    </script>
</x-app-layout>
