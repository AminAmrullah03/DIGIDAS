<x-app-layout>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.absen-page { min-height: 100vh; background: #f1f5f9; padding: 32px 16px; }
.dark .absen-page { background: #0f172a; }

/* ── Scanner card ── */
.scanner-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 20px;
}
.dark .scanner-card { background: #1e293b; border-color: #334155; }

.scanner-header {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #059669 100%);
    padding: 24px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.scanner-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(16,185,129,0.15);
    pointer-events: none;
}
.scanner-header::after {
    content: '';
    position: absolute;
    bottom: -30px; left: 20%;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(6,78,59,0.4);
    pointer-events: none;
}
.scanner-header h2 { color: #fff; font-size: 1.25rem; font-weight: 700; margin: 0 0 4px; position: relative; z-index: 1; }
.scanner-header p  { color: #6ee7b7; font-size: 0.825rem; margin: 0; position: relative; z-index: 1; }

/* ── Status chip (live clock) ── */
.live-chip {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(0,0,0,0.2);
    border: 1px solid rgba(16,185,129,0.3);
    border-radius: 20px;
    padding: 6px 14px;
    margin-top: 14px;
    position: relative; z-index: 1;
}
.live-dot { width: 7px; height: 7px; border-radius: 50%; background: #34d399; animation: pulse-dot 1.5s ease-in-out infinite; }
@keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(0.8)} }
.live-chip span { color: #fff; font-size: 0.8rem; font-weight: 600; font-variant-numeric: tabular-nums; }

.scanner-body { padding: 20px; }

/* ── Input group ── */
.input-group { display: flex; gap: 10px; margin-bottom: 12px; }
.nis-input {
    flex: 1;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    color: #1e293b;
    font-size: 0.9rem; font-weight: 500;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    font-family: monospace; letter-spacing: 0.05em;
}
.dark .nis-input { background: #0f172a; border-color: #334155; color: #f1f5f9; }
.nis-input:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.12); }

.btn-cari {
    padding: 12px 20px;
    border-radius: 12px;
    background: linear-gradient(135deg, #059669, #10b981);
    color: #fff; font-weight: 600; font-size: 0.875rem;
    border: none; cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(16,185,129,0.3);
}
.btn-cari:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(16,185,129,0.4); }

.btn-scan {
    width: 100%; padding: 11px;
    border-radius: 12px;
    border: 1.5px dashed #10b981;
    background: rgba(16,185,129,0.05);
    color: #059669; font-weight: 600; font-size: 0.875rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all 0.2s;
}
.dark .btn-scan { color: #34d399; border-color: #34d399; background: rgba(52,211,153,0.05); }
.btn-scan:hover { background: rgba(16,185,129,0.1); }
.btn-scan.active { background: rgba(16,185,129,0.15); border-style: solid; }

.btn-stop {
    width: 100%; padding: 9px; margin-top: 10px;
    border-radius: 10px;
    background: #fee2e2; color: #dc2626;
    font-weight: 600; font-size: 0.8rem;
    border: none; cursor: pointer;
    transition: background 0.2s;
}
.btn-stop:hover { background: #fecaca; }
#camera-container { margin-top: 12px; }
#qr-reader { border-radius: 12px; overflow: hidden; }

/* ── Quick links ── */
.quick-links {
    display: flex; gap: 8px;
    margin-top: 16px; padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}
.dark .quick-links { border-color: #334155; }
.quick-link {
    flex: 1; text-align: center;
    padding: 8px; border-radius: 10px;
    background: #f8fafc; color: #64748b;
    font-size: 0.78rem; font-weight: 600;
    text-decoration: none; transition: all 0.15s;
}
.dark .quick-link { background: #0f172a; color: #94a3b8; }
.quick-link:hover { background: #ecfdf5; color: #059669; }
.dark .quick-link:hover { background: rgba(16,185,129,0.1); color: #34d399; }

/* ── Result card ── */
.result-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    animation: slideUp 0.3s cubic-bezier(0.34,1.2,0.64,1) forwards;
}
.dark .result-card { background: #1e293b; border-color: #334155; }

@keyframes slideUp {
    from { opacity:0; transform: translateY(20px); }
    to   { opacity:1; transform: translateY(0); }
}

/* ── Result states ── */
.result-success .result-icon-wrap { background: linear-gradient(135deg,#059669,#10b981); }
.result-already .result-icon-wrap { background: linear-gradient(135deg,#d97706,#f59e0b); }
.result-notime  .result-icon-wrap { background: linear-gradient(135deg,#475569,#64748b); }
.result-error   .result-icon-wrap { background: linear-gradient(135deg,#dc2626,#ef4444); }

.result-header {
    padding: 20px;
    display: flex; align-items: center; gap: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.dark .result-header { border-color: #334155; }

.result-icon-wrap {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.result-icon-wrap svg { color: #fff; }

.result-name { font-size: 1rem; font-weight: 700; color: #1e293b; margin: 0 0 3px; }
.dark .result-name { color: #f1f5f9; }
.result-meta { font-size: 0.78rem; color: #64748b; margin: 0; font-family: monospace; }
.dark .result-meta { color: #94a3b8; }
.result-msg { font-size: 0.82rem; font-weight: 600; margin: 0; }

.result-detail {
    padding: 14px 20px;
    display: flex; gap: 10px;
}
.detail-pill {
    flex: 1; padding: 10px 12px;
    border-radius: 10px;
    background: #f8fafc;
    text-align: center;
}
.dark .detail-pill { background: #0f172a; }
.detail-label { font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 3px; }
.detail-value { font-size: 0.9rem; font-weight: 700; color: #1e293b; margin: 0; }
.dark .detail-value { color: #f1f5f9; }

/* ── Toast ── */
.toast-wrap { position: fixed; top: 20px; right: 20px; z-index: 999; display: flex; flex-direction: column; gap: 8px; }
.toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 12px;
    font-size: 0.85rem; font-weight: 500; color: #fff;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    animation: toastIn 0.3s cubic-bezier(0.34,1.4,0.64,1) forwards;
    min-width: 240px;
}
@keyframes toastIn { from{opacity:0;transform:translateX(40px) scale(0.9)} to{opacity:1;transform:translateX(0) scale(1)} }
.toast-success { background: linear-gradient(135deg,#059669,#10b981); }
.toast-warning { background: linear-gradient(135deg,#d97706,#f59e0b); }
.toast-error   { background: linear-gradient(135deg,#dc2626,#ef4444); }
.toast-info    { background: linear-gradient(135deg,#475569,#64748b); }
</style>

<div class="absen-page">
    <div style="max-width:480px;margin:0 auto;">

        {{-- Scanner Card --}}
        <div class="scanner-card">
            <div class="scanner-header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;display:inline;margin-right:6px;vertical-align:-3px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                    </svg>
                    Scan Absensi
                </h2>
                <p>Scan QR Code atau ketik NIS santri</p>
                <div class="live-chip">
                    <div class="live-dot"></div>
                    <span id="live-clock">--:--:--</span>
                    <span style="color:#6ee7b7;font-size:0.7rem;">WIB</span>
                </div>
            </div>
            <div class="scanner-body">
                <div class="input-group">
                    <input id="nis_input" type="text" placeholder="Ketik atau scan NIS..." autofocus class="nis-input">
                    <button id="btn-cari" class="btn-cari">Cari</button>
                </div>

                <button id="btn-scan-camera" class="btn-scan">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                    </svg>
                    Scan QR Code
                </button>

                <div id="camera-container" class="hidden">
                    <div id="qr-reader"></div>
                    <button id="btn-stop-camera" class="btn-stop">✕ Tutup Kamera</button>
                </div>

                <div class="quick-links">
                    <a href="{{ route('rekap') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;display:inline;margin-right:4px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                        </svg>
                        Rekap Absensi
                    </a>
                    <a href="{{ route('dashboard') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;display:inline;margin-right:4px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        {{-- Result Card --}}
        <div id="result-card" style="display:none;">
            <div class="result-card" id="result-inner">
                <div class="result-header">
                    <div class="result-icon-wrap" id="result-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:26px;height:26px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p class="result-name" id="result-nama">-</p>
                        <p class="result-meta" id="result-meta">-</p>
                        <p class="result-msg" id="result-msg" style="color:#059669;margin-top:3px;">-</p>
                    </div>
                </div>
                <div class="result-detail">
                    <div class="detail-pill">
                        <p class="detail-label">Kegiatan</p>
                        <p class="detail-value" id="result-kegiatan">-</p>
                    </div>
                    <div class="detail-pill">
                        <p class="detail-label">Waktu</p>
                        <p class="detail-value" id="result-waktu">-</p>
                    </div>
                    <div class="detail-pill">
                        <p class="detail-label">Kelas</p>
                        <p class="detail-value" id="result-kelas">-</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="toast-wrap" id="toast-container"></div>

<script>
// ── Live clock ──
function updateClock() {
    const now = new Date();
    const s = n => String(n).padStart(2,'0');
    document.getElementById('live-clock').textContent = `${s(now.getHours())}:${s(now.getMinutes())}:${s(now.getSeconds())}`;
}
setInterval(updateClock, 1000);
updateClock();

const nisInput   = document.getElementById('nis_input');
const resultCard = document.getElementById('result-card');
let debounceTimer = null;

// ── Search triggers ──
document.getElementById('btn-cari').addEventListener('click', () => absen(nisInput.value.trim()));
nisInput.addEventListener('keydown', e => { if(e.key==='Enter') absen(nisInput.value.trim()); });
nisInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    const nis = nisInput.value.trim();
    if(nis.length < 3) { resultCard.style.display='none'; return; }
    debounceTimer = setTimeout(() => absen(nis), 500);
});

async function absen(nis) {
    if(!nis) { showToast('error','Masukkan NIS terlebih dahulu!'); return; }
    const btn = document.getElementById('btn-cari');
    btn.textContent='...'; btn.disabled=true;

    try {
        const res  = await fetch('/absen', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},
            body: JSON.stringify({nis})
        });
        const data = await res.json();

        const nama     = data.nama || '-';
        const kelas    = data.kelas || '-';
        const kegiatan = data.kegiatan || 'Tidak ada jadwal';
        const waktu    = data.waktu || '--:--:--';
        const msg      = data.message || '';

        document.getElementById('result-nama').textContent    = nama;
        document.getElementById('result-meta').textContent    = `Kelas ${kelas} • NIS: ${nis}`;
        document.getElementById('result-kegiatan').textContent = kegiatan;
        document.getElementById('result-waktu').textContent   = waktu;
        document.getElementById('result-kelas').textContent   = kelas;
        document.getElementById('result-msg').textContent     = msg;

        const inner = document.getElementById('result-inner');
        const iconWrap = document.getElementById('result-icon');
        inner.className = 'result-card';

        if(res.status === 200 && data.kegiatan) {
            if(msg.includes('sudah absen')) {
                inner.classList.add('result-already');
                document.getElementById('result-msg').style.color = '#d97706';
                iconWrap.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:26px;height:26px;color:#fff;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>`;
                showToast('warning', 'Sudah absen hari ini!');
            } else {
                inner.classList.add('result-success');
                document.getElementById('result-msg').style.color = '#059669';
                iconWrap.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:26px;height:26px;color:#fff;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
                showToast('success', `Absensi ${nama} berhasil!`);
            }
        } else if(res.status === 200 && !data.kegiatan) {
            inner.classList.add('result-notime');
            document.getElementById('result-msg').style.color = '#64748b';
            iconWrap.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:26px;height:26px;color:#fff;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
            showToast('info', 'Di luar waktu absensi');
        } else {
            inner.classList.add('result-error');
            document.getElementById('result-msg').style.color = '#dc2626';
            iconWrap.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:26px;height:26px;color:#fff;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>`;
            showToast('error', msg || 'NIS tidak ditemukan!');
        }

        resultCard.style.display='block';
        resultCard.scrollIntoView({behavior:'smooth',block:'nearest'});
        setTimeout(() => { nisInput.value=''; nisInput.focus(); }, 2000);

    } catch(err) {
        showToast('error', 'Terjadi kesalahan jaringan');
    } finally {
        btn.textContent='Cari'; btn.disabled=false;
    }
}

// ── Camera ──
let html5QrCode=null, isScanning=false;
const btnScan = document.getElementById('btn-scan-camera');
const camBox  = document.getElementById('camera-container');

btnScan.addEventListener('click', async () => {
    if(isScanning) return;
    try {
        camBox.classList.remove('hidden');
        btnScan.classList.add('active');
        btnScan.textContent = 'Membuka kamera...';
        html5QrCode = new Html5Qrcode('qr-reader');
        const devices = await Html5Qrcode.getCameras().catch(()=>[]);
        const back    = devices.find(d => d.label.toLowerCase().includes('back'));
        await html5QrCode.start(
            back ? back.id : {facingMode:'environment'},
            {fps:10, qrbox:{width:240,height:240}, aspectRatio:1.0},
            text => { stopCamera(); nisInput.value=text; absen(text); },
            ()=>{}
        );
        isScanning = true;
        btnScan.textContent = '● Kamera Aktif';
    } catch(err) {
        showToast('error','Gagal membuka kamera');
        stopCamera();
    }
});

document.getElementById('btn-stop-camera').addEventListener('click', stopCamera);

async function stopCamera() {
    if(html5QrCode && isScanning) { try{ await html5QrCode.stop(); }catch(e){} }
    isScanning=false; html5QrCode=null;
    camBox.classList.add('hidden');
    btnScan.classList.remove('active');
    btnScan.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg> Scan QR Code`;
    document.getElementById('qr-reader').innerHTML='';
}

// ── Toast ──
function showToast(type, message) {
    const toast = document.createElement('div');
    const typeMap = {success:'toast-success',warning:'toast-warning',error:'toast-error',info:'toast-info'};
    const icon = type==='success'?'✓':type==='warning'?'⚠':type==='info'?'ℹ':'✕';
    toast.className = `toast ${typeMap[type]||'toast-info'}`;
    toast.innerHTML = `<span>${icon}</span> ${message}`;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(()=>{ toast.style.opacity='0'; toast.style.transition='opacity 0.3s'; setTimeout(()=>toast.remove(),300); }, 3500);
}

window.addEventListener('load', ()=>nisInput.focus());
</script>
</x-app-layout>