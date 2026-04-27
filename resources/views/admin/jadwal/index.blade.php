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
    content:''; position:absolute; bottom:-30px; left:30%;
    width:120px; height:120px; border-radius:50%;
    background:rgba(6,78,59,0.4); pointer-events:none;
}
.page-banner h1 { color:#fff; font-size:1.3rem; font-weight:700; margin:0 0 4px; position:relative; z-index:1; }
.page-banner p  { color:#6ee7b7; font-size:0.82rem; margin:0; position:relative; z-index:1; }
.banner-actions { display:flex; gap:8px; margin-top:14px; flex-wrap:wrap; position:relative; z-index:1; }

.btn-primary {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 18px; border-radius:10px;
    background:#fff; color:#059669;
    font-size:0.83rem; font-weight:700; text-decoration:none;
    transition:all 0.15s; border:none; cursor:pointer;
    box-shadow:0 2px 8px rgba(0,0,0,0.12);
}
.btn-primary:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(0,0,0,0.18); }

.btn-white {
    display:inline-flex; align-items:center; gap:6px;
    padding:8px 16px; border-radius:10px;
    background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25);
    color:#fff; font-size:0.8rem; font-weight:600; text-decoration:none;
    transition:all 0.15s; backdrop-filter:blur(4px);
}
.btn-white:hover { background:rgba(255,255,255,0.25); }

