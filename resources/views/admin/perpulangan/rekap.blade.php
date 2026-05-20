<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
* { font-family:'Plus Jakarta Sans',sans-serif; }
.page { min-height:100vh; background:#f4f7fb; padding:28px 16px; }
.dark .page { background:#0f172a; }
.wrap { max-width:1220px; margin:0 auto; }
.hero {
    display:flex; align-items:flex-start; justify-content:space-between; gap:18px;
    padding:22px 24px; margin-bottom:16px; border:1px solid #dbe5f2;
    border-radius:16px; background:#ffffff; box-shadow:0 10px 30px rgba(15,23,42,.06);
}
.dark .hero, .dark .panel, .dark .table-card { background:#1e293b; border-color:#334155; }
.hero h1 { margin:0; color:#0f172a; font-size:1.35rem; font-weight:800; letter-spacing:0; }
.dark .hero h1, .dark .section-title, .dark .name { color:#f8fafc; }
.hero p { margin:6px 0 0; color:#64748b; font-size:.84rem; max-width:680px; }
.hero-actions { display:flex; gap:8px; flex-wrap:wrap; }
.btn {
    display:inline-flex; align-items:center; justify-content:center; gap:7px;
    min-height:38px; padding:8px 13px; border-radius:8px; border:1px solid transparent;
    font-size:.8rem; font-weight:800; text-decoration:none; cursor:pointer; transition:.15s;
}
.btn-primary { color:#fff; background:#0f766e; border-color:#0f766e; }
.btn-primary:hover { background:#115e59; }
.btn-soft { color:#334155; background:#f8fafc; border-color:#dbe5f2; }
.btn-soft:hover { color:#0f766e; border-color:#99f6e4; background:#f0fdfa; }
.btn-info { color:#075985; background:#eff6ff; border-color:#bfdbfe; }
.alert { display:flex; gap:10px; padding:12px 14px; margin-bottom:14px; border-radius:10px; font-size:.84rem; font-weight:700; }
.alert-success { color:#166534; background:#dcfce7; border:1px solid #86efac; }
.alert-error { color:#991b1b; background:#fee2e2; border:1px solid #fca5a5; }
.stats { display:grid; grid-template-columns:repeat(8,minmax(110px,1fr)); gap:10px; margin-bottom:14px; }
.stat { padding:14px; border:1px solid #dbe5f2; border-radius:12px; background:#fff; }
.dark .stat { background:#1e293b; border-color:#334155; }
.stat-label { margin:0 0 5px; color:#64748b; font-size:.68rem; font-weight:800; text-transform:uppercase; letter-spacing:.04em; }
.stat-value { margin:0; color:#0f172a; font-size:1.35rem; font-weight:800; }
.dark .stat-value { color:#f8fafc; }
.panel {
    margin-bottom:14px; padding:16px; border:1px solid #dbe5f2; border-radius:14px;
    background:#fff; box-shadow:0 1px 4px rgba(15,23,42,.04);
}
.filter-grid { display:grid; grid-template-columns:1.4fr 1fr 1fr 1.2fr auto; gap:10px; align-items:end; }
.label { display:block; margin-bottom:5px; color:#64748b; font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.04em; }
.input, .select {
    width:100%; min-height:38px; padding:8px 11px; border:1.5px solid #dbe5f2; border-radius:8px;
    color:#334155; background:#fff; font-size:.82rem; box-sizing:border-box;
}
.input:focus, .select:focus { outline:none; border-color:#14b8a6; box-shadow:0 0 0 3px rgba(20,184,166,.12); }
.dark .input, .dark .select { background:#0f172a; border-color:#334155; color:#cbd5e1; }
.table-card {
    border:1px solid #dbe5f2; border-radius:14px; background:#fff;
    overflow:hidden; box-shadow:0 1px 4px rgba(15,23,42,.04);
}
.table-head {
    display:flex; align-items:center; justify-content:space-between; gap:12px;
    padding:15px 16px; border-bottom:1px solid #e2e8f0;
}
.dark .table-head { border-color:#334155; }
.section-title { margin:0; color:#0f172a; font-size:.98rem; font-weight:800; }
.muted { margin:4px 0 0; color:#64748b; font-size:.78rem; }
.event-pill { display:inline-flex; align-items:center; gap:7px; padding:7px 10px; border-radius:8px; background:#ecfeff; color:#0e7490; font-size:.78rem; font-weight:800; }
table { width:100%; border-collapse:collapse; font-size:.8rem; }
th {
    padding:11px 14px; text-align:left; color:#64748b; background:#f8fafc;
    border-bottom:1px solid #e2e8f0; font-size:.68rem; font-weight:800;
    text-transform:uppercase; letter-spacing:.04em; white-space:nowrap;
}
td { padding:12px 14px; border-bottom:1px solid #eef2f7; color:#334155; vertical-align:middle; }
.dark th { background:#0f172a; color:#94a3b8; border-color:#334155; }
.dark td { color:#cbd5e1; border-color:#334155; }
tbody tr:hover td { background:#f8fafc; }
.dark tbody tr:hover td { background:rgba(255,255,255,.025); }
.person { display:flex; align-items:center; gap:10px; min-width:220px; }
.avatar { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:.74rem; font-weight:800; background:#0f766e; flex-shrink:0; }
.avatar-pi { background:#be185d; }
.name { margin:0; color:#0f172a; font-size:.84rem; font-weight:800; }
.nis { margin:2px 0 0; color:#94a3b8; font-size:.72rem; }
.chips { display:flex; flex-wrap:wrap; gap:6px; min-width:260px; }
.chip { display:inline-flex; align-items:center; gap:5px; padding:4px 8px; border-radius:999px; font-size:.68rem; font-weight:800; }
.chip-ok { color:#166534; background:#dcfce7; }
.chip-wait { color:#854d0e; background:#fef9c3; }
.badge { display:inline-flex; align-items:center; gap:6px; padding:5px 10px; border-radius:999px; font-size:.7rem; font-weight:800; white-space:nowrap; }
.status-menunggu { color:#475569; background:#f1f5f9; }
.status-sebagian { color:#854d0e; background:#fef3c7; }
.status-diizinkan { color:#075985; background:#e0f2fe; }
.status-keluar { color:#9a3412; background:#ffedd5; }
.status-kembali { color:#166534; background:#dcfce7; }
.status-kabur { color:#991b1b; background:#fee2e2; }
.status-terlambat { color:#be123c; background:#ffe4e6; }
.empty {
    padding:48px 20px; text-align:center; border:1.5px dashed #cbd5e1;
    border-radius:14px; background:#fff;
}
.dark .empty { background:#1e293b; border-color:#334155; }
.empty h2 { margin:0 0 6px; color:#0f172a; font-size:1rem; font-weight:800; }
.dark .empty h2 { color:#f8fafc; }
.empty p { margin:0 0 16px; color:#64748b; font-size:.84rem; }
.pagi { padding:14px 16px; border-top:1px solid #e2e8f0; }
.dark .pagi { border-color:#334155; }
@media(max-width:1000px) {
    .stats { grid-template-columns:repeat(3,minmax(120px,1fr)); }
    .filter-grid { grid-template-columns:1fr 1fr; }
}
@media(max-width:700px) {
    .hero { flex-direction:column; }
    .stats { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .filter-grid { grid-template-columns:1fr; }
    th:nth-child(3), td:nth-child(3), th:nth-child(6), td:nth-child(6) { display:none; }
}
</style>

@php
    $statusOptions = [
        'menunggu' => 'Menunggu',
        'sebagian' => 'Sebagian',
        'diizinkan' => 'Diizinkan',
        'keluar' => 'Keluar',
        'kembali' => 'Kembali',
        'kabur' => 'Kabur',
        'terlambat_kembali' => 'Terlambat Kembali',
    ];

    $statusClass = [
        'menunggu' => 'status-menunggu',
        'sebagian' => 'status-sebagian',
        'diizinkan' => 'status-diizinkan',
        'keluar' => 'status-keluar',
        'kembali' => 'status-kembali',
        'kabur' => 'status-kabur',
        'terlambat_kembali' => 'status-terlambat',
    ];

    $approvalLabels = [
        'musrif' => 'Musrif',
        'spp' => 'SPP',
        'keamanan' => 'Keamanan',
    ];
@endphp

<div class="page">
    <div class="wrap">
        @if(session('success'))
            <div class="alert alert-success"><span>OK</span><div>{{ session('success') }}</div></div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><span>!</span><div>{{ session('error') }}</div></div>
        @endif

        <section class="hero">
            <div>
                <h1>Rekap Perpulangan</h1>
                <p>
                    Pantau status approval, santri yang sudah keluar, dan santri yang sudah kembali untuk event perpulangan.
                </p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('admin.perpulangan.index') }}" class="btn btn-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
                    Kelola Event
                </a>
                <a href="{{ route('perpulangan.scan.musrif') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Scan Approval
                </a>
            </div>
        </section>

        <section class="stats">
            <div class="stat"><p class="stat-label">Total</p><p class="stat-value">{{ $stats['total'] ?? 0 }}</p></div>
            <div class="stat"><p class="stat-label">Menunggu</p><p class="stat-value" style="color:#475569;">{{ $stats['menunggu'] ?? 0 }}</p></div>
            <div class="stat"><p class="stat-label">Sebagian</p><p class="stat-value" style="color:#d97706;">{{ $stats['sebagian'] ?? 0 }}</p></div>
            <div class="stat"><p class="stat-label">Diizinkan</p><p class="stat-value" style="color:#0284c7;">{{ $stats['diizinkan'] ?? 0 }}</p></div>
            <div class="stat"><p class="stat-label">Keluar</p><p class="stat-value" style="color:#ea580c;">{{ $stats['keluar'] ?? 0 }}</p></div>
            <div class="stat"><p class="stat-label">Kembali</p><p class="stat-value" style="color:#16a34a;">{{ $stats['kembali'] ?? 0 }}</p></div>
            <div class="stat"><p class="stat-label">Kabur</p><p class="stat-value" style="color:#dc2626;">{{ $stats['kabur'] ?? 0 }}</p></div>
            <div class="stat"><p class="stat-label">Terlambat</p><p class="stat-value" style="color:#be123c;">{{ $stats['terlambat_kembali'] ?? 0 }}</p></div>
        </section>

        <section class="panel">
            <form method="GET" action="{{ route('admin.perpulangan.rekap') }}">
                <div class="filter-grid">
                    <div>
                        <label class="label">Event</label>
                        <select name="perpulangan_id" class="select">
                            <option value="">Event aktif / terbaru</option>
                            @foreach($eventList as $event)
                                <option value="{{ $event->id }}" @selected((string) request('perpulangan_id') === (string) $event->id)>
                                    {{ $event->nama_event }} ({{ $event->tanggal_mulai->format('d/m/Y') }} - {{ $event->batas_kembali->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Kelas</label>
                        <select name="kelas" class="select">
                            <option value="">Semua kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" @selected(request('kelas') === $kelas)>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Status</label>
                        <select name="status" class="select">
                            <option value="">Semua status</option>
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="input" placeholder="Nama atau NIS">
                    </div>
                    <div style="display:flex;gap:8px;">
                        <button type="submit" class="btn btn-info" style="flex:1;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6.05 6.05a7.5 7.5 0 0 0 10.6 10.6Z"/></svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.perpulangan.rekap') }}" class="btn btn-soft">Reset</a>
                    </div>
                </div>
            </form>
        </section>

        @if($santriList->isEmpty())
            <section class="empty">
                <h2>Belum ada data rekap</h2>
                <p>
                    @if($activeEvent)
                        Tidak ada santri yang cocok dengan filter pada event {{ $activeEvent->nama_event }}.
                    @else
                        Belum ada event perpulangan yang bisa direkap.
                    @endif
                </p>
                <a href="{{ route('admin.perpulangan.index') }}" class="btn btn-primary">Kelola Event</a>
            </section>
        @else
            <section class="table-card">
                <div class="table-head">
                    <div>
                        <h2 class="section-title">Daftar Santri</h2>
                        <p class="muted">
                            Menampilkan {{ $santriList->firstItem() }}-{{ $santriList->lastItem() }} dari {{ $santriList->total() }} data
                        </p>
                    </div>
                    @if($activeEvent)
                        <div class="event-pill">{{ $activeEvent->nama_event }}</div>
                    @endif
                </div>

                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Santri</th>
                                <th>Kelas</th>
                                <th>Approval</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($santriList as $index => $row)
                                @php
                                    $santri = $row->santri;
                                    $approvals = $row->approvals->keyBy('approval_type');
                                    $nama = $santri?->nama ?? 'Santri tidak ditemukan';
                                    $nis = $row->nis;
                                    $kelas = $santri?->kelas ?? '-';
                                    $initials = collect(explode(' ', $nama))
                                        ->filter()
                                        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                                        ->take(2)
                                        ->join('');
                                    $isPa = str_starts_with($kelas, 'PA');
                                @endphp
                                <tr>
                                    <td style="color:#94a3b8;font-weight:800;">{{ $santriList->firstItem() + $index }}</td>
                                    <td>
                                        <div class="person">
                                            <div class="avatar {{ $isPa ? '' : 'avatar-pi' }}">{{ $initials ?: '?' }}</div>
                                            <div>
                                                <p class="name">{{ $nama }}</p>
                                                <p class="nis">NIS {{ $nis }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong>{{ $kelas }}</strong></td>
                                    <td>
                                        <div class="chips">
                                            @foreach($approvalLabels as $type => $label)
                                                @if($approvals->has($type))
                                                    <span class="chip chip-ok">{{ $label }}: {{ $approvals[$type]->approvedBy->name ?? '-' }}</span>
                                                @else
                                                    <span class="chip chip-wait">{{ $label }}: belum</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $statusClass[$row->status] ?? 'status-menunggu' }}">
                                            {{ $row->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size:.76rem;line-height:1.7;">
                                            <div>Keluar: <strong>{{ optional($row->keluar_at)->format('d/m/Y H:i') ?? '-' }}</strong></div>
                                            <div>Kembali: <strong>{{ optional($row->kembali_at)->format('d/m/Y H:i') ?? '-' }}</strong></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($santriList->hasPages())
                    <div class="pagi">
                        {{ $santriList->appends(request()->query())->links() }}
                    </div>
                @endif
            </section>
        @endif
    </div>
</div>
</x-app-layout>
