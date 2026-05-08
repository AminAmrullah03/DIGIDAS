<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-bg { min-height:100vh; background:#f1f5f9; padding:28px 16px; }
.dark .page-bg { background:#0f172a; }
.page-wrap { max-width:1180px; margin:0 auto; }

.page-banner {
    background:linear-gradient(135deg,#064e3b 0%,#065f46 52%,#0d9488 100%);
    border-radius:20px; padding:24px 28px; margin-bottom:18px;
    position:relative; overflow:hidden;
}
.page-banner::before {
    content:''; position:absolute; top:-54px; right:-42px;
    width:176px; height:176px; border-radius:50%;
    background:rgba(45,212,191,0.14); pointer-events:none;
}
.page-banner::after {
    content:''; position:absolute; bottom:-56px; left:28%;
    width:142px; height:142px; border-radius:50%;
    background:rgba(6,78,59,0.36); pointer-events:none;
}
.page-banner h1 { color:#fff; font-size:1.28rem; font-weight:700; margin:0 0 5px; position:relative; z-index:1; }
.page-banner p { color:#a7f3d0; font-size:0.82rem; margin:0; position:relative; z-index:1; }
.banner-actions { display:flex; gap:8px; margin-top:14px; flex-wrap:wrap; position:relative; z-index:1; }

.btn-primary, .btn-white, .btn-soft, .btn-action, .btn-danger {
    display:inline-flex; align-items:center; justify-content:center; gap:7px;
    border-radius:10px; font-size:0.8rem; font-weight:700;
    text-decoration:none; border:none; cursor:pointer; transition:all 0.16s;
}
.btn-primary { padding:9px 17px; background:#fff; color:#047857; box-shadow:0 2px 10px rgba(0,0,0,0.13); }
.btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,0,0,0.16); }
.btn-white { padding:8px 15px; color:#fff; background:rgba(255,255,255,0.14); border:1px solid rgba(255,255,255,0.24); }
.btn-white:hover { background:rgba(255,255,255,0.23); }
.btn-soft { padding:8px 12px; color:#475569; background:#f8fafc; border:1px solid #e2e8f0; }
.btn-soft:hover { color:#047857; border-color:#99f6e4; background:#f0fdfa; }
.btn-action { padding:8px 12px; color:#0369a1; background:#eff6ff; border:1px solid #bfdbfe; }
.btn-action:hover { background:#dbeafe; }
.btn-danger { padding:8px 12px; color:#be123c; background:#fff1f2; border:1px solid #fecdd3; }
.btn-danger:hover { background:#ffe4e6; }
.btn-locked { padding:8px 12px; color:#94a3b8; background:#f8fafc; border:1px solid #e2e8f0; cursor:not-allowed; }

.alert {
    display:flex; align-items:flex-start; gap:10px; padding:12px 15px;
    border-radius:12px; font-size:0.83rem; font-weight:600; margin-bottom:14px;
}
.alert-success { background:#dcfce7; color:#166534; border:1px solid #86efac; }
.alert-info { background:#dbeafe; color:#1d4ed8; border:1px solid #93c5fd; }
.alert-error { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }

.stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:12px; margin-bottom:16px; }
.stat-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:14px;
    padding:15px 16px; box-shadow:0 1px 4px rgba(15,23,42,0.05);
}
.dark .stat-card, .dark .table-card, .dark .active-card, .dark .empty-state { background:#1e293b; border-color:#334155; }
.stat-label { margin:0 0 5px; font-size:0.67rem; color:#94a3b8; font-weight:800; text-transform:uppercase; letter-spacing:0.05em; }
.stat-value { margin:0; font-size:1.42rem; color:#0f172a; font-weight:800; }
.dark .stat-value { color:#f1f5f9; }
.stat-note { margin:4px 0 0; font-size:0.73rem; color:#94a3b8; }

.active-card {
    background:#fff; border:1px solid #d1fae5; border-radius:16px;
    padding:16px 18px; margin-bottom:16px; display:flex; align-items:center;
    justify-content:space-between; gap:16px; box-shadow:0 1px 5px rgba(15,23,42,0.05);
}
.active-icon {
    width:44px; height:44px; border-radius:12px; background:#ecfdf5;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.active-title { margin:0 0 3px; color:#0f172a; font-size:0.98rem; font-weight:800; }
.dark .active-title { color:#f8fafc; }
.active-meta { margin:0; color:#64748b; font-size:0.8rem; }
.dark .active-meta { color:#94a3b8; }

.table-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:16px;
    overflow:hidden; box-shadow:0 1px 4px rgba(15,23,42,0.05);
}
.table-head {
    display:flex; align-items:center; justify-content:space-between; gap:12px;
    padding:15px 18px; border-bottom:1px solid #e2e8f0;
}
.dark .table-head { border-color:#334155; }
.table-head h2 { margin:0; font-size:0.96rem; color:#0f172a; font-weight:800; }
.dark .table-head h2 { color:#f8fafc; }
.table-head p { margin:3px 0 0; font-size:0.76rem; color:#94a3b8; }
table { width:100%; border-collapse:collapse; font-size:0.79rem; }
th {
    padding:11px 14px; background:#f8fafc; color:#64748b; text-align:left;
    font-size:0.67rem; font-weight:800; text-transform:uppercase; letter-spacing:0.045em;
    border-bottom:1px solid #e2e8f0; white-space:nowrap;
}
td { padding:13px 14px; border-bottom:1px solid #f1f5f9; color:#334155; vertical-align:middle; }
.dark th { background:#0f172a; color:#94a3b8; border-color:#334155; }
.dark td { color:#cbd5e1; border-color:#334155; }
tbody tr:hover td { background:#f8fafc; }
.dark tbody tr:hover td { background:rgba(255,255,255,0.025); }
tbody tr:last-child td { border-bottom:none; }
.name-cell { display:flex; align-items:center; gap:10px; min-width:170px; }
.row-icon {
    width:36px; height:36px; border-radius:10px; background:#f0fdfa;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.row-title { margin:0; font-weight:800; color:#0f172a; }
.dark .row-title { color:#f8fafc; }
.row-sub { margin:2px 0 0; color:#94a3b8; font-size:0.72rem; }
.badge {
    display:inline-flex; align-items:center; gap:5px; padding:4px 9px;
    border-radius:999px; font-size:0.68rem; font-weight:800;
}
.badge-active { background:#dcfce7; color:#166534; }
.badge-done { background:#f1f5f9; color:#64748b; }
.dark .badge-active { background:rgba(22,163,74,0.16); color:#4ade80; }
.dark .badge-done { background:rgba(100,116,139,0.16); color:#cbd5e1; }
.mini-counts { display:flex; gap:5px; flex-wrap:wrap; }
.mini-pill {
    padding:4px 7px; border-radius:8px; background:#f8fafc; color:#64748b;
    border:1px solid #e2e8f0; font-size:0.68rem; font-weight:700;
}
.dark .mini-pill { background:#0f172a; border-color:#334155; color:#94a3b8; }
.actions { display:flex; gap:7px; justify-content:flex-end; align-items:center; flex-wrap:wrap; min-width:220px; }
.empty-state {
    background:#fff; border:1.5px dashed #cbd5e1; border-radius:16px;
    padding:54px 20px; text-align:center;
}
.empty-icon {
    width:58px; height:58px; border-radius:16px; background:#ecfdf5;
    display:flex; align-items:center; justify-content:center; margin:0 auto 14px;
}

@media (max-width: 760px) {
    .page-banner { padding:22px 20px; }
    .active-card { align-items:flex-start; flex-direction:column; }
    .table-head { align-items:flex-start; flex-direction:column; }
    th, td { padding:11px 12px; }
}
</style>

@php
    $total = $list->count();
    $aktifRow = $list->first(fn ($ta) => $ta->isAktif());
    $selesai = $list->where('status', 'selesai')->count();
    $totalSantriKelas = $list->sum('santri_kelas_count');
    $totalTagihan = $list->sum('spp_tagihan_count');
@endphp

<div class="page-bg">
    <div class="page-wrap">
        @if(session('success'))
            <div class="alert alert-success">
                <span>✓</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">
                <span>i</span>
                <div>{{ session('info') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <span>!</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <div class="page-banner">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;display:inline;margin-right:6px;vertical-align:-3px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15A1.5 1.5 0 0121 6.75v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12A1.5 1.5 0 014.5 5.25z"/>
                </svg>
                Manajemen Tahun Ajaran
            </h1>
            <p>Atur periode akademik, nominal SPP, dan tahun ajaran aktif untuk data kelas, absensi, dan pembayaran.</p>
            <div class="banner-actions">
                <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tambah Tahun Ajaran
                </a>
                <a href="{{ route('dashboard') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg>
                    Dashboard
                </a>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <p class="stat-label">Total Tahun</p>
                <p class="stat-value" style="color:#0f766e;">{{ $total }}</p>
                <p class="stat-note">{{ $selesai }} sudah selesai</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Tahun Aktif</p>
                <p class="stat-value" style="color:#059669;">{{ $aktifRow?->nama ?? '-' }}</p>
                <p class="stat-note">{{ $aktifRow ? $aktifRow->tahun_hijriah . 'H / ' . $aktifRow->tahun_masehi : 'Belum dipilih' }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Data Kelas</p>
                <p class="stat-value" style="color:#7c3aed;">{{ $totalSantriKelas }}</p>
                <p class="stat-note">Riwayat kelas santri</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Tagihan SPP</p>
                <p class="stat-value" style="color:#0284c7;">{{ $totalTagihan }}</p>
                <p class="stat-note">Terhubung ke tahun ajaran</p>
            </div>
        </div>

        @if($aktifRow)
            <div class="active-card">
                <div style="display:flex;align-items:center;gap:13px;">
                    <div class="active-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#059669" style="width:22px;height:22px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="active-title">{{ $aktifRow->nama }} sedang aktif</p>
                        <p class="active-meta">
                            {{ $aktifRow->tanggal_mulai->format('d M Y') }} sampai {{ $aktifRow->tanggal_selesai->format('d M Y') }}
                            - SPP Rp {{ number_format($aktifRow->nominal_spp, 0, ',', '.') }}/bulan
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.tahun-ajaran.edit', $aktifRow) }}" class="btn-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Edit Aktif
                </a>
            </div>
        @endif

        @if($list->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#059669" style="width:28px;height:28px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15A1.5 1.5 0 0121 6.75v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12A1.5 1.5 0 014.5 5.25z"/>
                    </svg>
                </div>
                <p style="font-weight:800;font-size:1rem;color:#475569;margin:0 0 6px;">Belum ada tahun ajaran</p>
                <p style="font-size:0.82rem;color:#94a3b8;margin:0 0 18px;">Tambahkan tahun ajaran pertama untuk mulai mengelola periode akademik.</p>
                <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn-primary">Tambah Tahun Ajaran</a>
            </div>
        @else
            <div class="table-card">
                <div class="table-head">
                    <div>
                        <h2>Daftar Tahun Ajaran</h2>
                        <p>Pilih satu tahun ajaran aktif. Data lama tetap tersimpan sebagai riwayat.</p>
                    </div>
                    <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Tambah
                    </a>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <th>Periode</th>
                                <th>Nominal SPP</th>
                                <th>Data Terkait</th>
                                <th>Status</th>
                                <th style="text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $ta)
                                @php
                                    $relatedTotal = $ta->santri_kelas_count + $ta->spp_tagihan_count + $ta->spp_pembayaran_count + $ta->absensi_count;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="row-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#0d9488" style="width:19px;height:19px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15A1.5 1.5 0 0121 6.75v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12A1.5 1.5 0 014.5 5.25z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="row-title">{{ $ta->nama }}</p>
                                                <p class="row-sub">{{ $ta->tahun_hijriah }}H / {{ $ta->tahun_masehi }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $ta->tanggal_mulai->format('d M Y') }}<br>
                                        <span style="color:#94a3b8;">sampai {{ $ta->tanggal_selesai->format('d M Y') }}</span>
                                    </td>
                                    <td style="font-weight:800;color:#0f766e;">Rp {{ number_format($ta->nominal_spp, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="mini-counts">
                                            <span class="mini-pill">{{ $ta->santri_kelas_count }} kelas</span>
                                            <span class="mini-pill">{{ $ta->spp_tagihan_count }} tagihan</span>
                                            <span class="mini-pill">{{ $ta->absensi_count }} absen</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($ta->isAktif())
                                            <span class="badge badge-active">Aktif</span>
                                        @else
                                            <span class="badge badge-done">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('admin.tahun-ajaran.edit', $ta) }}" class="btn-soft">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                                Edit
                                            </a>
                                            @if(! $ta->isAktif())
                                                <form method="POST" action="{{ route('admin.tahun-ajaran.activate', $ta) }}" onsubmit="return confirm('Aktifkan tahun ajaran {{ $ta->nama }}? Tahun ajaran yang sedang aktif akan ditutup.')">
                                                    @csrf
                                                    <button type="submit" class="btn-action">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        Aktifkan
                                                    </button>
                                                </form>
                                                @if($relatedTotal > 0)
                                                    <button type="button" class="btn-locked" title="Tidak bisa dihapus karena punya data terkait">
                                                        Terkunci
                                                    </button>
                                                @else
                                                    <form method="POST" action="{{ route('admin.tahun-ajaran.destroy', $ta) }}" onsubmit="return confirm('Hapus tahun ajaran {{ $ta->nama }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79"/></svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
</x-app-layout>
