<x-app-layout>
@php
$totalIzin    = $izinList->count();
$belumKembali = $izinList->where('status','Belum Kembali')->count();
$sudahKembali = $izinList->where('status','Sudah Kembali')->count();
$terlambat = $izinList->where('status','Terlambat')->count();
$kabur = $izinList->where('status','Kabur')->count();
@endphp

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

/* ── Stats row ── */
.stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:12px; margin-bottom:16px; }
.stat-card {
    background:#fff; border-radius:16px; padding:16px 18px;
    border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04);
    display:flex; align-items:center; gap:12px;
}
.dark .stat-card { background:#1e293b; border-color:#334155; }
.stat-icon {
    width:40px; height:40px; border-radius:12px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.stat-label { font-size:0.7rem; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; margin:0 0 3px; }
.stat-value { font-size:1.4rem; font-weight:700; margin:0; line-height:1; }

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
    font-family:'Plus Jakarta Sans',sans-serif;
}
.dark .form-ctrl { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.form-ctrl:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.1); }
.btn-filter {
    padding:9px 18px; border-radius:10px;
    background:linear-gradient(135deg,#059669,#10b981);
    color:#fff; font-weight:600; font-size:0.83rem;
    border:none; cursor:pointer;
    box-shadow:0 2px 8px rgba(16,185,129,0.25); transition:all 0.2s;
}
.btn-filter:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(16,185,129,0.3); }