/* ── Alert ── */
.alert {
    display:flex; align-items:center; gap:10px;
    padding:12px 16px; border-radius:12px;
    font-size:0.83rem; font-weight:500; margin-bottom:16px;
    animation:slideDown 0.3s ease forwards;
}
@keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
.alert-success { background:#dcfce7; color:#166534; border:1px solid #86efac; }
.alert-error   { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
.dark .alert-success { background:rgba(22,163,74,0.15); color:#4ade80; border-color:rgba(74,222,128,0.3); }
.dark .alert-error   { background:rgba(239,68,68,0.12); color:#fca5a5; border-color:rgba(252,165,165,0.3); }

/* ── Stats ── */
.stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(130px,1fr)); gap:12px; margin-bottom:16px; }
.stat-card {
    background:#fff; border-radius:14px; padding:14px 16px;
    border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04);
}
.dark .stat-card { background:#1e293b; border-color:#334155; }
.stat-label { font-size:0.68rem; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; margin:0 0 4px; }
.stat-value { font-size:1.5rem; font-weight:700; margin:0; }

/* ── Cards grid ── */
.jadwal-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:14px; }

.jadwal-card {
    background:#fff; border-radius:16px;
    border:1.5px solid #e2e8f0;
    box-shadow:0 1px 4px rgba(0,0,0,0.04);
    overflow:hidden; transition:all 0.22s cubic-bezier(0.4,0,0.2,1);
    position:relative;
}
.dark .jadwal-card { background:#1e293b; border-color:#334155; }
.jadwal-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.1); border-color:#10b981; }

.jadwal-card.inactive { opacity:0.65; }
.jadwal-card.inactive:hover { border-color:#94a3b8; }

/* ── Active pill on top ── */
.card-status-bar { height:3px; width:100%; }
.bar-aktif    { background:linear-gradient(90deg,#10b981,#059669); }
.bar-nonaktif { background:#cbd5e1; }

.card-body { padding:16px 18px; }

.card-top { display:flex; align-items:flex-start; justify-content:space-between; gap:10px; margin-bottom:12px; }

.kegiatan-icon {
    width:42px; height:42px; border-radius:12px;
    background:linear-gradient(135deg,#ecfdf5,#d1fae5);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.dark .kegiatan-icon { background:rgba(16,185,129,0.12); }

.card-title { font-size:0.95rem; font-weight:700; color:#1e293b; margin:0 0 2px; line-height:1.3; }
.dark .card-title { color:#f1f5f9; }
.card-kode  { font-size:0.7rem; color:#94a3b8; font-family:monospace; font-weight:600; margin:0; }

/* ── Toggle switch ── */
.toggle-wrap { display:flex; align-items:center; gap:6px; flex-shrink:0; }
.toggle-label { font-size:0.7rem; font-weight:600; white-space:nowrap; }
.toggle-switch {
    position:relative; width:36px; height:20px;
    display:inline-block; cursor:pointer;
}
.toggle-switch input { opacity:0; width:0; height:0; }
.toggle-slider {
    position:absolute; inset:0; border-radius:20px;
    background:#cbd5e1; transition:background 0.2s;
}
.toggle-slider::before {
    content:''; position:absolute;
    width:14px; height:14px; border-radius:50%;
    background:#fff; left:3px; top:3px;
    transition:transform 0.2s;
    box-shadow:0 1px 3px rgba(0,0,0,0.2);
}
input:checked + .toggle-slider { background:#10b981; }
input:checked + .toggle-slider::before { transform:translateX(16px); }

/* ── Jam & hari info ── */
.card-info-row { display:flex; gap:8px; margin-bottom:12px; }
.info-chip {
    display:inline-flex; align-items:center; gap:5px;
    padding:5px 10px; border-radius:8px;
    background:#f8fafc; font-size:0.75rem; font-weight:600; color:#475569;
}
.dark .info-chip { background:#0f172a; color:#94a3b8; }

.hari-wrap { display:flex; flex-wrap:wrap; gap:4px; margin-bottom:14px; }
.hari-pill {
    padding:3px 8px; border-radius:6px;
    font-size:0.68rem; font-weight:700;
    background:#ecfdf5; color:#059669;
    border:1px solid #a7f3d0;
}
.dark .hari-pill { background:rgba(16,185,129,0.12); color:#34d399; border-color:rgba(52,211,153,0.25); }
.hari-all {
    padding:3px 10px; border-radius:6px;
    font-size:0.68rem; font-weight:700;
    background:#f0f9ff; color:#0369a1;
    border:1px solid #bae6fd;
}
.dark .hari-all { background:rgba(3,105,161,0.12); color:#7dd3fc; border-color:rgba(125,211,252,0.25); }

/* ── Card actions ── */
.card-actions { display:flex; gap:8px; padding-top:12px; border-top:1px solid #f1f5f9; }
.dark .card-actions { border-color:#334155; }
.btn-edit {
    flex:1; padding:8px; border-radius:9px;
    background:#f8fafc; color:#475569;
    font-size:0.78rem; font-weight:600;
    text-decoration:none; text-align:center;
    border:1.5px solid #e2e8f0; transition:all 0.15s;
    display:flex; align-items:center; justify-content:center; gap:5px;
}
.dark .btn-edit { background:#0f172a; border-color:#334155; color:#94a3b8; }
.btn-edit:hover { border-color:#10b981; color:#059669; background:#ecfdf5; }
.dark .btn-edit:hover { background:rgba(16,185,129,0.08); color:#34d399; }

.btn-hapus {
    padding:8px 14px; border-radius:9px;
    background:#fff1f2; color:#e11d48;
    font-size:0.78rem; font-weight:600;
    border:1.5px solid #fecdd3; cursor:pointer;
    transition:all 0.15s;
    display:flex; align-items:center; gap:5px;
}
.dark .btn-hapus { background:rgba(225,29,72,0.1); border-color:rgba(254,205,211,0.2); color:#fb7185; }
.btn-hapus:hover { background:#ffe4e6; border-color:#fda4af; }

/* ── Empty state ── */
.empty-state {
    background:#fff; border-radius:16px; border:1.5px dashed #e2e8f0;
    padding:60px 24px; text-align:center;
}
.dark .empty-state { background:#1e293b; border-color:#334155; }
.empty-icon {
    width:60px; height:60px; border-radius:18px;
    background:#ecfdf5; display:flex; align-items:center; justify-content:center;
    margin:0 auto 16px;
}
.dark .empty-icon { background:rgba(16,185,129,0.1); }

/* ── Toast ── */
.toast-wrap { position:fixed; top:20px; right:20px; z-index:999; display:flex; flex-direction:column; gap:8px; }
.toast {
    display:flex; align-items:center; gap:10px;
    padding:12px 16px; border-radius:12px;
    font-size:0.85rem; font-weight:500; color:#fff;
    box-shadow:0 8px 24px rgba(0,0,0,0.15);
    animation:toastIn 0.3s cubic-bezier(0.34,1.4,0.64,1) forwards;
    min-width:220px;
}
@keyframes toastIn { from{opacity:0;transform:translateX(40px) scale(0.9)} to{opacity:1;transform:translateX(0) scale(1)} }
.toast-success { background:linear-gradient(135deg,#059669,#10b981); }
.toast-error   { background:linear-gradient(135deg,#dc2626,#ef4444); }
</style>

<div class="page-bg">
    <div style="max-width:1100px;margin:0 auto;">

        {{-- Alerts --}}
        @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif

        {{-- Banner --}}
        <div class="page-banner">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;display:inline;margin-right:6px;vertical-align:-3px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                Kelola Jadwal Absensi
            </h1>
            <p>Atur jadwal kegiatan absensi santri — aktifkan atau nonaktifkan sesuai kebutuhan</p>
            <div class="banner-actions">
                <a href="{{ route('jadwal.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tambah Jadwal
                </a>
                <a href="{{ route('dashboard') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Dashboard
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row">
            @php
                $totalJadwal  = $jadwals->count();
                $aktifJadwal  = $jadwals->where('aktif', true)->count();
                $nonaktif     = $totalJadwal - $aktifJadwal;
            @endphp
            <div class="stat-card">
                <p class="stat-label">Total Jadwal</p>
                <p class="stat-value" style="color:#059669;">{{ $totalJadwal }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Aktif</p>
                <p class="stat-value" style="color:#10b981;">{{ $aktifJadwal }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Nonaktif</p>
                <p class="stat-value" style="color:#94a3b8;">{{ $nonaktif }}</p>
            </div>
        </div>

        {{-- Jadwal Cards --}}
        @if($jadwals->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:28px;height:28px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
            </div>
            <p style="font-weight:700;font-size:1rem;color:#475569;margin:0 0 6px;">Belum ada jadwal</p>
            <p style="font-size:0.82rem;color:#94a3b8;margin:0 0 20px;">Mulai dengan menambahkan jadwal kegiatan pertama</p>
            <a href="{{ route('jadwal.create') }}" class="btn-primary" style="display:inline-flex;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah Jadwal
            </a>
        </div>
        @else
        <div class="jadwal-grid">
            @php $dayNames = [1=>'Sen',2=>'Sel',3=>'Rab',4=>'Kam',5=>'Jum',6=>'Sab',7=>'Min']; @endphp
            @foreach($jadwals as $j)
            <div class="jadwal-card {{ $j->aktif ? '' : 'inactive' }}" id="card-{{ $j->id }}">
                <div class="card-status-bar {{ $j->aktif ? 'bar-aktif' : 'bar-nonaktif' }}" id="bar-{{ $j->id }}"></div>
                <div class="card-body">
                    <div class="card-top">
                        <div style="display:flex;align-items:flex-start;gap:12px;flex:1;min-width:0;">
                            <div class="kegiatan-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:20px;height:20px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                            </div>
                            <div style="min-width:0;">
                                <p class="card-title">{{ $j->nama_kegiatan }}</p>
                                <p class="card-kode">{{ $j->kode ? 'Kode: '.$j->kode : 'Tanpa kode' }}</p>
                            </div>
                        </div>
                        {{-- Toggle --}}
                        <div class="toggle-wrap">
                            <span class="toggle-label" id="label-{{ $j->id }}" style="color:{{ $j->aktif ? '#059669' : '#94a3b8' }};">
                                {{ $j->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <label class="toggle-switch">
                                <input type="checkbox" class="toggle-aktif" data-id="{{ $j->id }}" {{ $j->aktif ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    {{-- Jam --}}
                    <div class="card-info-row">
                        <div class="info-chip">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:14px;height:14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \Illuminate\Support\Str::of($j->jam_mulai)->substr(0,5) }} – {{ \Illuminate\Support\Str::of($j->jam_selesai)->substr(0,5) }}
                        </div>
                        @if($j->keterangan)
                        <div class="info-chip" style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;max-width:160px;" title="{{ $j->keterangan }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#94a3b8" style="width:13px;height:13px;flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                            </svg>
                            {{ \Illuminate\Support\Str::limit($j->keterangan, 22) }}
                        </div>
                        @endif
                    </div>

                    {{-- Hari --}}
                    <div class="hari-wrap">
                        @if(empty($j->hari))
                            <span class="hari-all">Setiap Hari</span>
                        @else
                            @foreach($j->hari as $h)
                                <span class="hari-pill">{{ $dayNames[$h] ?? $h }}</span>
                            @endforeach
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="card-actions">
                        <a href="{{ route('jadwal.edit', $j->id) }}" class="btn-edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                            </svg>
                            Edit Jadwal
                        </a>
                        <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal \'{{ $j->nama_kegiatan }}\'?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

<div class="toast-wrap" id="toast-container"></div>

<script>
const CSRF = '{{ csrf_token() }}';

document.querySelectorAll('.toggle-aktif').forEach(input => {
    input.addEventListener('change', async function() {
        const id     = this.dataset.id;
        const aktif  = this.checked;
        const label  = document.getElementById(`label-${id}`);
        const bar    = document.getElementById(`bar-${id}`);
        const card   = document.getElementById(`card-${id}`);

        this.disabled = true;
        try {
            const res  = await fetch(`{{ url('jadwal') }}/${id}/toggle`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
            });
            const data = await res.json();

            if(data.ok) {
                const isAktif = !!data.aktif;
                label.textContent   = isAktif ? 'Aktif' : 'Nonaktif';
                label.style.color   = isAktif ? '#059669' : '#94a3b8';
                bar.className       = `card-status-bar ${isAktif ? 'bar-aktif' : 'bar-nonaktif'}`;
                card.classList.toggle('inactive', !isAktif);
                showToast('success', isAktif ? 'Jadwal diaktifkan!' : 'Jadwal dinonaktifkan');
            } else {
                this.checked = !aktif;
                showToast('error', 'Gagal mengubah status jadwal');
            }
        } catch(e) {
            this.checked = !aktif;
            showToast('error', 'Terjadi kesalahan jaringan');
        } finally {
            this.disabled = false;
        }
    });
});

function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type === 'error' ? 'error' : 'success'}`;
    toast.innerHTML = `<span>${type === 'error' ? '✕' : '✓'}</span> ${message}`;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
</x-app-layout>