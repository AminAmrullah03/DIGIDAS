<x-app-layout>
    <div class="py-12 transition-colors duration-300 bg-gray-50 min-h-screen relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center">
                <div class="w-full max-w-md">
                    <div id="absen-card" class="bg-white shadow-sm sm:rounded-xl p-6 transition-all duration-500">
                        <div class="mb-4 text-center">
                            <h2 class="text-2xl font-bold text-gray-900">📷 Absensi Santri</h2>
                            <p class="mt-1 text-sm text-gray-600">Scan atau ketik NIS — otomatis kirim setelah berhenti mengetik.</p>
                        </div>

                        <label for="nis_input" class="sr-only">NIS</label>
                        <input id="nis_input" type="text" placeholder="Scan NIS di sini..." autofocus
                            class="block w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" />

                        <div id="result" class="mt-5 text-base transition-all duration-500 ease-in-out"></div>

                        <div class="mt-6 flex items-center justify-between text-xs text-gray-500">
                            <a href="/rekap" class="text-blue-600 hover:text-blue-700 font-medium">Lihat rekap →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast container -->
        <div id="toast-container" class="fixed top-5 right-5 flex flex-col gap-2 z-50"></div>
    </div>

    <script>
    const input = document.getElementById('nis_input');
    const result = document.getElementById('result');
    const card = document.getElementById('absen-card');
    const toastContainer = document.getElementById('toast-container');

    let typingTimer;
    const delay = 400; // jeda 0.4 detik setelah berhenti mengetik

    input.addEventListener('input', function() {
        clearTimeout(typingTimer);
        if (input.value.trim().length >= 3) {
            typingTimer = setTimeout(() => {
                submitNIS(input.value.trim());
            }, delay);
        }
    });

    function submitNIS(nis) {
        result.className = 'mt-5 text-base';
        result.innerHTML = '<div class="flex items-center gap-2 text-gray-600"><svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Memproses...</div>';

        fetch('/absen', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nis })
        })
        .then(async res => {
            const data = await res.json().catch(() => ({ message: 'Terjadi kesalahan' }));

            let type = 'success';
            if (!res.ok) type = 'error';
            else if (data.message && data.message.toLowerCase().includes('sudah absen')) type = 'warning';
            else if (data.message && data.message.toLowerCase().includes('bukan waktu')) type = 'error';

            const classes = {
                success: 'rounded-lg border border-green-200 bg-green-50 text-green-800 px-4 py-3 shadow-md',
                warning: 'rounded-lg border border-amber-200 bg-amber-50 text-amber-800 px-4 py-3 shadow-md',
                error: 'rounded-lg border border-red-200 bg-red-50 text-red-800 px-4 py-3 shadow-md'
            };

            result.className = `mt-5 text-base ${classes[type]}`;
            result.innerHTML = `
                <div class="flex items-start gap-3">
                    ${type === 'success' ? '<svg class="w-5 h-5 mt-1 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-7.5 9.5a.75.75 0 01-1.127.075l-3.5-3.5a.75.75 0 011.06-1.06l2.894 2.893 6.973-8.834a.75.75 0 011.057-.126z" clip-rule="evenodd"/></svg>' : ''}
                    ${type === 'warning' ? '<svg class="w-5 h-5 mt-1 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.72-1.36 3.485 0l6.518 11.59c.75 1.334-.213 2.987-1.742 2.987H3.48c-1.53 0-2.492-1.653-1.743-2.988L8.257 3.1zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-2a1 1 0 01-1-1V8a1 1 0 112 0v3a1 1 0 01-1 1z" clip-rule="evenodd"/></svg>' : ''}
                    ${type === 'error' ? '<svg class="w-5 h-5 mt-1 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-10.95a.75.75 0 10-1.06-1.06L10 8.94 7.525 6.465a.75.75 0 10-1.06 1.06L8.94 10l-2.475 2.475a.75.75 0 101.06 1.06L10 11.06l2.475 2.475a.75.75 0 101.06-1.06L11.06 10l2.475-2.475z" clip-rule="evenodd"/></svg>' : ''}
                    <div>
                        <p class="font-semibold">${data.message || 'Terjadi kesalahan'}</p>
                        ${data.nama ? `
                            <p class="mt-1 text-sm opacity-90">
                                ${data.nama} (${data.kelas}) • ${data.kegiatan || '-'} • ${data.waktu}
                            </p>
                        ` : ''}
                    </div>
                </div>
            `;

            // efek & suara
            if (type === 'success') flashEffect('green');
            else if (type === 'error') flashEffect('red');

            showToast(type, data.message);
            input.value = '';
            input.focus();

            try {
                const sounds = {
                    success: 'https://cdn.pixabay.com/download/audio/2022/03/15/audio_16e68d9620.mp3?filename=success-1-6297.mp3',
                    warning: 'https://cdn.pixabay.com/download/audio/2022/03/15/audio_d0c85dd11b.mp3?filename=notification-2-2735.mp3',
                    error: 'https://cdn.pixabay.com/download/audio/2022/03/15/audio_37a81e7b22.mp3?filename=error-2-126514.mp3'
                };
                const audio = new Audio(sounds[type]);
                audio.volume = 0.8;
                audio.play().catch(() => console.warn('Gagal memutar audio'));
            } catch {}
        })
        .catch((err) => {
            console.error('Error:', err);
            result.className = 'mt-5 text-base rounded-lg border border-red-200 bg-red-50 text-red-800 px-4 py-3';
            result.textContent = 'Terjadi kesalahan saat mengirim data. Pastikan koneksi stabil.';
            showToast('error', 'Koneksi gagal atau server tidak merespons.');
        });
    }

    // efek flash warna pada card
    function flashEffect(color) {
        const colors = {
            green: 'ring-4 ring-green-400 bg-green-50',
            red: 'ring-4 ring-red-400 bg-red-50'
        };
        card.classList.add(...colors[color].split(' '));
        setTimeout(() => card.classList.remove(...colors[color].split(' ')), 500);
    }

    // toast kecil di kanan atas
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

    // animasi CSS toast
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
    </script>
</x-app-layout>
