<x-app-layout>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family:'Plus Jakarta Sans',sans-serif; }
.page { min-height:100vh; background:#f1f5f9; padding:32px 16px; }
.dark .page { background:#0f172a; }

/* Card */
.card { background:#fff; border:1px solid #e2e8f0; border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,.07); overflow:hidden; margin-bottom:20px; }
.dark .card { background:#1e293b; border-color:#334155; }
.card-header { background:linear-gradient(135deg,#064e3b,#065f46,#059669); padding:24px; text-align:center; }
.card-header h2 { color:#fff; font-size:1.25rem; font-weight:700; margin:0 0 4px; }
.card-header p  { color:#6ee7b7; font-size:.825rem; margin:0; }
.card-body { padding:20px; }

/* Inputs */
.input-group { display:flex; gap:10px; margin-bottom:12px; }
.input { width:100%; padding:11px 14px; border-radius:10px; border:1.5px solid #e2e8f0; background:#f8fafc; color:#1e293b; outline:none; box-sizing:border-box; transition:.2s; }
.input:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,.12); }
.dark .input { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.nis-input { flex:1; font-family:monospace; letter-spacing:.05em; }

/* Buttons */
.btn { border:none; cursor:pointer; font-weight:700; transition:.2s; }
.btn-cari { padding:12px 20px; border-radius:12px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; }
.btn-scan { width:100%; padding:11px; border-radius:12px; border:1.5px dashed #10b981; background:rgba(16,185,129,0.05); color:#059669; margin-bottom:8px; }
.btn-stop { width:100%; padding:9px; margin-top:10px; border-radius:10px; background:#fee2e2; color:#dc2626; }
.btn-approve { flex:2; padding:13px; border-radius:10px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; font-size:.95rem; }
.btn-batal   { flex:1; padding:13px; border-radius:10px; border:1.5px solid #e2e8f0; background:transparent; color:#64748b; }

/* Quick links */
.quick-links { display:flex; gap:8px; margin-top:16px; padding-top:16px; border-top:1px solid #f1f5f9; }
.quick-link { flex:1; text-align:center; padding:9px; border-radius:10px; background:#f8fafc; color:#64748b; text-decoration:none; font-size:.78rem; font-weight:700; }
.quick-link:hover { background:#ecfdf5; color:#059669; }

/* Santri card */
.santri-card { background:#fff; border:1px solid #e2e8f0; border-radius:20px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
.dark .santri-card { background:#1e293b; border-color:#334155; }
.profile { padding:18px 20px; display:flex; align-items:center; gap:14px; }
.profile.ok  { background:linear-gradient(135deg,#f0fdf4,#dcfce7); border-bottom:1px solid #bbf7d0; }
.profile.done { background:linear-gradient(135deg,#f0fdf4,#dcfce7); border-bottom:1px solid #bbf7d0; }
.profile.warn { background:linear-gradient(135deg,#fffbeb,#fef3c7); border-bottom:1px solid #fde68a; }
.avatar { width:48px; height:48px; border-radius:14px; background:linear-gradient(135deg,#10b981,#059669); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1.2rem; flex-shrink:0; }
.name { font-size:1rem; font-weight:800; color:#064e3b; margin:0 0 3px; }
.meta { font-size:.78rem; color:#059669; font-family:monospace; margin:0; }
.dark .name { color:#e0f2fe; }
.section { padding:16px 20px 20px; }
.label { display:block; margin:0 0 6px; color:#64748b; font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
.textarea { width:100%; padding:11px 14px; border-radius:10px; border:1.5px solid #e2e8f0; background:#f8fafc; color:#1e293b; outline:none; box-sizing:border-box; min-height:80px; resize:vertical; transition:.2s; }
.textarea:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,.12); }
.dark .textarea { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.actions { display:flex; gap:10px; margin-top:14px; }

/* Status chips */
.chips { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:16px; }
.chip { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:999px; font-size:.75rem; font-weight:700; }
.chip-done { background:#dcfce7; color:#166534; }
.chip-wait { background:#fee2e2; color:#991b1b; }
.chip-info { background:#dbeafe; color:#1e40af; }

/* Notice */
.notice { margin:0 20px 16px; padding:12px; border-radius:10px; font-size:.8rem; font-weight:600; }
.notice-warn { background:#fffbeb; color:#92400e; border:1px solid #fcd34d; }
.notice-ok   { background:#f0fdf4; color:#166534; border:1px solid #86efac; }

/* Toast */
.toast-wrap { position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:8px; }
.toast { padding:12px 16px; border-radius:12px; color:#fff; font-size:.85rem; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,.15); animation:fadeIn .2s ease; }
@keyframes fadeIn { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
.toast-success { background:linear-gradient(135deg,#059669,#10b981); }
.toast-error   { background:linear-gradient(135deg,#dc2626,#ef4444); }
.toast-warning { background:linear-gradient(135deg,#d97706,#f59e0b); }

#camera-container { margin-top:12px; }
#qr-reader { border-radius:12px; overflow:hidden; }
</style>

<div class="page">
    <div style="max-width:480px;margin:0 auto;">

        {{-- Header card --}}
        <div class="card">
            <div class="card-header">
                <h2>✏️ TTD Musrif</h2>
                <p>Scan QR atau ketik NIS santri untuk memberikan tanda tangan musrif</p>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <input id="nis_input" type="text" class="input nis-input"
                           placeholder="Ketik atau scan NIS..." autofocus>
                    <button id="btn-cari" class="btn btn-cari">Cari</button>
                </div>
                <button id="btn-scan-camera" class="btn btn-scan">📷 Scan QR Code</button>
                <div id="camera-container" class="hidden">
                    <div id="qr-reader"></div>
                    <button id="btn-stop-camera" class="btn btn-stop">Tutup Kamera</button>
                </div>
                <div class="quick-links">
                    <a href="{{ route('admin.perpulangan.rekap') }}" class="quick-link">📋 Rekap Perpulangan</a>
                    <a href="{{ route('perpulangan.scan.spp') }}" class="quick-link">🏢 Ke Scan SPP</a>
                </div>
            </div>
        </div>

        {{-- Result card --}}
        <div id="santri-result" style="display:none;">
            <div class="santri-card">
                <div class="profile ok" id="profile-section">
                    <div class="avatar" id="card-initial">?</div>
                    <div style="flex:1;min-width:0;">
                        <p class="name" id="card-nama">-</p>
                        <p class="meta" id="card-meta">-</p>
                    </div>
                    <button onclick="closeCard()"
                        style="width:30px;height:30px;border-radius:8px;border:none;cursor:pointer;color:#64748b;background:rgba(0,0,0,.06);">✕</button>
                </div>

                {{-- Status chips --}}
                <div class="section" style="padding-bottom:0;">
                    <div class="label">Status Checkpoint</div>
                    <div class="chips" id="chips-container"></div>
                </div>

                {{-- Notice jika sudah di-TTD --}}
                <div id="already-notice" class="notice notice-ok" style="display:none;">
                    ✅ Santri ini sudah mendapat TTD musrif.
                </div>

                {{-- Form approve --}}
                <div class="section" id="form-section">
                    <label class="label">Catatan (opsional)</label>
                    <textarea id="catatan" class="textarea"
                              placeholder="Misal: kerapian lengkap, kitab lengkap..."></textarea>
                    <div class="actions">
                        <button class="btn btn-batal" onclick="closeCard()">Batal</button>
                        <button class="btn btn-approve" id="btn-approve"
                                onclick="doApprove()">✏️ Berikan TTD Musrif</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-wrap" id="toast-container"></div>

<script>
const CSRF    = '{{ csrf_token() }}';
const API_URL = '/perpulangan/ajax';

const nisInput = document.getElementById('nis_input');
let currentData = null;
let debounce = null;
let html5QrCode = null;
let isScanning = false;
let scanLocked = false;

// ─── Event listeners ──────────────────────────────────────────────────────────
document.getElementById('btn-cari').addEventListener('click', () => search(nisInput.value.trim()));
nisInput.addEventListener('keydown', e => { if(e.key === 'Enter') search(nisInput.value.trim()); });
nisInput.addEventListener('input', () => {
    clearTimeout(debounce);
    const v = nisInput.value.trim();
    if(v.length < 3) { document.getElementById('santri-result').style.display='none'; return; }
    debounce = setTimeout(() => search(v), 500);
});

// ─── Search ───────────────────────────────────────────────────────────────────
async function search(nis) {
    nis = extractNis(nis);
    if(!nis) { showToast('error','Masukkan NIS!'); return; }
    nisInput.value = nis;
    const btn = document.getElementById('btn-cari');
    btn.disabled = true; btn.textContent = '...';
    try {
        const res  = await apiFetch(`/scan/${encodeURIComponent(nis)}`);
        const data = await res.json();
        if(!data.success) { showToast('error', data.message || 'Santri tidak ditemukan'); return; }
        renderCard(data.data);
    } catch(e) {
        showToast('error', e.message || 'Gagal menghubungi server');
    } finally {
        btn.disabled = false; btn.textContent = 'Cari';
    }
}

// ─── Render card ──────────────────────────────────────────────────────────────
function renderCard(d) {
    currentData = d;
    document.getElementById('card-initial').textContent = d.nama.charAt(0).toUpperCase();
    document.getElementById('card-nama').textContent    = d.nama;
    document.getElementById('card-meta').textContent   = `Kelas ${d.kelas} · NIS: ${d.nis}`;

    // chips
    const chips = document.getElementById('chips-container');
    chips.innerHTML = chipHtml('Musrif', d.approvals.musrif)
                    + chipHtml('SPP', d.approvals.spp)
                    + chipHtml('Keamanan', d.approvals.keamanan);

    const sudahMusrif = !!d.approvals.musrif;
    const approvalClosed = !d.approval_open;
    const notice = document.getElementById('already-notice');
    notice.textContent = approvalClosed
        ? `Approval hanya dibuka pada tanggal ${d.event.tanggal_mulai}.`
        : '✅ Santri ini sudah mendapat TTD musrif.';
    notice.style.display = (sudahMusrif || approvalClosed) ? 'block' : 'none';
    document.getElementById('form-section').style.display   = (sudahMusrif || approvalClosed) ? 'none'  : 'block';
    document.getElementById('santri-result').style.display  = 'block';
    document.getElementById('santri-result').scrollIntoView({behavior:'smooth',block:'nearest'});
}

function chipHtml(label, approval) {
    if(approval) return `<span class="chip chip-done">✅ ${label}: ${approval.approved_by}</span>`;
    return `<span class="chip chip-wait">❌ ${label}: Belum</span>`;
}

// ─── Approve musrif ───────────────────────────────────────────────────────────
async function doApprove() {
    if(!currentData) return;
    const btn = document.getElementById('btn-approve');
    btn.disabled = true; btn.textContent = 'Menyimpan...';
    try {
        const res  = await apiFetch('/approve/musrif', 'POST', {
            nis    : currentData.nis,
            catatan: document.getElementById('catatan').value.trim() || null,
        });
        const data = await res.json();
        if(data.success) {
            showToast('success', '✅ TTD Musrif berhasil diberikan!');
            renderCard(data.data);
            document.getElementById('catatan').value = '';
        } else {
            showToast('error', data.message || 'Gagal memberikan TTD');
        }
    } catch(e) {
        showToast('error', e.message || 'Gagal menghubungi server');
    } finally {
        btn.disabled = false; btn.textContent = '✏️ Berikan TTD Musrif';
    }
}

// ─── Close card ───────────────────────────────────────────────────────────────
function closeCard() {
    document.getElementById('santri-result').style.display = 'none';
    document.getElementById('catatan').value = '';
    nisInput.value = '';
    nisInput.focus();
    currentData = null;
}

// ─── Kamera ───────────────────────────────────────────────────────────────────
const btnScan = document.getElementById('btn-scan-camera');
const camBox  = document.getElementById('camera-container');
btnScan.addEventListener('click', startCamera);
document.getElementById('btn-stop-camera').addEventListener('click', stopCamera);

async function startCamera() {
    if(isScanning) return;
    try {
        camBox.classList.remove('hidden');
        btnScan.textContent = '⏳ Membuka kamera...';
        html5QrCode = new Html5Qrcode('qr-reader');
        const devices = await Html5Qrcode.getCameras().catch(()=>[]);
        const back = devices.find(d => /back|rear|environment/i.test(d.label));
        await html5QrCode.start(
            back ? back.id : {facingMode:'environment'},
            {fps:10, qrbox:{width:240,height:240}, aspectRatio:1},
            text => {
                if(scanLocked) return;
                scanLocked = true;
                stopCamera();
                const nis = extractNis(text);
                nisInput.value = nis;
                search(nis).finally(() => setTimeout(() => scanLocked=false, 1500));
            }, ()=>{}
        );
        isScanning = true;
        btnScan.textContent = '📷 Kamera Aktif';
    } catch(e) {
        showToast('error','Gagal membuka kamera: '+e.message);
        stopCamera();
    }
}

async function stopCamera() {
    if(html5QrCode && isScanning) { try { await html5QrCode.stop(); } catch(e){} }
    isScanning = false; html5QrCode = null;
    camBox.classList.add('hidden');
    btnScan.textContent = '📷 Scan QR Code';
    document.getElementById('qr-reader').innerHTML = '';
}

// ─── Helpers ──────────────────────────────────────────────────────────────────
function apiFetch(path, method='GET', body=null) {
    const opts = {
        method,
        headers: {
            'Accept'       : 'application/json',
            'X-CSRF-TOKEN' : CSRF,
        },
        credentials: 'same-origin',
    };
    if(body) { opts.headers['Content-Type'] = 'application/json'; opts.body = JSON.stringify(body); }
    return fetch(API_URL + path, opts);
}

function extractNis(raw) {
    const value = String(raw || '').trim();
    if(!value) return '';

    try {
        const json = JSON.parse(value);
        const fromJson = json.nis || json.NIS || (json.data && (json.data.nis || json.data.NIS));
        if(fromJson) return String(fromJson).trim();
    } catch(e) {}

    const nisPair = value.match(/(?:^|[?&\s"'=:])nis["']?\s*[:=]\s*["']?([A-Za-z0-9._-]+)/i);
    if(nisPair) return nisPair[1].trim();

    try {
        const url = new URL(value, window.location.origin);
        const fromQuery = url.searchParams.get('nis') || url.searchParams.get('NIS');
        if(fromQuery) return fromQuery.trim();

        const lastSegment = url.pathname.split('/').filter(Boolean).pop();
        if(lastSegment && /^[A-Za-z0-9._-]+$/.test(lastSegment)) return lastSegment.trim();
    } catch(e) {}

    return value.split(/\s+/)[0].replace(/^[^A-Za-z0-9]+|[^A-Za-z0-9._-]+$/g, '');
}

function showToast(type, msg) {
    const t = document.createElement('div');
    t.className = `toast toast-${type === 'error' ? 'error' : type === 'warning' ? 'warning' : 'success'}`;
    t.textContent = msg;
    document.getElementById('toast-container').appendChild(t);
    setTimeout(() => { t.style.opacity='0'; t.style.transition='opacity .3s'; setTimeout(()=>t.remove(),300); }, 3500);
}
</script>
</x-app-layout>
