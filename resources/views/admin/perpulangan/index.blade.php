<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-bg { min-height:100vh; background:#f1f5f9; padding:28px 16px; }
.dark .page-bg { background:#0f172a; }
.page-wrap { max-width:1100px; margin:0 auto; }

.page-banner {
    background:linear-gradient(135deg,#1e1b4b 0%,#312e81 52%,#4c1d95 100%);
    border-radius:20px; padding:24px 28px; margin-bottom:18px;
    position:relative; overflow:hidden;
}
.page-banner::before {
    content:''; position:absolute; top:-54px; right:-42px;
    width:176px; height:176px; border-radius:50%;
    background:rgba(167,139,250,0.14); pointer-events:none;
}
.page-banner::after {
    content:''; position:absolute; bottom:-56px; left:28%;
    width:142px; height:142px; border-radius:50%;
    background:rgba(30,27,75,0.36); pointer-events:none;
}
.page-banner h1 { color:#fff; font-size:1.28rem; font-weight:700; margin:0 0 5px; position:relative; z-index:1; }
.page-banner p { color:#c4b5fd; font-size:0.82rem; margin:0; position:relative; z-index:1; }
.banner-actions { display:flex; gap:8px; margin-top:14px; flex-wrap:wrap; position:relative; z-index:1; }

.btn-primary, .btn-white, .btn-soft, .btn-action, .btn-danger, .btn-done {
    display:inline-flex; align-items:center; justify-content:center; gap:7px;
    border-radius:10px; font-size:0.8rem; font-weight:700;
    text-decoration:none; border:none; cursor:pointer; transition:all 0.16s;
}
.btn-primary { padding:9px 17px; background:#fff; color:#4c1d95; box-shadow:0 2px 10px rgba(0,0,0,0.13); }
.btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,0,0,0.16); }
.btn-white { padding:8px 15px; color:#fff; background:rgba(255,255,255,0.14); border:1px solid rgba(255,255,255,0.24); }
.btn-white:hover { background:rgba(255,255,255,0.23); }
.btn-soft { padding:8px 12px; color:#475569; background:#f8fafc; border:1px solid #e2e8f0; }
.btn-soft:hover { color:#4c1d95; border-color:#ddd6fe; background:#f5f3ff; }
.btn-action { padding:8px 12px; color:#0369a1; background:#eff6ff; border:1px solid #bfdbfe; }
.btn-action:hover { background:#dbeafe; }
.btn-danger { padding:8px 12px; color:#be123c; background:#fff1f2; border:1px solid #fecdd3; }
.btn-danger:hover { background:#ffe4e6; }
.btn-done { padding:8px 12px; color:#6b7280; background:#f9fafb; border:1px solid #d1d5db; }
.btn-done:hover { background:#f3f4f6; }

.alert {
    display:flex; align-items:flex-start; gap:10px; padding:12px 15px;
    border-radius:12px; font-size:0.83rem; font-weight:600; margin-bottom:14px;
}
.alert-success { background:#dcfce7; color:#166534; border:1px solid #86efac; }
.alert-error   { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }

.stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:12px; margin-bottom:16px; }
.stat-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:14px;
    padding:15px 16px; box-shadow:0 1px 4px rgba(15,23,42,0.05);
}
.dark .stat-card { background:#1e293b; border-color:#334155; }
.stat-label { margin:0 0 5px; font-size:0.67rem; color:#94a3b8; font-weight:800; text-transform:uppercase; letter-spacing:0.05em; }
.stat-value { margin:0; font-size:1.42rem; color:#0f172a; font-weight:800; }
.dark .stat-value { color:#f1f5f9; }

.table-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:16px;
    overflow:hidden; box-shadow:0 1px 4px rgba(15,23,42,0.05);
}
.dark .table-card { background:#1e293b; border-color:#334155; }
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
tbody tr:hover td { background:#faf5ff; }
.dark tbody tr:hover td { background:rgba(255,255,255,0.025); }
tbody tr:last-child td { border-bottom:none; }

.name-cell { display:flex; align-items:center; gap:10px; }
.row-icon {
    width:36px; height:36px; border-radius:10px; background:#ede9fe;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.row-title { margin:0; font-weight:800; color:#0f172a; font-size:0.84rem; }
.dark .row-title { color:#f8fafc; }
.row-sub { margin:2px 0 0; color:#94a3b8; font-size:0.72rem; }

.badge {
    display:inline-flex; align-items:center; gap:5px; padding:4px 9px;
    border-radius:999px; font-size:0.68rem; font-weight:800;
}
.badge-aktif   { background:#dcfce7; color:#166534; }
.badge-selesai { background:#f1f5f9; color:#64748b; }
.dark .badge-aktif   { background:rgba(22,163,74,0.16); color:#4ade80; }
.dark .badge-selesai { background:rgba(100,116,139,0.16); color:#cbd5e1; }

.row-actions { display:flex; gap:7px; justify-content:flex-end; align-items:center; flex-wrap:wrap; }

.empty-state {
    background:#fff; border:1.5px dashed #ddd6fe; border-radius:16px;
    padding:54px 20px; text-align:center;
}
.dark .empty-state { background:#1e293b; border-color:#4c1d95; }
.empty-icon {
    width:58px; height:58px; border-radius:16px; background:#ede9fe;
    display:flex; align-items:center; justify-content:center; margin:0 auto 14px;
}

.modal-overlay {
    display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45);
    z-index:999; align-items:center; justify-content:center; padding:20px;
}
.modal-overlay.open { display:flex; }
.modal-box {
    background:#fff; border-radius:18px; padding:28px 24px; max-width:400px; width:100%;
    box-shadow:0 16px 48px rgba(0,0,0,0.18);
}
.dark .modal-box { background:#1e293b; }
.modal-title { margin:0 0 8px; font-size:1rem; font-weight:800; color:#0f172a; }
.dark .modal-title { color:#f8fafc; }
.modal-desc { margin:0 0 20px; font-size:0.84rem; color:#64748b; }
.modal-actions { display:flex; gap:10px; justify-content:flex-end; }

@media (max-width: 760px) {
    .page-banner { padding:22px 20px; }
    th:nth-child(3), td:nth-child(3),
    th:nth-child(5), td:nth-child(5) { display:none; }
}
</style>

@php
    $total   = $perpulanganList->total();
    $aktif   = \App\Models\Perpulangan::where('status','aktif')->count();
    $selesai = \App\Models\Perpulangan::where('status','selesai')->count();
@endphp

<div class="page-bg">
    <div class="page-wrap">

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success"><span>✓</span><div>{{ session('success') }}</div></div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><span>!</span><div>{{ session('error') }}</div></div>
        @endif

        {{-- Banner --}}
        <div class="page-banner">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;display:inline;margin-right:6px;vertical-align:-3px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                </svg>
                Manajemen Perpulangan
            </h1>
            <p>Kelola event perpulangan santri — liburan semester, hari raya, dan lainnya.</p>
            <div class="banner-actions">
                <a href="{{ route('admin.perpulangan.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tambah Perpulangan
                </a>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="stats-row">
            <div class="stat-card">
                <p class="stat-label">Total Event</p>
                <p class="stat-value">{{ $total }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Sedang Aktif</p>
                <p class="stat-value" style="color:#16a34a;">{{ $aktif }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Selesai</p>
                <p class="stat-value" style="color:#94a3b8;">{{ $selesai }}</p>
            </div>
        </div>

        {{-- Tabel --}}
        @if($perpulanganList->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7c3aed" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                    </svg>
                </div>
                <p style="font-weight:800;color:#0f172a;margin:0 0 6px;">Belum ada event perpulangan</p>
                <p style="color:#94a3b8;font-size:0.82rem;margin:0 0 16px;">Tambahkan event perpulangan pertama untuk mulai mencatat.</p>
                <a href="{{ route('admin.perpulangan.create') }}" class="btn-primary" style="color:#4c1d95;">+ Tambah Sekarang</a>
            </div>
        @else
            <div class="table-card">
                <div class="table-head">
                    <div>
                        <h2>Daftar Event Perpulangan</h2>
                        <p>{{ $perpulanganList->total() }} event ditemukan</p>
                    </div>
                    <a href="{{ route('admin.perpulangan.create') }}" class="btn-soft">+ Tambah</a>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Event</th>
                                <th>Tanggal Mulai</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th style="text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perpulanganList as $p)
                            <tr>
                                <td>
                                    <div class="name-cell">
                                        <div class="row-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7c3aed" style="width:18px;height:18px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="row-title">{{ $p->nama_event }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $p->tanggal_mulai->translatedFormat('d M Y') }}</td>
                                <td>{{ $p->batas_kembali->translatedFormat('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $p->status }}">
                                        {{ $p->status_label }}
                                    </span>
                                </td>
                                <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#94a3b8;">
                                    {{ $p->keterangan ?? '-' }}
                                </td>
                                <td>
                                    <div class="row-actions">
                                        @if($p->status === 'aktif')
                                            <button
                                                onclick="confirmSelesai({{ $p->id }}, '{{ addslashes($p->nama_event) }}')"
                                                class="btn-done"
                                                title="Tandai selesai">
                                                Tandai Selesai
                                            </button>
                                        @endif
                                        <button
                                            onclick="confirmHapus({{ $p->id }}, '{{ addslashes($p->nama_event) }}')"
                                            class="btn-danger"
                                            title="Hapus">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($perpulanganList->hasPages())
                    <div style="padding:14px 18px;border-top:1px solid #f1f5f9;">
                        {{ $perpulanganList->links() }}
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>

{{-- Modal konfirmasi Selesai --}}
<div id="modal-selesai" class="modal-overlay" onclick="if(event.target===this) closeSelesai()">
    <div class="modal-box">
        <p class="modal-title">Tandai Selesai?</p>
        <p class="modal-desc" id="modal-selesai-desc">Event ini akan ditandai selesai dan tidak bisa diubah kembali ke aktif.</p>
        <div class="modal-actions">
            <button onclick="closeSelesai()" class="btn-soft">Batal</button>
            <form id="form-selesai" method="POST" style="display:inline;">
                @csrf @method('PATCH')
                <button type="submit" class="btn-done">Ya, Selesai</button>
            </form>
        </div>
    </div>
</div>

{{-- Modal konfirmasi Hapus --}}
<div id="modal-hapus" class="modal-overlay" onclick="if(event.target===this) closeHapus()">
    <div class="modal-box">
        <p class="modal-title">Hapus Event?</p>
        <p class="modal-desc" id="modal-hapus-desc">Data event perpulangan ini akan dihapus permanen.</p>
        <div class="modal-actions">
            <button onclick="closeHapus()" class="btn-soft">Batal</button>
            <form id="form-hapus" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmSelesai(id, nama) {
    document.getElementById('modal-selesai-desc').textContent =
        '"' + nama + '" akan ditandai selesai.';
    document.getElementById('form-selesai').action = '/admin/perpulangan/' + id + '/selesai';
    document.getElementById('modal-selesai').classList.add('open');
}
function closeSelesai() {
    document.getElementById('modal-selesai').classList.remove('open');
}
function confirmHapus(id, nama) {
    document.getElementById('modal-hapus-desc').textContent =
        '"' + nama + '" akan dihapus permanen dan tidak bisa dikembalikan.';
    document.getElementById('form-hapus').action = '/admin/perpulangan/' + id;
    document.getElementById('modal-hapus').classList.add('open');
}
function closeHapus() {
    document.getElementById('modal-hapus').classList.remove('open');
}
</script>
</x-app-layout>
