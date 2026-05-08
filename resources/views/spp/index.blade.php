<x-app-layout>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ── Page background ── */
.spp-page { min-height: 100vh; background: #f1f5f9; padding: 32px 16px; }
.dark .spp-page { background: #0f172a; }

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
.scanner-header h2 { color: #fff; font-size: 1.25rem; font-weight: 700; margin: 0 0 4px; position: relative; z-index: 1; }
.scanner-header p  { color: #6ee7b7; font-size: 0.825rem; margin: 0; position: relative; z-index: 1; }

.scanner-body { padding: 20px; }

/* ── Input group ── */
.input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 12px;
}
.nis-input {
    flex: 1;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    color: #1e293b;
    font-size: 0.9rem;
    font-weight: 500;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    font-family: monospace;
    letter-spacing: 0.05em;
}
.dark .nis-input { background: #0f172a; border-color: #334155; color: #f1f5f9; }
.nis-input:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.12); }

.btn-cari {
    padding: 12px 20px;
    border-radius: 12px;
    background: linear-gradient(135deg, #059669, #10b981);
    color: #fff;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(16,185,129,0.3);
}
.btn-cari:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(16,185,129,0.4); }

.btn-scan {
    width: 100%;
    padding: 11px;
    border-radius: 12px;
    border: 1.5px dashed #10b981;
    background: rgba(16,185,129,0.05);
    color: #059669;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}
.dark .btn-scan { color: #34d399; border-color: #34d399; background: rgba(52,211,153,0.05); }
.btn-scan:hover { background: rgba(16,185,129,0.1); }
.btn-scan.active { background: rgba(16,185,129,0.15); border-style: solid; }

.btn-stop {
    width: 100%;
    padding: 9px;
    margin-top: 10px;
    border-radius: 10px;
    background: #fee2e2;
    color: #dc2626;
    font-weight: 600;
    font-size: 0.8rem;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-stop:hover { background: #fecaca; }

#camera-container { margin-top: 12px; }
#qr-reader { border-radius: 12px; overflow: hidden; }

/* ── Quick links ── */
.quick-links {
    display: flex;
    gap: 8px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}
.dark .quick-links { border-color: #334155; }
.quick-link {
    flex: 1;
    text-align: center;
    padding: 8px;
    border-radius: 10px;
    background: #f8fafc;
    color: #64748b;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.15s;
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
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Santri profile header ── */
.profile-header {
    padding: 20px;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-bottom: 1px solid #bbf7d0;
    display: flex;
    align-items: center;
    gap: 14px;
}
.dark .profile-header { background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(5,150,105,0.08)); border-color: rgba(16,185,129,0.2); }

.avatar {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #10b981, #059669);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; font-weight: 700; color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(16,185,129,0.3);
}
.profile-name { font-size: 1rem; font-weight: 700; color: #064e3b; margin: 0 0 3px; }
.dark .profile-name { color: #6ee7b7; }
.profile-meta { font-size: 0.78rem; color: #059669; font-family: monospace; margin: 0; }
.dark .profile-meta { color: #34d399; }

.btn-close {
    margin-left: auto;
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(0,0,0,0.06);
    border: none;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #64748b;
    transition: background 0.15s;
    flex-shrink: 0;
}
.btn-close:hover { background: rgba(239,68,68,0.1); color: #ef4444; }

/* ── Summary stats ── */
.stats-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
}
.dark .stats-row { border-color: #334155; }
.stat-box {
    padding: 12px 14px;
    border-radius: 12px;
    background: #f8fafc;
}
.dark .stat-box { background: #0f172a; }
.stat-label { font-size: 0.7rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 4px; }
.stat-value { font-size: 1.15rem; font-weight: 700; margin: 0; }
.stat-red  .stat-value { color: #dc2626; }
.stat-amber .stat-value { color: #d97706; }

/* ── SPP month grid ── */
.grid-section { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; }
.dark .grid-section { border-color: #334155; }
.grid-title { font-size: 0.8rem; font-weight: 700; color: #475569; margin: 0 0 10px; }
.dark .grid-title { color: #94a3b8; }
.month-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 6px; }
.month-cell {
    padding: 7px 4px;
    border-radius: 8px;
    text-align: center;
    font-size: 0.65rem;
    font-weight: 600;
    border: 1.5px solid;
    transition: transform 0.15s;
}
.month-cell:hover { transform: scale(1.05); }
.month-lunas   { background: #dcfce7; color: #166534; border-color: #86efac; }
.month-sebagian{ background: #fef3c7; color: #92400e; border-color: #fcd34d; }
.month-belum   { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
.dark .month-lunas   { background: rgba(22,163,74,0.15); color: #4ade80; border-color: rgba(74,222,128,0.3); }
.dark .month-sebagian{ background: rgba(245,158,11,0.15); color: #fcd34d; border-color: rgba(252,211,77,0.3); }
.dark .month-belum   { background: rgba(239,68,68,0.12); color: #fca5a5; border-color: rgba(252,165,165,0.3); }

/* ── Payment form ── */
.pay-section { padding: 16px 20px 20px; }
.pay-title { font-size: 0.8rem; font-weight: 700; color: #475569; margin: 0 0 12px; }
.dark .pay-title { color: #94a3b8; }

.quick-amounts { display: grid; grid-template-columns: repeat(4,1fr); gap: 6px; margin-bottom: 12px; }
.quick-btn {
    padding: 8px 4px;
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    color: #475569;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    text-align: center;
}
.dark .quick-btn { background: #0f172a; border-color: #334155; color: #94a3b8; }
.quick-btn:hover { border-color: #10b981; background: #ecfdf5; color: #059669; }
.dark .quick-btn:hover { background: rgba(16,185,129,0.1); color: #34d399; border-color: #10b981; }
.quick-btn.selected { border-color: #10b981; background: #ecfdf5; color: #059669; font-weight: 700; }
.dark .quick-btn.selected { background: rgba(16,185,129,0.15); color: #34d399; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px; }
.form-group label { display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 5px; }
.form-control {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    color: #1e293b;
    font-size: 0.875rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}
.dark .form-control { background: #0f172a; border-color: #334155; color: #f1f5f9; }
.form-control:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.1); }

.preview-box {
    padding: 10px 14px;
    border-radius: 10px;
    background: #ecfdf5;
    border: 1px solid #86efac;
    font-size: 0.78rem;
    color: #166534;
    margin-bottom: 12px;
    display: none;
}
.dark .preview-box { background: rgba(16,185,129,0.1); border-color: rgba(74,222,128,0.2); color: #4ade80; }

.form-actions { display: flex; gap: 10px; }
.btn-batal {
    flex: 1;
    padding: 11px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: transparent;
    color: #64748b;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.15s;
}
.dark .btn-batal { border-color: #334155; color: #94a3b8; }
.btn-batal:hover { background: #f8fafc; }
.btn-bayar {
    flex: 2;
    padding: 11px;
    border-radius: 10px;
    background: linear-gradient(135deg, #059669, #10b981);
    color: #fff;
    font-weight: 700;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(16,185,129,0.3);
}
.btn-bayar:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(16,185,129,0.4); }
.btn-bayar:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

/* ── Toast ── */
.toast-wrap { position: fixed; top: 20px; right: 20px; z-index: 999; display: flex; flex-direction: column; gap: 8px; }
.toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #fff;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    animation: toastIn 0.3s cubic-bezier(0.34,1.4,0.64,1) forwards;
    min-width: 240px;
}
@keyframes toastIn { from { opacity: 0; transform: translateX(40px) scale(0.9); } to { opacity: 1; transform: translateX(0) scale(1); } }
.toast-success { background: linear-gradient(135deg, #059669, #10b981); }
.toast-error   { background: linear-gradient(135deg, #dc2626, #ef4444); }

.legend { display: flex; gap: 12px; margin-top: 10px; }
.legend-item { display: flex; align-items: center; gap: 4px; font-size: 0.7rem; color: #64748b; }
.dark .legend-item { color: #94a3b8; }
.legend-dot { width: 10px; height: 10px; border-radius: 3px; }
</style>

<div class="spp-page">
    <div style="max-width:480px;margin:0 auto;">

        {{-- ── Scanner Card ── --}}
        <div class="scanner-card">
            <div class="scanner-header">
                <h2>💰 Pembayaran SPP</h2>
                <p>Scan QR Code atau ketik NIS</p>
            </div>
            <div class="scanner-body">
                <div class="input-group">
                    <input id="nis_input" type="text" placeholder="Ketik atau scan NIS..." autofocus class="nis-input">
                    <button id="btn-cari" class="btn-cari">Cari</button>
                </div>

                <button id="btn-scan-camera" class="btn-scan">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                    </svg>
                    Scan QR Code
                </button>

                <div id="camera-container" class="hidden">
                    <div id="qr-reader"></div>
                    <button id="btn-stop-camera" class="btn-stop">✕ Tutup Kamera</button>
                </div>

                <div class="quick-links">
                    <a href="{{ route('spp.rekap') }}" class="quick-link">📊 Rekap SPP</a>
                    <a href="{{ route('spp.riwayat') }}" class="quick-link">📜 Riwayat</a>
                </div>
            </div>
        </div>

        {{-- ── Result Card ── --}}
        <div id="result-card" style="display:none;">
            <div class="result-card">

                {{-- Profile --}}
                <div class="profile-header">
                    <div class="avatar" id="card-initial">?</div>
                    <div>
                        <p class="profile-name" id="card-nama">-</p>
                        <p class="profile-meta" id="card-meta">-</p>
                    </div>
                    <button class="btn-close" id="btn-close">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Stats --}}
                <div class="stats-row">
                    <div class="stat-box stat-red">
                        <p class="stat-label">Total Tanggungan</p>
                        <p class="stat-value" id="card-tanggungan">Rp 0</p>
                    </div>
                    <div class="stat-box stat-amber">
                        <p class="stat-label">Bulan Belum Lunas</p>
                        <p class="stat-value" id="card-jumlah-bulan">0 bulan</p>
                    </div>
                </div>

                {{-- Month Grid --}}
                <div class="grid-section">
                    <p class="grid-title">Status SPP <span id="card-tahun">{{ $tahunAjaran?->tahun_hijriah ?? '-' }}</span>H</p>
                    <div class="month-grid" id="card-spp-grid"></div>
                    <div class="legend" style="margin-top:10px;">
                        <div class="legend-item"><div class="legend-dot" style="background:#86efac;"></div>Lunas</div>
                        <div class="legend-item"><div class="legend-dot" style="background:#fcd34d;"></div>Sebagian</div>
                        <div class="legend-item"><div class="legend-dot" style="background:#fca5a5;"></div>Belum</div>
                    </div>
                </div>

                @php $nominalSppAktif = (int) ($tahunAjaran?->nominal_spp ?? 50000); @endphp

                {{-- Payment Form --}}
                <div class="pay-section">
                    <p class="pay-title">Input Pembayaran</p>
                    <form id="form-bayar">
                        <input type="hidden" id="form-nis" name="nis">
                        <input type="hidden" id="form-tahun-ajaran-id" name="tahun_ajaran_id" value="{{ $tahunAjaran?->id }}">

                        <div class="quick-amounts">
                            <button type="button" class="quick-btn" data-amount="{{ $nominalSppAktif }}">{{ number_format($nominalSppAktif / 1000, 0, ',', '.') }}rb</button>
                            <button type="button" class="quick-btn" data-amount="{{ $nominalSppAktif * 2 }}">{{ number_format(($nominalSppAktif * 2) / 1000, 0, ',', '.') }}rb</button>
                            <button type="button" class="quick-btn" data-amount="{{ $nominalSppAktif * 4 }}">{{ number_format(($nominalSppAktif * 4) / 1000, 0, ',', '.') }}rb</button>
                            <button type="button" class="quick-btn" data-amount="{{ $nominalSppAktif * 12 }}">{{ number_format(($nominalSppAktif * 12) / 1000, 0, ',', '.') }}rb</button>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Nominal Bayar</label>
                                <input type="number" id="form-nominal" name="nominal_bayar" required min="1" placeholder="Nominal..." class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Metode</label>
                                <select name="metode" class="form-control">
                                    <option value="cash">💵 Cash</option>
                                    <option value="transfer">🏦 Transfer</option>
                                </select>
                            </div>
                        </div>

                        <div class="preview-box" id="preview-box">
                            <strong>Akan membayar:</strong> <span id="preview-text">-</span>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-batal" id="btn-batal">Batal</button>
                            <button type="submit" class="btn-bayar" id="btn-bayar">💾 Simpan Pembayaran</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="toast-wrap" id="toast-container"></div>

<script>
const BULAN_SHORT = {
    1:'Muh', 2:'Saf', 3:'R.Aw', 4:'R.Ak', 5:'J.Aw', 6:'J.Ak',
    7:'Raj', 8:'Sya', 9:'Ram', 10:'Syw', 11:'Dzq', 12:'Dzh'
};

const nisInput    = document.getElementById('nis_input');
const resultCard  = document.getElementById('result-card');
let currentNis    = null;
let currentTagihan = [];
let currentTahunAjaranId  = {{ $tahunAjaran?->id ?? 'null' }};

// ── Search ──
document.getElementById('btn-cari').addEventListener('click', () => search(nisInput.value.trim()));
nisInput.addEventListener('keydown', e => { if (e.key === 'Enter') search(nisInput.value.trim()); });

// Auto-search: langsung cari setelah user berhenti mengetik 500ms
let debounceTimer = null;
nisInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    const nis = nisInput.value.trim();
    if (nis.length < 3) { resultCard.style.display = 'none'; return; }
    debounceTimer = setTimeout(() => search(nis), 500);
});

async function search(nis) {
    if (!nis) { showToast('error', 'Masukkan NIS terlebih dahulu!'); return; }

    // Loading state
    document.getElementById('btn-cari').textContent = '...';
    document.getElementById('btn-cari').disabled = true;

    try {
        const res  = await fetch(`/spp/santri?nis=${encodeURIComponent(nis)}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (!data.success) {
            showToast('error', data.message || 'Santri tidak ditemukan');
            resultCard.style.display = 'none';
            return;
        }

        currentNis     = data.santri.nis;
        currentTagihan = data.tagihan;
        currentTahunAjaranId = data.tahun_ajaran_id;

        // Populate card
        document.getElementById('card-initial').textContent = data.santri.nama.charAt(0).toUpperCase();
        document.getElementById('card-nama').textContent    = data.santri.nama;
        document.getElementById('card-meta').textContent   = `Kelas ${data.santri.kelas} • NIS: ${data.santri.nis}`;
        document.getElementById('card-tahun').textContent  = data.tahun_ajaran?.tahun_hijriah || '-';
        document.getElementById('card-tanggungan').textContent = formatRupiah(data.total_tanggungan);
        document.getElementById('card-jumlah-bulan').textContent = data.jumlah_bulan_belum + ' bulan';
        document.getElementById('form-nis').value   = data.santri.nis;
        document.getElementById('form-tahun-ajaran-id').value = data.tahun_ajaran_id;

        renderGrid(data.tagihan);

        // Show result
        resultCard.style.display = 'block';
        resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

    } catch (err) {
        console.error(err);
        showToast('error', 'Terjadi kesalahan saat mengambil data');
    } finally {
        document.getElementById('btn-cari').textContent = 'Cari';
        document.getElementById('btn-cari').disabled = false;
    }
}

function renderGrid(tagihan) {
    const grid = document.getElementById('card-spp-grid');
    grid.innerHTML = '';
    tagihan.forEach(item => {
        const cls = item.status === 'lunas' ? 'month-lunas'
                  : item.status === 'sebagian' ? 'month-sebagian'
                  : 'month-belum';
        const icon = item.status === 'lunas' ? '✓' : item.status === 'sebagian' ? '◑' : '✗';
        const div = document.createElement('div');
        div.className = `month-cell ${cls}`;
        div.title = `${item.nama_bulan}: ${item.status}`;
        div.innerHTML = `<div>${icon}</div><div>${BULAN_SHORT[item.bulan]}</div>`;
        grid.appendChild(div);
    });
}

// ── Quick amounts ──
document.querySelectorAll('.quick-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        document.getElementById('form-nominal').value = btn.dataset.amount;
        updatePreview();
    });
});
document.getElementById('form-nominal').addEventListener('input', () => {
    document.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('selected'));
    updatePreview();
});

function updatePreview() {
    const nominal = parseInt(document.getElementById('form-nominal').value) || 0;
    const box = document.getElementById('preview-box');
    if (nominal <= 0) { box.style.display = 'none'; return; }

    const belum = currentTagihan.filter(t => t.status !== 'lunas');
    let sisa = nominal;
    const akan = [];
    for (const t of belum) {
        if (sisa <= 0) break;
        const sisaT = t.sisa || (t.nominal - (t.total_bayar || 0));
        if (sisaT > 0) { akan.push(BULAN_SHORT[t.bulan]); sisa -= Math.min(sisa, sisaT); }
    }
    document.getElementById('preview-text').textContent = akan.length
        ? akan.join(', ') + (sisa > 0 ? ' + sisa ke tahun berikutnya' : '')
        : 'Semua bulan sudah lunas';
    box.style.display = 'block';
}

// ── Submit ──
document.getElementById('form-bayar').addEventListener('submit', async e => {
    e.preventDefault();
    const nominal = parseFloat(document.getElementById('form-nominal').value);
    if (!nominal || nominal < 1) { showToast('error', 'Masukkan nominal pembayaran!'); return; }

    const btn = document.getElementById('btn-bayar');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    try {
        const res = await fetch('/spp/bayar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nis: document.getElementById('form-nis').value,
                tahun_ajaran_id: parseInt(document.getElementById('form-tahun-ajaran-id').value),
                nominal_bayar: nominal,
                metode: document.querySelector('select[name="metode"]').value,
            })
        });
        const result = await res.json();
        if (result.success) {
            showToast('success', result.message);
            document.getElementById('form-nominal').value = '';
            document.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('selected'));
            document.getElementById('preview-box').style.display = 'none';
            await search(currentNis); // refresh data
        } else {
            showToast('error', result.message || 'Gagal menyimpan pembayaran');
        }
    } catch (err) {
        showToast('error', 'Terjadi kesalahan');
    } finally {
        btn.disabled = false;
        btn.textContent = '💾 Simpan Pembayaran';
    }
});

// ── Close ──
function closeCard() {
    resultCard.style.display = 'none';
    nisInput.value = '';
    document.getElementById('form-nominal').value = '';
    document.getElementById('preview-box').style.display = 'none';
    document.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('selected'));
    nisInput.focus();
}
document.getElementById('btn-close').addEventListener('click', closeCard);
document.getElementById('btn-batal').addEventListener('click', closeCard);

// ── Camera ──
let html5QrCode = null;
let isScanning  = false;
const btnScan   = document.getElementById('btn-scan-camera');
const camBox    = document.getElementById('camera-container');

btnScan.addEventListener('click', async () => {
    if (isScanning) return;
    try {
        camBox.classList.remove('hidden');
        btnScan.classList.add('active');
        btnScan.innerHTML = `<svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Membuka kamera...`;
        html5QrCode = new Html5Qrcode('qr-reader');
        const devices = await Html5Qrcode.getCameras().catch(() => []);
        const back    = devices.find(d => d.label.toLowerCase().includes('back'));
        await html5QrCode.start(
            back ? back.id : { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 240, height: 240 }, aspectRatio: 1.0 },
            text => { stopCamera(); nisInput.value = text; search(text); },
            () => {}
        );
        isScanning = true;
        btnScan.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> Kamera Aktif`;
    } catch (err) {
        showToast('error', 'Gagal membuka kamera');
        stopCamera();
    }
});

document.getElementById('btn-stop-camera').addEventListener('click', stopCamera);

async function stopCamera() {
    if (html5QrCode && isScanning) { try { await html5QrCode.stop(); } catch(e){} }
    isScanning  = false;
    html5QrCode = null;
    camBox.classList.add('hidden');
    btnScan.classList.remove('active');
    btnScan.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/></svg> Scan QR Code`;
    document.getElementById('qr-reader').innerHTML = '';
}

// ── Toast ──
function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<span>${type === 'success' ? '✓' : '✕'}</span> ${message}`;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s'; setTimeout(() => toast.remove(), 300); }, 3500);
}

function formatRupiah(n) { return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }

window.addEventListener('load', () => nisInput.focus());
</script>
</x-app-layout>
