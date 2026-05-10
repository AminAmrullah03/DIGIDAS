<x-app-layout>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.izin-page { min-height: 100vh; background: #f1f5f9; padding: 32px 16px; }
.dark .izin-page { background: #0f172a; }

/* ── Card base ── */
.main-card {
    background: #fff; border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 20px;
}
.dark .main-card { background: #1e293b; border-color: #334155; }

.card-header {
    background: linear-gradient(135deg,#064e3b 0%,#065f46 50%,#059669 100%);
    padding: 24px; text-align: center; position: relative; overflow: hidden;
}
.card-header::before {
    content:''; position:absolute; top:-40px; right:-40px;
    width:140px; height:140px; border-radius:50%;
    background:rgba(16,185,129,0.15); pointer-events:none;
}
.card-header::after {
    content:''; position:absolute; bottom:-30px; left:20%;
    width:100px; height:100px; border-radius:50%;
    background:rgba(6,78,59,0.4); pointer-events:none;
}
.card-header h2 { color:#fff; font-size:1.25rem; font-weight:700; margin:0 0 4px; position:relative; z-index:1; }
.card-header p  { color:#6ee7b7; font-size:0.825rem; margin:0; position:relative; z-index:1; }

.card-body { padding: 20px; }

/* ── Input ── */
.input-group { display:flex; gap:10px; margin-bottom:12px; }
.nis-input {
    flex:1; padding:12px 16px; border-radius:12px;
    border:1.5px solid #e2e8f0; background:#f8fafc;
    color:#1e293b; font-size:0.9rem; font-weight:500;
    outline:none; transition:border-color 0.2s, box-shadow 0.2s;
    font-family:monospace; letter-spacing:0.05em;
}
.dark .nis-input { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.nis-input:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.12); }

.btn-cari {
    padding:12px 20px; border-radius:12px;
    background:linear-gradient(135deg,#059669,#10b981);
    color:#fff; font-weight:600; font-size:0.875rem;
    border:none; cursor:pointer; transition:all 0.2s;
    box-shadow:0 2px 8px rgba(16,185,129,0.3);
}
.btn-cari:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(16,185,129,0.4); }

.btn-scan {
    width:100%; padding:11px; border-radius:12px;
    border:1.5px dashed #10b981; background:rgba(16,185,129,0.05);
    color:#059669; font-weight:600; font-size:0.875rem;
    cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;
    transition:all 0.2s;
}
.dark .btn-scan { color:#34d399; border-color:#34d399; background:rgba(52,211,153,0.05); }
.btn-scan:hover { background:rgba(16,185,129,0.1); }
.btn-scan.active { background:rgba(16,185,129,0.15); border-style:solid; }

.btn-stop {
    width:100%; padding:9px; margin-top:10px; border-radius:10px;
    background:#fee2e2; color:#dc2626; font-weight:600; font-size:0.8rem;
    border:none; cursor:pointer; transition:background 0.2s;
}
.btn-stop:hover { background:#fecaca; }
#camera-container { margin-top:12px; }
#qr-reader { border-radius:12px; overflow:hidden; }

/* ── Quick links ── */
.quick-links { display:flex; gap:8px; margin-top:16px; padding-top:16px; border-top:1px solid #f1f5f9; }
.dark .quick-links { border-color:#334155; }
.quick-link {
    flex:1; text-align:center; padding:8px; border-radius:10px;
    background:#f8fafc; color:#64748b; font-size:0.78rem; font-weight:600;
    text-decoration:none; transition:all 0.15s;
}
.dark .quick-link { background:#0f172a; color:#94a3b8; }
.quick-link:hover { background:#ecfdf5; color:#059669; }
.dark .quick-link:hover { background:rgba(16,185,129,0.1); color:#34d399; }

/* ── Santri info card ── */
.santri-card {
    background:#fff; border-radius:20px;
    box-shadow:0 4px 24px rgba(0,0,0,0.08);
    border:1px solid #e2e8f0; overflow:hidden;
    animation:slideUp 0.3s cubic-bezier(0.34,1.2,0.64,1) forwards;
}
.dark .santri-card { background:#1e293b; border-color:#334155; }
@keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

.profile-header {
    padding:18px 20px; display:flex; align-items:center; gap:14px;
    background:linear-gradient(135deg,#f0fdf4,#dcfce7);
    border-bottom:1px solid #bbf7d0;
}
.dark .profile-header { background:linear-gradient(135deg,rgba(16,185,129,0.1),rgba(5,150,105,0.08)); border-color:rgba(16,185,129,0.2); }

.avatar {
    width:48px; height:48px; border-radius:14px;
    background:linear-gradient(135deg,#10b981,#059669);
    display:flex; align-items:center; justify-content:center;
    font-size:1.2rem; font-weight:700; color:#fff; flex-shrink:0;
    box-shadow:0 4px 12px rgba(16,185,129,0.3);
}
.profile-name { font-size:1rem; font-weight:700; color:#064e3b; margin:0 0 3px; }
.dark .profile-name { color:#6ee7b7; }
.profile-meta { font-size:0.78rem; color:#059669; font-family:monospace; margin:0; }
.dark .profile-meta { color:#34d399; }

/* ── Status badge (izin aktif) ── */
.izin-aktif-banner {
    margin:0 20px 0; padding:12px 14px; border-radius:10px;
    background:#fef3c7; border:1px solid #fcd34d;
    display:flex; align-items:center; gap:10px;
}
.dark .izin-aktif-banner { background:rgba(245,158,11,0.12); border-color:rgba(252,211,77,0.3); }
.izin-aktif-banner p { font-size:0.8rem; font-weight:600; color:#92400e; margin:0; }
.dark .izin-aktif-banner p { color:#fcd34d; }

/* ── Form perizinan ── */
.izin-form-section { padding:16px 20px 20px; }
.form-label { font-size:0.75rem; font-weight:600; color:#64748b; display:block; margin-bottom:5px; }
.dark .form-label { color:#94a3b8; }
.form-textarea {
    width:100%; padding:10px 12px; border-radius:10px;
    border:1.5px solid #e2e8f0; background:#f8fafc;
    color:#1e293b; font-size:0.875rem; resize:vertical;
    outline:none; transition:border-color 0.2s;
    font-family:'Plus Jakarta Sans',sans-serif;
    box-sizing:border-box; min-height:80px;
}
.dark .form-textarea { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.form-textarea:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.1); }
.form-input {
    width:100%; padding:10px 12px; border-radius:10px;
    border:1.5px solid #e2e8f0; background:#f8fafc;
    color:#1e293b; font-size:0.875rem;
    outline:none; transition:border-color 0.2s;
    font-family:'Plus Jakarta Sans',sans-serif;
    box-sizing:border-box;
}
.dark .form-input { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.form-input:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.1); }
.form-help { font-size:0.7rem; color:#94a3b8; margin:4px 0 0; }

.form-actions { display:flex; gap:10px; margin-top:12px; }
.btn-batal {
    flex:1; padding:11px; border-radius:10px;
    border:1.5px solid #e2e8f0; background:transparent;
    color:#64748b; font-weight:600; font-size:0.875rem;
    cursor:pointer; transition:all 0.15s;
}
.dark .btn-batal { border-color:#334155; color:#94a3b8; }
.btn-batal:hover { background:#f8fafc; }
.btn-izin {
    flex:2; padding:11px; border-radius:10px;
    background:linear-gradient(135deg,#059669,#10b981);
    color:#fff; font-weight:700; font-size:0.875rem;
    border:none; cursor:pointer; transition:all 0.2s;
    box-shadow:0 2px 8px rgba(16,185,129,0.3);
}
.btn-izin:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(16,185,129,0.4); }
.btn-izin:disabled { opacity:0.6; cursor:not-allowed; transform:none; }

.btn-kembali {
    width:100%; padding:11px; border-radius:10px;
    background:linear-gradient(135deg,#dc2626,#ef4444);
    color:#fff; font-weight:700; font-size:0.875rem;
    border:none; cursor:pointer; transition:all 0.2s;
    box-shadow:0 2px 8px rgba(220,38,38,0.3);
}
.btn-kembali:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(220,38,38,0.4); }

/* ── Toast ── */
.toast-wrap { position:fixed; top:20px; right:20px; z-index:999; display:flex; flex-direction:column; gap:8px; }
.toast {
    display:flex; align-items:center; gap:10px;
    padding:12px 16px; border-radius:12px;
    font-size:0.85rem; font-weight:500; color:#fff;
    box-shadow:0 8px 24px rgba(0,0,0,0.15);
    animation:toastIn 0.3s cubic-bezier(0.34,1.4,0.64,1) forwards;
    min-width:240px;
}
@keyframes toastIn { from{opacity:0;transform:translateX(40px) scale(0.9)} to{opacity:1;transform:translateX(0) scale(1)} }
.toast-success { background:linear-gradient(135deg,#059669,#10b981); }
.toast-error   { background:linear-gradient(135deg,#dc2626,#ef4444); }
.toast-warning { background:linear-gradient(135deg,#d97706,#f59e0b); }
</style>

<div class="izin-page">
    <div style="max-width:480px;margin:0 auto;">

        {{-- Scanner Card --}}
        <div class="main-card">
            <div class="card-header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;display:inline;margin-right:6px;vertical-align:-3px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                    </svg>
                    Input Izin Keluar
                </h2>
                <p>Scan QR atau ketik NIS untuk catat izin keluar santri</p>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <input id="nis_input" type="text" placeholder="Ketik atau scan NIS..." autofocus class="nis-input">
                    <button id="btn-cari" class="btn-cari">Cari</button>
                </div>

                <button id="btn-scan-camera" class="btn-scan">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                    </svg>
                    Scan QR Code
                </button>

                <div id="camera-container" class="hidden">
                    <div id="qr-reader"></div>
                    <button id="btn-stop-camera" class="btn-stop">✕ Tutup Kamera</button>
                </div>

                <div class="quick-links">
                    <a href="{{ route('izin.rekap') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                        Rekap Izin Keluar
                    </a>
                </div>
            </div>
        </div>

        {{-- Santri Result Card --}}
        <div id="santri-result" style="display:none;">
            <div class="santri-card">
                {{-- Profile --}}
                <div class="profile-header">
                    <div class="avatar" id="card-initial">?</div>
                    <div style="flex:1;min-width:0;">
                        <p class="profile-name" id="card-nama">-</p>
                        <p class="profile-meta" id="card-meta">-</p>
                    </div>
                    <button onclick="closeCard()" style="width:30px;height:30px;border-radius:8px;background:rgba(0,0,0,0.06);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;transition:background 0.15s;flex-shrink:0;" onmouseover="this.style.background='rgba(239,68,68,0.1)';this.style.color='#ef4444';" onmouseout="this.style.background='rgba(0,0,0,0.06)';this.style.color='#64748b';">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Izin Aktif Warning --}}
                <div id="izin-aktif-section" style="display:none;padding:12px 20px 0;">
                    <div class="izin-aktif-banner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                        <div>
                            <p id="izin-aktif-msg" style="font-size:0.8rem;font-weight:600;color:#92400e;margin:0;">Santri sedang dalam izin</p>
                            <p id="izin-aktif-sub" style="font-size:0.73rem;color:#b45309;margin:0;margin-top:1px;"></p>
                        </div>
                    </div>
                </div>

                {{-- Form Izin --}}
                <div class="izin-form-section" id="form-izin-section">
                    <label class="form-label">Keperluan / Tujuan Izin</label>
                    <textarea id="keperluan" class="form-textarea" placeholder="Contoh: Pulang karena ada acara keluarga..."></textarea>
                    <label class="form-label" style="margin-top:10px;">Tenggat Kembali</label>
                    <input id="batas_waktu_kembali" type="datetime-local" class="form-input">
                    <p class="form-help">Maksimal 1 hari dari waktu izin keluar.</p>
                    <div class="form-actions">
                        <button class="btn-batal" onclick="closeCard()">Batal</button>
                        <button class="btn-izin" id="btn-simpan-izin" onclick="simpanIzin()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                            Catat Izin Keluar
                        </button>
                    </div>
                </div>

                {{-- Tombol Kembali (jika sedang izin keluar) --}}
                <div class="izin-form-section" id="form-kembali-section" style="display:none;">
                    <button class="btn-kembali" id="btn-kembali" onclick="catatKembali()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;display:inline;margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                        Catat Sudah Kembali
                    </button>
                    <button class="btn-batal" style="width:100%;margin-top:8px;" onclick="closeCard()">Batal</button>
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
let currentIzinId = null;
let debounceTimer = null;
let scanLocked = false;
const batasInput = document.getElementById('batas_waktu_kembali');

// ── Search ──
document.getElementById('btn-cari').addEventListener('click', () => search(nisInput.value.trim()));
nisInput.addEventListener('keydown', e => { if(e.key==='Enter') search(nisInput.value.trim(), true); });
nisInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    const nis = nisInput.value.trim();
    if(nis.length < 3) { document.getElementById('santri-result').style.display='none'; return; }
    debounceTimer = setTimeout(() => search(nis), 500);
});

async function search(nis, autoKembali = false) {
    if(!nis) { showToast('error','Masukkan NIS terlebih dahulu!'); return; }
    const btn = document.getElementById('btn-cari');
    btn.textContent='...'; btn.disabled=true;
    try {
        const res  = await fetch(`/izin/santri?nis=${encodeURIComponent(nis)}`, { headers:{'Accept':'application/json'} });
        const data = await res.json();
        if(!data.success) { showToast('error', data.message || 'Santri tidak ditemukan'); return; }

        currentNis = data.santri.nis;
        currentIzinId = data.izin_aktif ? data.izin_aktif.id : null;

        document.getElementById('card-initial').textContent = data.santri.nama.charAt(0).toUpperCase();
        document.getElementById('card-nama').textContent    = data.santri.nama;
        document.getElementById('card-meta').textContent   = `Kelas ${data.santri.kelas} • NIS: ${data.santri.nis}`;

        if(data.izin_aktif) {
            if(autoKembali) {
                await catatKembali(true);
                return;
            }

            document.getElementById('izin-aktif-section').style.display='block';
            document.getElementById('izin-aktif-msg').textContent = `Sedang dalam izin keluar: ${data.izin_aktif.keperluan}`;
            document.getElementById('izin-aktif-sub').textContent = `Keluar sejak: ${data.izin_aktif.waktu_keluar} • Tenggat: ${data.izin_aktif.batas_waktu_kembali} • Durasi: ${data.izin_aktif.durasi_label}`;
            document.getElementById('form-izin-section').style.display='none';
            document.getElementById('form-kembali-section').style.display='block';
        } else {
            document.getElementById('izin-aktif-section').style.display='none';
            document.getElementById('form-izin-section').style.display='block';
            document.getElementById('form-kembali-section').style.display='none';
            syncBatasRange();
            if(data.izin_terakhir?.status === 'Kabur') {
                showToast('warning', 'Izin keluar terakhir santri ini tercatat Kabur.');
            }
        }

        document.getElementById('santri-result').style.display='block';
        document.getElementById('santri-result').scrollIntoView({behavior:'smooth',block:'nearest'});
    } catch(err) {
        showToast('error','Terjadi kesalahan jaringan');
    } finally {
        btn.textContent='Cari'; btn.disabled=false;
    }
}

// ── Simpan izin ──
async function simpanIzin() {
    const keperluan = document.getElementById('keperluan').value.trim();
    if(!keperluan) { showToast('error','Masukkan keperluan izin keluar!'); return; }
    const batasWaktu = batasInput.value;
    if(!batasWaktu) { showToast('error','Tentukan tenggat kembali!'); return; }
    const btn = document.getElementById('btn-simpan-izin');
    btn.disabled=true; btn.textContent='Menyimpan...';
    try {
        const res  = await fetch('/izin/store', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
            body: JSON.stringify({nis:currentNis, keperluan, batas_waktu_kembali:batasWaktu})
        });
        const data = await res.json();
        if(data.success) {
            showToast('success', data.message || 'Izin keluar berhasil dicatat!');
            currentIzinId = data.data?.id || null;
            document.getElementById('izin-aktif-section').style.display='block';
            document.getElementById('izin-aktif-msg').textContent = `Sedang dalam izin keluar: ${keperluan}`;
            document.getElementById('izin-aktif-sub').textContent = `Keluar sejak: ${data.data?.waktu_keluar || 'baru saja'} • Tenggat: ${data.data?.batas_waktu_kembali || '-'} • Durasi: ${data.data?.durasi_label || '-'}`;
            document.getElementById('form-izin-section').style.display='none';
            document.getElementById('form-kembali-section').style.display='block';
            document.getElementById('keperluan').value='';
            nisInput.value='';
        } else {
            showToast('error', data.message || 'Gagal mencatat izin keluar');
        }
    } catch(err) {
        showToast('error','Terjadi kesalahan');
    } finally {
        btn.disabled=false; btn.textContent='Catat Izin Keluar';
    }
}

// ── Catat kembali ──
async function catatKembali(dariScan = false) {
    const btn = document.getElementById('btn-kembali');
    btn.disabled=true; btn.textContent=dariScan ? 'Scan kembali diproses...' : 'Menyimpan...';
    try {
        const res  = await fetch('/izin/kembali', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
            body: JSON.stringify({nis:currentNis})
        });
        const data = await res.json();
        if(data.success) {
            showToast(data.data?.status === 'Terlambat' ? 'warning' : 'success', data.message || 'Santri sudah kembali!');
            closeCard();
        } else {
            showToast('error', data.message || 'Gagal mencatat kembali');
        }
    } catch(err) {
        showToast('error','Terjadi kesalahan');
    } finally {
        btn.disabled=false; btn.textContent='Catat Sudah Kembali';
    }
}

function closeCard() {
    document.getElementById('santri-result').style.display='none';
    document.getElementById('keperluan').value='';
    syncBatasRange();
    nisInput.value=''; nisInput.focus();
    currentNis=null; currentIzinId=null;
}

function pad(num) {
    return String(num).padStart(2, '0');
}

function toDatetimeLocalValue(date) {
    return `${date.getFullYear()}-${pad(date.getMonth()+1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
}

function syncBatasRange() {
    const now = new Date();
    const min = new Date(now.getTime() + 60 * 1000);
    const defaultDeadline = new Date(now.getTime() + 2 * 60 * 60 * 1000);
    const max = new Date(now.getTime() + 24 * 60 * 60 * 1000);
    batasInput.min = toDatetimeLocalValue(min);
    batasInput.max = toDatetimeLocalValue(max);
    batasInput.value = toDatetimeLocalValue(defaultDeadline > max ? max : defaultDeadline);
}

// ── Camera ──
let html5QrCode=null, isScanning=false;
const btnScan = document.getElementById('btn-scan-camera');
const camBox  = document.getElementById('camera-container');

btnScan.addEventListener('click', async () => {
    if(isScanning) return;
    try {
        camBox.classList.remove('hidden'); btnScan.classList.add('active');
        btnScan.textContent='Membuka kamera...';
        html5QrCode = new Html5Qrcode('qr-reader');
        const devices = await Html5Qrcode.getCameras().catch(()=>[]);
        const back    = devices.find(d => d.label.toLowerCase().includes('back'));
        await html5QrCode.start(
            back ? back.id : {facingMode:'environment'},
            {fps:10, qrbox:{width:240,height:240}, aspectRatio:1.0},
            text => {
                if(scanLocked) return;
                scanLocked = true;
                stopCamera();
                nisInput.value=text;
                search(text, true).finally(() => setTimeout(() => scanLocked = false, 1000));
            },
            ()=>{}
        );
        isScanning=true; btnScan.textContent='● Kamera Aktif';
    } catch(err) {
        showToast('error','Gagal membuka kamera'); stopCamera();
    }
});
document.getElementById('btn-stop-camera').addEventListener('click', stopCamera);
async function stopCamera() {
    if(html5QrCode && isScanning) { try{ await html5QrCode.stop(); }catch(e){} }
    isScanning=false; html5QrCode=null;
    camBox.classList.add('hidden'); btnScan.classList.remove('active');
    btnScan.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg> Scan QR Code`;
    document.getElementById('qr-reader').innerHTML='';
}

function showToast(type, message) {
    const toast = document.createElement('div');
    const cls = type==='error'?'toast-error':type==='warning'?'toast-warning':'toast-success';
    toast.className = `toast ${cls}`;
    toast.innerHTML = `<span>${type==='error'?'✕':type==='warning'?'⚠':'✓'}</span> ${message}`;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(()=>{ toast.style.opacity='0'; toast.style.transition='opacity 0.3s'; setTimeout(()=>toast.remove(),300); }, 3500);
}

window.addEventListener('load', ()=>{
    syncBatasRange();
    nisInput.focus();
});
</script>
</x-app-layout>
