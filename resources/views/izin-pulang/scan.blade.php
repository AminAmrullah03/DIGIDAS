<x-app-layout>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family:'Plus Jakarta Sans',sans-serif; }
.page { min-height:100vh; background:#f1f5f9; padding:32px 16px; }
.dark .page { background:#0f172a; }
.card { background:#fff; border:1px solid #e2e8f0; border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,.07); overflow:hidden; margin-bottom:20px; }
.dark .card { background:#1e293b; border-color:#334155; }
.card-header { background:linear-gradient(135deg,#064e3b,#065f46,#059669); padding:24px; text-align:center; }
.card-header h2 { color:#fff; font-size:1.25rem; font-weight:700; margin:0 0 4px; }
.card-header p { color:#6ee7b7; font-size:.825rem; margin:0; }
.card-body { padding:20px; }
.input-group { display:flex; gap:10px; margin-bottom:12px; }
.input, .textarea { width:100%; padding:11px 14px; border-radius:10px; border:1.5px solid #e2e8f0; background:#f8fafc; color:#1e293b; outline:none; box-sizing:border-box; }
.input:focus, .textarea:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,.12); }
.textarea { min-height:80px; resize:vertical; }
.dark .input, .dark .textarea { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.nis-input { flex:1; font-family:monospace; letter-spacing:.05em; }
.btn { border:none; cursor:pointer; font-weight:700; transition:.2s; }
.btn-cari { padding:12px 20px; border-radius:12px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; }
.btn-scan { width:100%; padding:11px; border-radius:12px; border:1.5px dashed #10b981; background:rgba(16,185,129,0.05); color:#059669; }
.btn-stop { width:100%; padding:9px; margin-top:10px; border-radius:10px; background:#fee2e2; color:#dc2626; }
.quick-links { display:flex; margin-top:16px; padding-top:16px; border-top:1px solid #f1f5f9; }
.quick-link { flex:1; text-align:center; padding:9px; border-radius:10px; background:#f8fafc; color:#64748b; text-decoration:none; font-size:.78rem; font-weight:700; }
.quick-link:hover { background:#ecfdf5; color:#059669; }
.santri-card { background:#fff; border:1px solid #e2e8f0; border-radius:20px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
.dark .santri-card { background:#1e293b; border-color:#334155; }
.profile { padding:18px 20px; display:flex; align-items:center; gap:14px; background:linear-gradient(135deg,#f0fdf4,#dcfce7); border-bottom:1px solid #bbf7d0; }
.avatar { width:48px; height:48px; border-radius:14px; background:linear-gradient(135deg,#10b981,#059669); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; }
.name { font-size:1rem; font-weight:800; color:#064e3b; margin:0 0 3px; }
.meta { font-size:.78rem; color:#059669; font-family:monospace; margin:0; }
.section { padding:16px 20px 20px; }
.label { display:block; margin:0 0 5px; color:#64748b; font-size:.75rem; font-weight:700; }
.help { margin:4px 0 0; color:#94a3b8; font-size:.7rem; }
.actions { display:flex; gap:10px; margin-top:12px; }
.btn-batal { flex:1; padding:11px; border-radius:10px; border:1.5px solid #e2e8f0; background:transparent; color:#64748b; }
.btn-save { flex:2; padding:11px; border-radius:10px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; }
.notice { margin:12px 20px 0; padding:12px; border-radius:10px; background:#fef3c7; color:#92400e; border:1px solid #fcd34d; font-size:.8rem; font-weight:700; }
.toast-wrap { position:fixed; top:20px; right:20px; z-index:999; display:flex; flex-direction:column; gap:8px; }
.toast { padding:12px 16px; border-radius:12px; color:#fff; font-size:.85rem; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,.15); }
.toast-success { background:linear-gradient(135deg,#059669,#10b981); }
.toast-error { background:linear-gradient(135deg,#dc2626,#ef4444); }
.toast-warning { background:linear-gradient(135deg,#d97706,#f59e0b); }
#camera-container { margin-top:12px; }
#qr-reader { border-radius:12px; overflow:hidden; }
</style>

<div class="page">
    <div style="max-width:480px;margin:0 auto;">
        <div class="card">
            <div class="card-header">
                <h2>Input Izin Pulang</h2>
                <p>Scan QR atau ketik NIS untuk catat izin pulang santri</p>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <input id="nis_input" type="text" class="input nis-input" placeholder="Ketik atau scan NIS..." autofocus>
                    <button id="btn-cari" class="btn btn-cari">Cari</button>
                </div>
                <button id="btn-scan-camera" class="btn btn-scan">Scan QR Code</button>
                <div id="camera-container" class="hidden">
                    <div id="qr-reader"></div>
                    <button id="btn-stop-camera" class="btn btn-stop">Tutup Kamera</button>
                </div>
                <div class="quick-links">
                    <a href="{{ route('izin-pulang.rekap') }}" class="quick-link">Rekap Izin Pulang</a>
                </div>
            </div>
        </div>

        <div id="santri-result" style="display:none;">
            <div class="santri-card">
                <div class="profile">
                    <div class="avatar" id="card-initial">?</div>
                    <div style="flex:1;min-width:0;">
                        <p class="name" id="card-nama">-</p>
                        <p class="meta" id="card-meta">-</p>
                    </div>
                    <button onclick="closeCard()" style="width:30px;height:30px;border-radius:8px;border:none;cursor:pointer;color:#64748b;background:rgba(0,0,0,.06);">x</button>
                </div>

                <div id="aktif-notice" class="notice" style="display:none;"></div>

                <div class="section" id="form-section">
                    <label class="label">Keperluan / Keterangan Pulang</label>
                    <textarea id="keperluan" class="textarea" placeholder="Contoh: Pulang liburan, urusan keluarga..."></textarea>
                    <label class="label" style="margin-top:10px;">Durasi Pulang</label>
                    <input id="durasi_hari" type="number" min="1" max="365" value="1" class="input">
                    <p class="help">Durasi dihitung per hari dari waktu izin pulang dicatat.</p>
                    <div class="actions">
                        <button class="btn btn-batal" onclick="closeCard()">Batal</button>
                        <button class="btn btn-save" id="btn-simpan" onclick="simpanIzinPulang()">Catat Izin Pulang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-wrap" id="toast-container"></div>

<script>
const CSRF = '{{ csrf_token() }}';
const nisInput = document.getElementById('nis_input');
let currentNis = null;
let debounceTimer = null;
let html5QrCode = null;
let isScanning = false;
let scanLocked = false;

document.getElementById('btn-cari').addEventListener('click', () => search(nisInput.value.trim()));
nisInput.addEventListener('keydown', e => { if(e.key === 'Enter') search(nisInput.value.trim()); });
nisInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    const nis = nisInput.value.trim();
    if(nis.length < 3) { document.getElementById('santri-result').style.display='none'; return; }
    debounceTimer = setTimeout(() => search(nis), 500);
});

async function search(nis) {
    if(!nis) { showToast('error', 'Masukkan NIS terlebih dahulu!'); return; }
    const btn = document.getElementById('btn-cari');
    btn.disabled = true; btn.textContent = '...';
    try {
        const res = await fetch(`/izin-pulang/santri?nis=${encodeURIComponent(nis)}`, { headers:{'Accept':'application/json'} });
        const data = await res.json();
        if(!data.success) { showToast('error', data.message || 'Santri tidak ditemukan'); return; }

        currentNis = data.santri.nis;
        document.getElementById('card-initial').textContent = data.santri.nama.charAt(0).toUpperCase();
        document.getElementById('card-nama').textContent = data.santri.nama;
        document.getElementById('card-meta').textContent = `Kelas ${data.santri.kelas} • NIS: ${data.santri.nis}`;

        if(data.izin_aktif) {
            document.getElementById('aktif-notice').style.display = 'block';
            document.getElementById('aktif-notice').textContent = `Masih izin pulang: ${data.izin_aktif.keperluan}. Tenggat kembali ${data.izin_aktif.batas_waktu_kembali}.`;
            document.getElementById('form-section').style.display = 'none';
        } else {
            document.getElementById('aktif-notice').style.display = 'none';
            document.getElementById('form-section').style.display = 'block';
            document.getElementById('durasi_hari').value = 1;
        }

        document.getElementById('santri-result').style.display = 'block';
        document.getElementById('santri-result').scrollIntoView({behavior:'smooth', block:'nearest'});
    } catch(err) {
        showToast('error', 'Terjadi kesalahan jaringan');
    } finally {
        btn.disabled = false; btn.textContent = 'Cari';
    }
}

async function simpanIzinPulang() {
    const keperluan = document.getElementById('keperluan').value.trim();
    const durasiHari = parseInt(document.getElementById('durasi_hari').value, 10);
    if(!keperluan) { showToast('error', 'Masukkan keperluan izin pulang!'); return; }
    if(!durasiHari || durasiHari < 1) { showToast('error', 'Durasi pulang minimal 1 hari!'); return; }

    const btn = document.getElementById('btn-simpan');
    btn.disabled = true; btn.textContent = 'Menyimpan...';
    try {
        const res = await fetch('/izin-pulang/store', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
            body: JSON.stringify({nis:currentNis, keperluan, durasi_hari:durasiHari})
        });
        const data = await res.json();
        if(data.success) {
            showToast('success', data.message || 'Izin pulang berhasil dicatat!');
            closeCard();
        } else {
            showToast('error', data.message || 'Gagal mencatat izin pulang');
        }
    } catch(err) {
        showToast('error', 'Terjadi kesalahan');
    } finally {
        btn.disabled = false; btn.textContent = 'Catat Izin Pulang';
    }
}

function closeCard() {
    document.getElementById('santri-result').style.display = 'none';
    document.getElementById('keperluan').value = '';
    document.getElementById('durasi_hari').value = 1;
    nisInput.value = '';
    nisInput.focus();
    currentNis = null;
}

const btnScan = document.getElementById('btn-scan-camera');
const camBox = document.getElementById('camera-container');
btnScan.addEventListener('click', async () => {
    if(isScanning) return;
    try {
        camBox.classList.remove('hidden');
        btnScan.textContent = 'Membuka kamera...';
        html5QrCode = new Html5Qrcode('qr-reader');
        const devices = await Html5Qrcode.getCameras().catch(()=>[]);
        const back = devices.find(d => d.label.toLowerCase().includes('back'));
        await html5QrCode.start(
            back ? back.id : {facingMode:'environment'},
            {fps:10, qrbox:{width:240,height:240}, aspectRatio:1},
            text => {
                if(scanLocked) return;
                scanLocked = true;
                stopCamera();
                nisInput.value = text;
                search(text).finally(() => setTimeout(() => scanLocked = false, 1000));
            },
            ()=>{}
        );
        isScanning = true;
        btnScan.textContent = 'Kamera Aktif';
    } catch(err) {
        showToast('error', 'Gagal membuka kamera');
        stopCamera();
    }
});
document.getElementById('btn-stop-camera').addEventListener('click', stopCamera);
async function stopCamera() {
    if(html5QrCode && isScanning) { try { await html5QrCode.stop(); } catch(e) {} }
    isScanning = false;
    html5QrCode = null;
    camBox.classList.add('hidden');
    btnScan.textContent = 'Scan QR Code';
    document.getElementById('qr-reader').innerHTML = '';
}

function showToast(type, message) {
    const toast = document.createElement('div');
    const cls = type === 'error' ? 'toast-error' : type === 'warning' ? 'toast-warning' : 'toast-success';
    toast.className = `toast ${cls}`;
    toast.textContent = message;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity .3s'; setTimeout(() => toast.remove(), 300); }, 3500);
}
</script>
</x-app-layout>