/* ── Table wrap ── */
.table-wrap {
    background:#fff; border-radius:16px;
    border:1px solid #e2e8f0; overflow:hidden;
    box-shadow:0 1px 4px rgba(0,0,0,0.04);
}
.dark .table-wrap { background:#1e293b; border-color:#334155; }

table { width:100%; border-collapse:collapse; font-size:0.82rem; }
th {
    padding:11px 16px; text-align:left;
    font-size:0.68rem; font-weight:700; color:#64748b;
    text-transform:uppercase; letter-spacing:0.04em;
    background:#f8fafc; border-bottom:1px solid #e2e8f0;
    white-space:nowrap;
}
.dark th { background:#0f172a; color:#94a3b8; border-color:#334155; }
td {
    padding:13px 16px; border-bottom:1px solid #f1f5f9;
    color:#374151; vertical-align:middle;
}
.dark td { border-color:#334155; color:#cbd5e1; }
tbody tr:hover td { background:#f8fafc; }
.dark tbody tr:hover td { background:rgba(255,255,255,0.02); }
tbody tr:last-child td { border-bottom:none; }

/* ── Avatar ── */
.row-avatar {
    width:34px; height:34px; border-radius:10px;
    background:linear-gradient(135deg,#10b981,#059669);
    display:flex; align-items:center; justify-content:center;
    font-size:0.8rem; font-weight:700; color:#fff;
    flex-shrink:0;
}

/* ── Badge ── */
.badge {
    display:inline-flex; align-items:center; gap:5px;
    padding:5px 12px; border-radius:20px;
    font-size:0.72rem; font-weight:700; white-space:nowrap;
}
.badge-belum {
    background:#fef3c7; color:#92400e;
    border:1px solid #fcd34d;
}
.badge-sudah {
    background:#dcfce7; color:#166534;
    border:1px solid #86efac;
}
.badge-terlambat {
    background:#fee2e2; color:#991b1b;
    border:1px solid #fca5a5;
}
.badge-kabur {
    background:#e2e8f0; color:#334155;
    border:1px solid #cbd5e1;
}
.dark .badge-belum { background:rgba(245,158,11,0.15); color:#fcd34d; border-color:rgba(252,211,77,0.3); }
.dark .badge-sudah { background:rgba(22,163,74,0.15); color:#4ade80; border-color:rgba(74,222,128,0.3); }
.dark .badge-terlambat { background:rgba(220,38,38,0.15); color:#fca5a5; border-color:rgba(252,165,165,0.3); }
.dark .badge-kabur { background:rgba(148,163,184,0.16); color:#cbd5e1; border-color:rgba(203,213,225,0.25); }

/* ── Kembali button ── */
.btn-kembali {
    display:inline-flex; align-items:center; gap:5px;
    padding:6px 14px; border-radius:8px;
    background:linear-gradient(135deg,#059669,#10b981);
    color:#fff; font-size:0.75rem; font-weight:600;
    border:none; cursor:pointer; transition:all 0.2s;
    box-shadow:0 2px 6px rgba(16,185,129,0.25);
    white-space:nowrap;
}
.btn-kembali:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(16,185,129,0.35); }
.btn-kembali:disabled { opacity:0.5; cursor:not-allowed; transform:none; }

/* ── Empty state ── */
.empty-state { text-align:center; padding:60px 24px; }
.empty-icon {
    width:56px; height:56px; border-radius:16px;
    background:#f1f5f9; display:flex; align-items:center; justify-content:center;
    margin:0 auto 14px;
}
.dark .empty-icon { background:#334155; }

/* ── Table footer ── */
.table-footer {
    padding:12px 20px; border-top:1px solid #f1f5f9;
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:8px;
}
.dark .table-footer { border-color:#334155; }
.footer-text { font-size:0.75rem; color:#94a3b8; }

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

<div class="page-bg">
    <div style="max-width:1100px;margin:0 auto;">

        {{-- Banner --}}
        <div class="page-banner">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;display:inline;margin-right:6px;vertical-align:-3px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
                Rekap Izin Keluar Santri
            </h1>
            <p>Pantau santri yang sedang izin keluar — {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            <div class="banner-actions">
                <a href="{{ route('izin.index') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Input Izin Keluar
                </a>
                <a href="{{ route('absen') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75z"/></svg>
                    Absensi
                </a>
                <a href="{{ route('dashboard') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Dashboard
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon" style="background:#ecfdf5;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-label">Total Izin</p>
                    <p class="stat-value" style="color:#059669;">{{ $totalIzin }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef3c7;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-label">Belum Kembali</p>
                    <p class="stat-value" style="color:#d97706;">{{ $belumKembali }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#dcfce7;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#059669" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-label">Sudah Kembali</p>
                    <p class="stat-value" style="color:#059669;">{{ $sudahKembali }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fee2e2;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#dc2626" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-label">Terlambat</p>
                    <p class="stat-value" style="color:#dc2626;">{{ $terlambat }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#e2e8f0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#475569" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zm-9.303-.374c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-label">Kabur</p>
                    <p class="stat-value" style="color:#475569;">{{ $kabur }}</p>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="filter-card">
            <form method="GET" action="{{ route('izin.rekap') }}">
                <div class="filter-row">
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-ctrl" value="{{ $tanggal }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" class="form-ctrl">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $kelasFilter == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-ctrl">
                            <option value="">Semua Status</option>
                            <option value="Belum Kembali" {{ $statusFilter == 'Belum Kembali' ? 'selected' : '' }}>Belum Kembali</option>
                            <option value="Sudah Kembali" {{ $statusFilter == 'Sudah Kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                            <option value="Terlambat" {{ $statusFilter == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="Kabur" {{ $statusFilter == 'Kabur' ? 'selected' : '' }}>Kabur</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-wrap">
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Santri</th>
                            <th>Kelas</th>
                            <th>Keperluan</th>
                            <th>Durasi / Tenggat</th>
                            <th>Waktu Keluar</th>
                            <th>Waktu Kembali</th>
                            <th>Ketepatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($izinList as $index => $izin)
                        <tr>
                            <td style="color:#94a3b8;font-size:0.72rem;">{{ $index + 1 }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="row-avatar">{{ strtoupper(substr($izin->santri->nama ?? '?', 0, 1)) }}</div>
                                    <div>
                                        <p style="font-weight:600;color:#1e293b;margin:0;font-size:0.85rem;" class="dark:text-white">{{ $izin->santri->nama ?? '-' }}</p>
                                        <p style="font-size:0.72rem;color:#94a3b8;margin:0;font-family:monospace;">{{ $izin->nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-size:0.78rem;color:#64748b;font-weight:500;">{{ $izin->santri->kelas ?? '-' }}</span>
                            </td>
                            <td style="max-width:200px;">
                                <p style="margin:0;font-size:0.82rem;color:#374151;white-space:normal;line-height:1.4;" class="dark:text-slate-300">{{ $izin->keperluan }}</p>
                            </td>
                            <td>
                                <span style="font-size:0.82rem;font-weight:600;color:#1e293b;" class="dark:text-slate-200">{{ $izin->durasi_label }}</span>
                                <p style="font-size:0.7rem;color:#94a3b8;margin:2px 0 0;">
                                    Tenggat:
                                    {{ $izin->batas_waktu_kembali ? \Carbon\Carbon::parse($izin->batas_waktu_kembali)->setTimezone('Asia/Jakarta')->format('d/m H:i') : '-' }}
                                </p>
                            </td>
                            <td>
                                <span style="font-size:0.82rem;font-weight:500;color:#1e293b;" class="dark:text-slate-200">
                                    {{ \Carbon\Carbon::parse($izin->waktu_keluar)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                </span>
                                <p style="font-size:0.7rem;color:#94a3b8;margin:2px 0 0;">{{ \Carbon\Carbon::parse($izin->waktu_keluar)->locale('id')->diffForHumans() }}</p>
                            </td>
                            <td>
                                @if($izin->waktu_kembali)
                                    <span style="font-size:0.82rem;font-weight:500;color:#059669;">
                                        {{ \Carbon\Carbon::parse($izin->waktu_kembali)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                    </span>
                                @else
                                    <span style="font-size:0.78rem;color:#94a3b8;">—</span>
                                @endif
                            </td>
                            <td>
                                <span style="font-size:0.78rem;color:#64748b;font-weight:600;">{{ $izin->ketepatan_label }}</span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($izin->status) {
                                        'Sudah Kembali' => 'badge-sudah',
                                        'Terlambat' => 'badge-terlambat',
                                        'Kabur' => 'badge-kabur',
                                        default => 'badge-belum',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $izin->status }}
                                </span>
                            </td>
                            <td>
                                @if($izin->status == 'Belum Kembali')
                                    <button
                                        class="btn-kembali"
                                        onclick="catatKembali({{ $izin->id }}, this)"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                                        Catat Kembali
                                    </button>
                                @else
                                    <span style="font-size:0.75rem;color:#94a3b8;">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#94a3b8" style="width:26px;height:26px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                        </svg>
                                    </div>
                                    <p style="font-weight:700;font-size:0.95rem;color:#475569;margin:0 0 4px;">Tidak ada data izin keluar</p>
                                    <p style="font-size:0.8rem;color:#94a3b8;margin:0;">Coba ubah filter tanggal atau kelas</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($izinList->count() > 0)
            <div class="table-footer">
                <span class="footer-text">{{ $izinList->count() }} data ditampilkan</span>
                <div style="display:flex;gap:6px;align-items:center;">
                    <span style="display:flex;align-items:center;gap:4px;font-size:0.72rem;color:#94a3b8;">
                        <span style="width:10px;height:10px;border-radius:3px;background:#fcd34d;display:inline-block;"></span> Belum Kembali
                    </span>
                    <span style="display:flex;align-items:center;gap:4px;font-size:0.72rem;color:#94a3b8;">
                        <span style="width:10px;height:10px;border-radius:3px;background:#86efac;display:inline-block;"></span> Sudah Kembali
                    </span>
                    <span style="display:flex;align-items:center;gap:4px;font-size:0.72rem;color:#94a3b8;">
                        <span style="width:10px;height:10px;border-radius:3px;background:#fca5a5;display:inline-block;"></span> Terlambat
                    </span>
                    <span style="display:flex;align-items:center;gap:4px;font-size:0.72rem;color:#94a3b8;">
                        <span style="width:10px;height:10px;border-radius:3px;background:#cbd5e1;display:inline-block;"></span> Kabur
                    </span>
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

<div class="toast-wrap" id="toast-container"></div>

<script>
const CSRF = '{{ csrf_token() }}';

async function catatKembali(izinId, btn) {
    if(!confirm('Catat santri ini sudah kembali?')) return;
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    try {
        const res  = await fetch(`/izin/${izinId}/kembali`, {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF, 'Accept':'application/json' },
            body: JSON.stringify({ izin_id: izinId })
        });
        const data = await res.json();

        if (data.success) {
            const status = data.data?.status || 'Sudah Kembali';
            showToast(status === 'Terlambat' ? 'warning' : 'success', data.message || 'Berhasil dicatat kembali!');
            // Update row tanpa reload
            const row  = btn.closest('tr');
            // Update badge
            const badgeCell = row.querySelector('td:nth-child(9)');
            const badgeClass = status === 'Terlambat' ? 'badge-terlambat' : 'badge-sudah';
            badgeCell.innerHTML = `<span class="badge ${badgeClass}">${status}</span>`;
            // Update waktu kembali
            const now = new Date();
            const jam = data.data?.waktu_kembali || String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');
            row.querySelector('td:nth-child(7)').innerHTML = `<span style="font-size:0.82rem;font-weight:500;color:#059669;">${jam}</span>`;
            row.querySelector('td:nth-child(8)').innerHTML = `<span style="font-size:0.78rem;color:#64748b;font-weight:600;">${data.data?.ketepatan_label || 'Tepat waktu'}</span>`;
            // Remove button
            btn.closest('td').innerHTML = `<span style="font-size:0.75rem;color:#94a3b8;">—</span>`;
            // Update stats
            updateStats();
        } else {
            showToast('error', data.message || 'Gagal mencatat kembali');
            btn.disabled = false;
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg> Catat Kembali`;
        }
    } catch(err) {
        showToast('error', 'Terjadi kesalahan jaringan');
        btn.disabled = false;
        btn.textContent = 'Catat Kembali';
    }
}

function updateStats() {
    const belumBadges = document.querySelectorAll('.badge-belum').length;
    const sudahBadges = document.querySelectorAll('.badge-sudah').length;
    const terlambatBadges = document.querySelectorAll('.badge-terlambat').length;
    const kaburBadges = document.querySelectorAll('.badge-kabur').length;
    const statValues = document.querySelectorAll('.stat-value');
    if(statValues[1]) statValues[1].textContent = belumBadges;
    if(statValues[2]) statValues[2].textContent = sudahBadges;
    if(statValues[3]) statValues[3].textContent = terlambatBadges;
    if(statValues[4]) statValues[4].textContent = kaburBadges;
}

function showToast(type, message) {
    const toast = document.createElement('div');
    const cls = type === 'error' ? 'error' : type === 'warning' ? 'warning' : 'success';
    toast.className = `toast toast-${cls}`;
    toast.innerHTML = `<span>${type === 'error' ? '✕' : type === 'warning' ? '!' : '✓'}</span> ${message}`;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}
</script>
</x-app-layout>
