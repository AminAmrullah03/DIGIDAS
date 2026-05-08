<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-bg { min-height: 100vh; background: #f1f5f9; padding: 28px 16px; }
.dark .page-bg { background: #0f172a; }

/* ── Banner ── */
.page-banner {
    background: linear-gradient(135deg,#064e3b 0%,#065f46 50%,#059669 100%);
    border-radius: 20px; padding: 24px 28px; margin-bottom: 20px;
    position: relative; overflow: hidden;
}
.page-banner::before {
    content:''; position:absolute; top:-50px; right:-50px;
    width:180px; height:180px; border-radius:50%;
    background:rgba(16,185,129,0.12); pointer-events:none;
}
.page-banner::after {
    content:''; position:absolute; bottom:-30px; left:25%;
    width:120px; height:120px; border-radius:50%;
    background:rgba(6,78,59,0.4); pointer-events:none;
}
.page-banner h1 { color:#fff; font-size:1.3rem; font-weight:700; margin:0 0 4px; position:relative; z-index:1; }
.page-banner p  { color:#6ee7b7; font-size:0.82rem; margin:0; position:relative; z-index:1; }
.banner-actions { display:flex; gap:8px; margin-top:14px; flex-wrap:wrap; position:relative; z-index:1; }
.btn-white {
    display:inline-flex; align-items:center; gap:6px;
    padding:8px 16px; border-radius:10px;
    background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25);
    color:#fff; font-size:0.8rem; font-weight:600; text-decoration:none;
    transition:all 0.15s; backdrop-filter:blur(4px);
}
.btn-white:hover { background:rgba(255,255,255,0.25); }

/* ── Filter card ── */
.filter-card {
    background:#fff; border-radius:16px; padding:16px 20px;
    border:1px solid #e2e8f0; margin-bottom:16px;
    box-shadow:0 1px 4px rgba(0,0,0,0.04);
}
.dark .filter-card { background:#1e293b; border-color:#334155; }
.filter-row { display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
.form-group { display:flex; flex-direction:column; gap:4px; }
.form-label { font-size:0.72rem; font-weight:600; color:#64748b; }
.dark .form-label { color:#94a3b8; }
.form-ctrl {
    padding:9px 12px; border-radius:10px; border:1.5px solid #e2e8f0;
    background:#f8fafc; color:#1e293b; font-size:0.83rem;
    outline:none; transition:border-color 0.2s;
}
.dark .form-ctrl { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.form-ctrl:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.1); }
.btn-filter {
    padding:9px 18px; border-radius:10px;
    background:linear-gradient(135deg,#059669,#10b981);
    color:#fff; font-weight:600; font-size:0.83rem;
    border:none; cursor:pointer;
    box-shadow:0 2px 8px rgba(16,185,129,0.25);
    transition:all 0.2s;
}
.btn-filter:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(16,185,129,0.3); }
.btn-reset {
    padding:9px 14px; border-radius:10px;
    border:1.5px solid #e2e8f0; background:transparent;
    color:#64748b; font-weight:600; font-size:0.83rem;
    cursor:pointer; transition:all 0.15s;
}
.dark .btn-reset { border-color:#334155; color:#94a3b8; }
.btn-reset:hover { background:#f8fafc; border-color:#cbd5e1; }
.dark .btn-reset:hover { background:rgba(255,255,255,0.04); }

/* ── Summary stats ── */
.stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(130px,1fr)); gap:12px; margin-bottom:16px; }
.stat-card {
    background:#fff; border-radius:14px; padding:14px 16px;
    border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04);
}
.dark .stat-card { background:#1e293b; border-color:#334155; }
.stat-label { font-size:0.68rem; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 5px; }
.stat-value { font-size:1.4rem; font-weight:700; margin:0; }

/* ── Loading ── */
.loading-wrap { text-align:center; padding:40px; display:none; }
.loading-spinner {
    width:36px; height:36px; border-radius:50%;
    border:3px solid #e2e8f0; border-top-color:#10b981;
    animation:spin 0.7s linear infinite; display:inline-block;
}
@keyframes spin { to{transform:rotate(360deg)} }

/* ── Table wrap ── */
.table-wrap {
    background:#fff; border-radius:16px;
    border:1px solid #e2e8f0; overflow:hidden;
    box-shadow:0 1px 4px rgba(0,0,0,0.04);
}
.dark .table-wrap { background:#1e293b; border-color:#334155; }
table { width:100%; border-collapse:collapse; font-size:0.8rem; }
th {
    padding:11px 14px; text-align:left;
    font-size:0.68rem; font-weight:700; color:#64748b;
    text-transform:uppercase; letter-spacing:0.04em;
    background:#f8fafc; border-bottom:1px solid #e2e8f0;
    white-space:nowrap;
}
.dark th { background:#0f172a; color:#94a3b8; border-color:#334155; }
td {
    padding:11px 14px; border-bottom:1px solid #f1f5f9;
    color:#374151; white-space:nowrap;
}
.dark td { border-color:#334155; color:#cbd5e1; }
tbody tr:hover td { background:#f8fafc; }
.dark tbody tr:hover td { background:rgba(255,255,255,0.02); }
tbody tr:last-child td { border-bottom:none; }

/* ── Status badge ── */
.badge {
    display:inline-flex; align-items:center; gap:4px;
    padding:4px 10px; border-radius:20px;
    font-size:0.72rem; font-weight:700;
}
.badge-hadir   { background:#dcfce7; color:#166534; }
.badge-izin    { background:#fef3c7; color:#92400e; }
.badge-sakit   { background:#dbeafe; color:#1e40af; }
.badge-alpha   { background:#fee2e2; color:#991b1b; }
.badge-default { background:#f1f5f9; color:#475569; }
.dark .badge-hadir  { background:rgba(22,163,74,0.15); color:#4ade80; }
.dark .badge-izin   { background:rgba(245,158,11,0.15); color:#fcd34d; }
.dark .badge-sakit  { background:rgba(37,99,235,0.15); color:#93c5fd; }
.dark .badge-alpha  { background:rgba(239,68,68,0.12); color:#fca5a5; }
.dark .badge-default{ background:rgba(71,85,105,0.15); color:#94a3b8; }

/* ── Status select ── */
.status-select {
    padding:5px 10px; border-radius:8px;
    border:1.5px solid #e2e8f0; background:#f8fafc;
    color:#374151; font-size:0.75rem; font-weight:600;
    outline:none; cursor:pointer; transition:border-color 0.2s;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.dark .status-select { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.status-select:focus { border-color:#10b981; }

/* ── Empty state ── */
.empty-state {
    text-align:center; padding:60px 24px;
    color:#94a3b8;
}
.empty-icon {
    width:52px; height:52px; border-radius:14px;
    background:#f1f5f9; display:flex; align-items:center; justify-content:center;
    margin:0 auto 14px;
}
.dark .empty-icon { background:#334155; }

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
</style>

<div class="page-bg">
    <div style="max-width:1200px;margin:0 auto;">

        {{-- Banner --}}
        <div class="page-banner">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;display:inline;margin-right:6px;vertical-align:-3px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                </svg>
                Rekap Absensi Santri
            </h1>
            <p>Lihat dan kelola data kehadiran santri per kegiatan</p>
            <div class="banner-actions">
                <a href="{{ route('absen') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75z"/></svg>
                    Scan Absensi
                </a>
                <a href="{{ route('dashboard') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Dashboard
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row" id="stats-row" style="display:none;">
            <div class="stat-card"><p class="stat-label">Total Data</p><p class="stat-value" id="stat-total" style="color:#2563eb;">0</p></div>
            <div class="stat-card"><p class="stat-label">Hadir</p><p class="stat-value" id="stat-hadir" style="color:#059669;">0</p></div>
            <div class="stat-card"><p class="stat-label">Izin</p><p class="stat-value" id="stat-izin" style="color:#d97706;">0</p></div>
            <div class="stat-card"><p class="stat-label">Alpha</p><p class="stat-value" id="stat-alpha" style="color:#dc2626;">0</p></div>
        </div>

        {{-- Filter --}}
        <div class="filter-card">
            <div class="filter-row">
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" class="form-ctrl" value="{{ $tanggal ?? now()->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select id="kelas" class="form-ctrl">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas }}" {{ ($kelasFilter ?? '') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kegiatan</label>
                    <select id="kegiatan" class="form-ctrl">
                        <option value="">Pilih Kegiatan</option>
                        @foreach ($kegiatanList as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ ($kegiatanFilter ?? '') == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn-filter" id="btn-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Tampilkan
                </button>
                <button class="btn-reset" id="btn-reset">Reset</button>
            </div>
        </div>

        {{-- Loading --}}
        <div class="loading-wrap" id="loading">
            <div class="loading-spinner"></div>
            <p style="margin-top:12px;color:#64748b;font-size:0.875rem;">Memuat data...</p>
        </div>

        {{-- Table --}}
        <div class="table-wrap" id="table-wrap">
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Kegiatan</th>
                            <th>Waktu (WIB)</th>
                            <th>Status</th>
                            <th>Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody id="rekap-tbody">
                        @include('partials.rekap-table', ['rekap' => $rekap])
                    </tbody>
                </table>
            </div>
            <div class="empty-state" id="empty-state" style="{{ $rekap->isEmpty() ? '' : 'display:none;' }}">
                <div class="empty-icon" id="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#94a3b8" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </div>
                <p style="font-weight:700;font-size:0.95rem;color:#475569;margin:0 0 4px;" id="empty-title">Pilih Filter Terlebih Dahulu</p>
                <p style="font-size:0.8rem;color:#94a3b8;margin:0;" id="empty-desc">Pilih kelas dan kegiatan, lalu klik <strong>Tampilkan</strong> untuk melihat rekap absensi</p>
            </div>
        </div>

    </div>
</div>

<div class="toast-wrap" id="toast-container"></div>

<script>
const CSRF = '{{ csrf_token() }}';

// ── Filter ──
async function loadRekap() {
    const tanggal  = document.getElementById('tanggal').value;
    const kelas    = document.getElementById('kelas').value;
    const kegiatan = document.getElementById('kegiatan').value;

    document.getElementById('loading').style.display = 'block';
    document.getElementById('table-wrap').style.display = 'none';
    document.getElementById('stats-row').style.display = 'none';

    try {
        const params = new URLSearchParams({ tanggal, kelas, kegiatan });
        const res    = await fetch(`/rekap-data?${params}`, { headers:{'Accept':'text/html','X-Requested-With':'XMLHttpRequest'} });
        const html   = await res.text();

        document.getElementById('rekap-tbody').innerHTML = html;

        const emptyState = document.getElementById('empty-state');
        const emptyTitle = document.getElementById('empty-title');
        const emptyDesc  = document.getElementById('empty-desc');
        const emptyIcon  = document.getElementById('empty-icon');
        if (html.trim() === '') {
            if (kegiatan) {
                emptyTitle.textContent = 'Belum ada data absensi';
                emptyDesc.innerHTML = 'Tidak ada catatan absensi untuk tanggal dan kegiatan yang dipilih';
                emptyIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#94a3b8" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375"/></svg>';
            } else {
                emptyTitle.textContent = 'Pilih Filter Terlebih Dahulu';
                emptyDesc.innerHTML = 'Pilih kelas dan kegiatan, lalu klik <strong>Tampilkan</strong> untuk melihat rekap absensi';
                emptyIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#94a3b8" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>';
            }
            if (emptyState) emptyState.style.display = 'block';
        } else {
            if (emptyState) emptyState.style.display = 'none';
        }

        updateStats();
        applyBadgeStyles();
        bindStatusSelects();

    } catch(err) {
        showToast('error','Gagal memuat data');
    } finally {
        document.getElementById('loading').style.display = 'none';
        document.getElementById('table-wrap').style.display = 'block';
    }
}

function updateStats() {
    const rows  = document.querySelectorAll('#rekap-tbody tr[data-nis]');
    const total = rows.length;
    let hadir=0, izin=0, alpha=0;
    rows.forEach(r => {
        const badge = r.querySelector('.status-badge');
        if(!badge) return;
        const t = badge.textContent.trim().toLowerCase();
        if(t.includes('hadir')) hadir++;
        else if(t.includes('izin')) izin++;
        else if(t.includes('alpha')) alpha++;
    });
    document.getElementById('stat-total').textContent = total;
    document.getElementById('stat-hadir').textContent = hadir;
    document.getElementById('stat-izin').textContent  = izin;
    document.getElementById('stat-alpha').textContent = alpha;
    if(total > 0) document.getElementById('stats-row').style.display = 'grid';
}

function applyBadgeStyles() {
    document.querySelectorAll('.status-badge').forEach(badge => {
        const t = badge.textContent.trim().toLowerCase();
        badge.className = 'status-badge badge ' +
            (t.includes('hadir') ? 'badge-hadir' :
             t.includes('izin')  ? 'badge-izin'  :
             t.includes('sakit') ? 'badge-sakit' :
             t.includes('alpha') ? 'badge-alpha' : 'badge-default');
    });
    document.querySelectorAll('.status-select').forEach(sel => {
        sel.className = 'status-select';
    });
}

function bindStatusSelects() {
    document.querySelectorAll('.status-select').forEach(sel => {
        sel.addEventListener('change', async function() {
            const nis    = this.dataset.nis;
            const status = this.value;
            const tanggal  = document.getElementById('tanggal').value;
            const kegiatan = document.getElementById('kegiatan').value;
            try {
                const res = await fetch('/rekap/update-status', {
                    method:'POST',
                    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
                    body: JSON.stringify({nis, status, tanggal, jadwal_id: kegiatan})
                });
                const data = await res.json();
                if(data.success) {
                    const row   = this.closest('tr');
                    const badge = row.querySelector('.status-badge');
                    if(badge) { badge.textContent = status; applyBadgeStyles(); updateStats(); }
                    showToast('success','Status berhasil diperbarui');
                } else {
                    showToast('error', data.message || 'Gagal update status');
                }
            } catch(e) {
                showToast('error','Terjadi kesalahan');
            }
        });
    });
}

document.getElementById('btn-filter').addEventListener('click', loadRekap);
document.getElementById('btn-reset').addEventListener('click', () => {
    document.getElementById('tanggal').value  = new Date().toISOString().split('T')[0];
    document.getElementById('kelas').value    = '';
    document.getElementById('kegiatan').value = '';
    loadRekap();
});
document.getElementById('tanggal').addEventListener('change', () => {
    const kegiatan = document.getElementById('kegiatan').value;
    if (kegiatan) loadRekap();
});

// Initial
applyBadgeStyles();
updateStats();
bindStatusSelects();

function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type==='error'?'error':'success'}`;
    toast.innerHTML = `<span>${type==='error'?'✕':'✓'}</span> ${message}`;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(()=>{ toast.style.opacity='0'; toast.style.transition='opacity 0.3s'; setTimeout(()=>toast.remove(),300); }, 3500);
}
</script>
</x-app-layout>
