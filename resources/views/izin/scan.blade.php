<x-app-layout>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <div class="py-12 transition-colors duration-300 bg-gray-50 dark:bg-gray-900 min-h-screen relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center">
                <div class="w-full max-w-md">
                    <div id="izin-card" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl p-6 transition-all duration-500">
                        <div class="mb-4 text-center">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">🎫 Perizinan Santri</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Scan QR atau ketik NIS untuk input izin</p>
                        </div>

                        <label for="nis_input" class="sr-only">NIS</label>
                        <input id="nis_input" type="text" placeholder="Scan NIS di sini..." autofocus
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300" />

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

                        <!-- Santri Info Card (hidden until scanned) -->
                        <div id="santri-card" class="hidden mt-5 p-4 rounded-lg border border-purple-200 dark:border-purple-700 bg-purple-50 dark:bg-purple-900/30">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-14 h-14 bg-purple-200 dark:bg-purple-800 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-purple-600 dark:text-purple-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 id="santri-nama" class="text-lg font-semibold text-gray-900 dark:text-white"></h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span id="santri-nis"></span> • <span id="santri-kelas"></span>
                                    </p>
                                </div>
                            </div>

                            <!-- Warning jika masih ada izin aktif -->
                            <div id="izin-aktif-warning" class="hidden mt-3 p-3 rounded-lg bg-amber-100 dark:bg-amber-900/50 border border-amber-300 dark:border-amber-700">
                                <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                                    ⚠️ Santri masih memiliki izin aktif:
                                </p>
                                <p id="izin-aktif-info" class="text-sm text-amber-700 dark:text-amber-300 mt-1"></p>
                                <button id="btn-kembali" type="button"
                                    class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-medium transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tandai Sudah Kembali
                                </button>
                            </div>

                            <!-- Form input izin baru -->
                            <div id="form-izin" class="mt-4">
                                <label for="keperluan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Keperluan Izin
                                </label>
                                <textarea id="keperluan" rows="3" placeholder="Contoh: Pulang karena sakit, Mengambil obat, dll..."
                                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300"></textarea>

                                <br><button id="btn-submit-izin" type="button" class="flex-1 px-4 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium text-sm shadow-md hover:shadow-lg transition-all duration-200">
                                    Simpan Izin
                                </button>
                            </div>
                        </div>

                        <div id="result" class="mt-5 text-base transition-all duration-500 ease-in-out"></div>

                        <div class="mt-6 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <a href="{{ route('izin.rekap') }}" class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 font-medium">Lihat rekap izin →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="toast-container" class="fixed top-5 right-5 flex flex-col gap-2 z-50"></div>
    </div>

    <script>
    const input = document.getElementById('nis_input');
    const result = document.getElementById('result');
    const card = document.getElementById('izin-card');
    const toastContainer = document.getElementById('toast-container');
    const santriCard = document.getElementById('santri-card');
    const formIzin = document.getElementById('form-izin');
    const izinAktifWarning = document.getElementById('izin-aktif-warning');
    const btnSubmitIzin = document.getElementById('btn-submit-izin');
    const btnKembali = document.getElementById('btn-kembali');
    const keperluanInput = document.getElementById('keperluan');

    let currentSantri = null;
    let typingTimer;
    const delay = 400;

    input.addEventListener('input', function() {
        clearTimeout(typingTimer);
        if (input.value.trim().length >= 3) {
            typingTimer = setTimeout(() => {
                fetchSantri(input.value.trim());
            }, delay);
        }
    });

    function fetchSantri(nis) {
        result.className = 'mt-5 text-base';
        result.innerHTML = '<div class="flex items-center gap-2 text-gray-600 dark:text-gray-400"><svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Mencari data santri...</div>';

        fetch(`/izin/santri?nis=${encodeURIComponent(nis)}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(async res => {
            const data = await res.json().catch(() => ({ message: 'Terjadi kesalahan' }));

            if (!res.ok || !data.success) {
                result.className = 'mt-5 text-base rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/30 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3';
                result.innerHTML = `<p class="font-semibold">${data.message || 'NIS tidak ditemukan'}</p>`;
                santriCard.classList.add('hidden');
                currentSantri = null;
                flashEffect('red');
                return;
            }

            result.innerHTML = '';
            currentSantri = data.santri;

            document.getElementById('santri-nama').textContent = data.santri.nama;
            document.getElementById('santri-nis').textContent = data.santri.nis;
            document.getElementById('santri-kelas').textContent = data.santri.kelas;

            santriCard.classList.remove('hidden');

            if (data.izin_aktif) {
                izinAktifWarning.classList.remove('hidden');
                document.getElementById('izin-aktif-info').textContent = `${data.izin_aktif.keperluan} (Keluar: ${data.izin_aktif.waktu_keluar})`;
                formIzin.classList.add('hidden');
            } else {
                izinAktifWarning.classList.add('hidden');
                formIzin.classList.remove('hidden');
                keperluanInput.value = '';
                keperluanInput.focus();
            }

            flashEffect('purple');
            input.value = '';
        })
        .catch((err) => {
            console.error('Error:', err);
            result.className = 'mt-5 text-base rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/30 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3';
            result.textContent = 'Terjadi kesalahan saat mengirim data.';
            showToast('error', 'Koneksi gagal');
        });
    }

    btnSubmitIzin.addEventListener('click', function() {
        if (!currentSantri) {
            showToast('error', 'Silakan scan NIS terlebih dahulu');
            return;
        }

        const keperluan = keperluanInput.value.trim();
        if (!keperluan) {
            showToast('error', 'Keperluan izin harus diisi');
            keperluanInput.focus();
            return;
        }

        btnSubmitIzin.disabled = true;
        btnSubmitIzin.innerHTML = '<svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Menyimpan...';

        fetch('/izin/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nis: currentSantri.nis,
                keperluan: keperluan
            })
        })
        .then(async res => {
            const data = await res.json();

            if (data.success) {
                result.className = 'mt-5 text-base rounded-lg border border-green-200 bg-green-50 dark:bg-green-900/30 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3';
                result.innerHTML = `
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-1 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-7.5 9.5a.75.75 0 01-1.127.075l-3.5-3.5a.75.75 0 011.06-1.06l2.894 2.893 6.973-8.834a.75.75 0 011.057-.126z" clip-rule="evenodd"/></svg>
                        <div>
                            <p class="font-semibold">${data.message}</p>
                            <p class="mt-1 text-sm opacity-90">
                                ${data.data.nama} (${data.data.kelas}) • ${data.data.keperluan} • Keluar: ${data.data.waktu_keluar}
                            </p>
                        </div>
                    </div>
                `;
                flashEffect('green');
                showToast('success', data.message);
                playSound('success');

                santriCard.classList.add('hidden');
                currentSantri = null;
                input.focus();
            } else {
                result.className = 'mt-5 text-base rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/30 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3';
                result.innerHTML = `<p class="font-semibold">${data.message}</p>`;
                flashEffect('red');
                showToast('error', data.message);
            }

            btnSubmitIzin.disabled = false;
            btnSubmitIzin.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> Simpan Izin';
        })
        .catch(err => {
            console.error(err);
            showToast('error', 'Gagal menyimpan izin');
            btnSubmitIzin.disabled = false;
            btnSubmitIzin.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> Simpan Izin';
        });
    });

    btnKembali.addEventListener('click', function() {
        if (!currentSantri) return;

        btnKembali.disabled = true;
        btnKembali.innerHTML = '<svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Memproses...';

        fetch('/izin/kembali', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nis: currentSantri.nis })
        })
        .then(async res => {
            const data = await res.json();

            if (data.success) {
                result.className = 'mt-5 text-base rounded-lg border border-green-200 bg-green-50 dark:bg-green-900/30 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3';
                result.innerHTML = `
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-1 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-7.5 9.5a.75.75 0 01-1.127.075l-3.5-3.5a.75.75 0 011.06-1.06l2.894 2.893 6.973-8.834a.75.75 0 011.057-.126z" clip-rule="evenodd"/></svg>
                        <div>
                            <p class="font-semibold">${data.message}</p>
                            <p class="mt-1 text-sm opacity-90">
                                ${data.data.nama} (${data.data.kelas}) • Kembali: ${data.data.waktu_kembali}
                            </p>
                        </div>
                    </div>
                `;
                flashEffect('green');
                showToast('success', data.message);
                playSound('success');

                santriCard.classList.add('hidden');
                currentSantri = null;
                input.focus();
            } else {
                showToast('error', data.message);
            }

            btnKembali.disabled = false;
            btnKembali.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Tandai Sudah Kembali';
        })
        .catch(err => {
            console.error(err);
            showToast('error', 'Gagal memproses');
            btnKembali.disabled = false;
            btnKembali.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Tandai Sudah Kembali';
        });
    });

    function flashEffect(color) {
        const colors = {
            green: 'ring-4 ring-green-400',
            red: 'ring-4 ring-red-400',
            purple: 'ring-4 ring-purple-400'
        };
        card.classList.add(...colors[color].split(' '));
        setTimeout(() => card.classList.remove(...colors[color].split(' ')), 500);
    }

    function showToast(type, message) {
        const colors = {
            success: 'bg-green-500',
            warning: 'bg-amber-500',
            error: 'bg-red-500'
        };
        const toast = document.createElement('div');
        toast.className = `${colors[type]} text-white px-4 py-2 rounded-md shadow-md animate-fade-in-down`;
        toast.innerHTML = `<strong>${type.toUpperCase()}</strong>: ${message}`;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-x-5');
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    function playSound(type) {
        try {
            const sounds = {
                success: 'https://cdn.pixabay.com/download/audio/2022/03/15/audio_16e68d9620.mp3?filename=success-1-6297.mp3',
                error: 'https://cdn.pixabay.com/download/audio/2022/03/15/audio_37a81e7b22.mp3?filename=error-2-126514.mp3'
            };
            const audio = new Audio(sounds[type]);
            audio.volume = 0.8;
            audio.play().catch(() => {});
        } catch {}
    }

    const style = document.createElement('style');
    style.textContent = `
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.4s ease forwards;
    }
    `;
    document.head.appendChild(style);

    window.addEventListener('load', () => input.focus());

    // Camera Scanner
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
            btnScanCamera.innerHTML = '<svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Membuka Kamera...';

            html5QrCode = new Html5Qrcode("qr-reader");

            const qrConfig = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };

            let cameraId = null;
            try {
                const devices = await Html5Qrcode.getCameras();
                if (devices && devices.length > 0) {
                    const backCamera = devices.find(d => d.label.toLowerCase().includes('back') || d.label.toLowerCase().includes('belakang'));
                    cameraId = backCamera ? backCamera.id : devices[0].id;
                }
            } catch (e) {
                console.log('Could not get cameras');
            }

            const startConfig = cameraId ? cameraId : { facingMode: "environment" };

            await html5QrCode.start(startConfig, qrConfig, onScanSuccess, onScanFailure);

            isScanning = true;
            btnScanCamera.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" /></svg> Kamera Aktif';
            btnScanCamera.classList.remove('bg-purple-600', 'hover:bg-purple-700');
            btnScanCamera.classList.add('bg-green-600', 'hover:bg-green-700');

        } catch (err) {
            console.error('Error starting camera:', err);
            showToast('error', 'Gagal membuka kamera');
            stopCamera();
        }
    });

    btnStopCamera.addEventListener('click', stopCamera);

    async function stopCamera() {
        if (html5QrCode && isScanning) {
            try {
                await html5QrCode.stop();
            } catch (e) {}
        }
        
        isScanning = false;
        html5QrCode = null;
        cameraContainer.classList.add('hidden');
        btnScanCamera.disabled = false;
        btnScanCamera.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" /></svg> Scan dengan Kamera';
        btnScanCamera.classList.remove('bg-green-600', 'hover:bg-green-700');
        btnScanCamera.classList.add('bg-purple-600', 'hover:bg-purple-700');
        
        const qrReader = document.getElementById('qr-reader');
        if (qrReader) qrReader.innerHTML = '';
    }

    function onScanSuccess(decodedText) {
        stopCamera();
        input.value = decodedText;
        fetchSantri(decodedText);
    }

    let scanFailCount = 0;
    function onScanFailure(error) {
        scanFailCount++;
        if (scanFailCount % 100 === 0) {
            console.log('Scanning...');
        }
    }
    </script>
</x-app-layout>
