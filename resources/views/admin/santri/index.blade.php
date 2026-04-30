<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
*{font-family:'Plus Jakarta Sans',sans-serif;}
.page-bg{min-height:100vh;background:#f1f5f9;padding:28px 16px;}
.dark .page-bg{background:#0f172a;}
.page-banner{background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#059669 100%);border-radius:20px;padding:24px 28px;margin-bottom:20px;position:relative;overflow:hidden;}
.page-banner::before{content:'';position:absolute;top:-50px;right:-50px;width:180px;height:180px;border-radius:50%;background:rgba(16,185,129,0.12);pointer-events:none;}
.page-banner h1{color:#fff;font-size:1.3rem;font-weight:700;margin:0 0 4px;position:relative;z-index:1;}
.page-banner p{color:#6ee7b7;font-size:0.82rem;margin:0;position:relative;z-index:1;}
.banner-actions{display:flex;gap:8px;margin-top:16px;flex-wrap:wrap;position:relative;z-index:1;}
.btn-white{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s;cursor:pointer;backdrop-filter:blur(4px);}
.btn-white:hover{background:rgba(255,255,255,0.25);}
.stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:12px;margin-bottom:20px;}
.stat-card{background:#fff;border-radius:14px;padding:14px 16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .stat-card{background:#1e293b;border-color:#334155;}
.stat-label{font-size:0.68rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 5px;}
.stat-value{font-size:1.4rem;font-weight:700;margin:0;}
.filter-card{background:#fff;border-radius:16px;padding:16px 20px;border:1px solid #e2e8f0;margin-bottom:16px;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .filter-card{background:#1e293b;border-color:#334155;}
.filter-row{display:flex;gap:8px;flex-wrap:wrap;align-items:flex-end;}
.form-group{display:flex;flex-direction:column;gap:3px;}
.form-label{font-size:0.72rem;font-weight:600;color:#64748b;}
.dark .form-label{color:#94a3b8;}
.form-ctrl{padding:8px 10px;border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;font-size:0.82rem;outline:none;transition:border-color 0.2s;}
.dark .form-ctrl{background:#0f172a;border-color:#334155;color:#f1f5f9;}
.form-ctrl:focus{border-color:#10b981;}
.btn-filter{padding:8px 16px;border-radius:10px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-weight:600;font-size:0.82rem;border:none;cursor:pointer;transition:all 0.2s;box-shadow:0 2px 8px rgba(16,185,129,0.25);}
.btn-filter:hover{transform:translateY(-1px);}
.btn-reset{padding:8px 12px;border-radius:10px;border:1.5px solid #e2e8f0;color:#64748b;font-size:0.82rem;font-weight:600;text-decoration:none;transition:all 0.15s;background:transparent;}
.dark .btn-reset{border-color:#334155;color:#94a3b8;}
.table-card{background:#fff;border-radius:16px;border:1px solid #e2e8f0;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .table-card{background:#1e293b;border-color:#334155;}
table{width:100%;border-collapse:collapse;}
thead th{background:#f8fafc;padding:10px 14px;text-align:left;font-size:0.7rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #e2e8f0;}
.dark thead th{background:#0f172a;color:#94a3b8;border-color:#334155;}
tbody td{padding:11px 14px;font-size:0.83rem;color:#374151;border-bottom:1px solid #f1f5f9;}
.dark tbody td{color:#cbd5e1;border-bottom-color:#334155;}
tbody tr:hover td{background:#f8fafc;}
.dark tbody tr:hover td{background:rgba(255,255,255,0.02);}
tbody tr:last-child td{border-bottom:none;}
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:999px;font-size:0.7rem;font-weight:600;}
.badge-green{background:#dcfce7;color:#166534;}.badge-blue{background:#dbeafe;color:#1d4ed8;}.badge-amber{background:#fef3c7;color:#92400e;}.badge-red{background:#fee2e2;color:#991b1b;}.badge-slate{background:#f1f5f9;color:#475569;}
.dark .badge-green{background:rgba(22,163,74,0.15);color:#4ade80;}.dark .badge-blue{background:rgba(37,99,235,0.15);color:#60a5fa;}.dark .badge-amber{background:rgba(245,158,11,0.15);color:#fcd34d;}.dark .badge-red{background:rgba(239,68,68,0.12);color:#fca5a5;}.dark .badge-slate{background:rgba(71,85,105,0.2);color:#94a3b8;}
.badge-pa{background:#dbeafe;color:#1d4ed8;}.badge-pi{background:#fce7f3;color:#9d174d;}
.dark .badge-pa{background:rgba(37,99,235,0.15);color:#60a5fa;}.dark .badge-pi{background:rgba(236,72,153,0.15);color:#f9a8d4;}
.action-btn{display:inline-flex;align-items:center;gap:4px;padding:5px 10px;border-radius:7px;font-size:0.73rem;font-weight:600;text-decoration:none;transition:all 0.15s;border:none;cursor:pointer;}
.action-edit{background:#eff6ff;color:#2563eb;}.action-edit:hover{background:#dbeafe;}
.action-del{background:#fef2f2;color:#dc2626;}.action-del:hover{background:#fee2e2;}
.action-view{background:#f0fdf4;color:#059669;}.action-view:hover{background:#dcfce7;}
.dark .action-edit{background:rgba(37,99,235,0.12);color:#60a5fa;}.dark .action-del{background:rgba(239,68,68,0.1);color:#f87171;}.dark .action-view{background:rgba(16,185,129,0.1);color:#34d399;}
.flash-success{padding:12px 16px;background:#dcfce7;border:1px solid #86efac;color:#166534;border-radius:12px;font-size:0.85rem;margin-bottom:16px;}
.flash-error{padding:12px 16px;background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;border-radius:12px;font-size:0.85rem;margin-bottom:16px;}
.dark .flash-success{background:rgba(22,163,74,0.15);border-color:rgba(74,222,128,0.3);color:#4ade80;}
.dark .flash-error{background:rgba(239,68,68,0.12);border-color:rgba(252,165,165,0.3);color:#fca5a5;}
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;}
.modal-box{background:#fff;border-radius:20px;padding:24px;width:100%;max-width:440px;box-shadow:0 20px 60px rgba(0,0,0,0.2);animation:modalIn 0.2s cubic-bezier(0.34,1.2,0.64,1);}
.dark .modal-box{background:#1e293b;}
@keyframes modalIn{from{opacity:0;transform:scale(0.93)}to{opacity:1;transform:scale(1)}}
.upload-area{border:2px dashed #10b981;border-radius:12px;padding:24px;text-align:center;background:#f0fdf4;cursor:pointer;transition:all 0.2s;}
.dark .upload-area{background:rgba(16,185,129,0.05);}
.upload-area:hover{background:#dcfce7;}
.pagination-wrap{padding:14px 20px;border-top:1px solid #f1f5f9;}
.dark .pagination-wrap{border-color:#334155;}
</style>

<div class="page-bg">
<div style="max-width:1200px;margin:0 auto;">
    <div class="page-banner">
        <h1>🎓 Manajemen Santri</h1>
        <p>Kelola data seluruh santri pesantren</p>
        <div class="banner-actions">
            <a href="{{ route('admin.santri.create') }}" class="btn-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah Santri
            </a>
            <button onclick="document.getElementById('import-modal').style.display='flex'" class="btn-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                Import CSV
            </button>
            <a href="{{ route('admin.santri.kelola-kelas') }}" class="btn-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h7"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l3 3 3-3m0 0v-6"/></svg>
                Kelola Kelas
            </a>
        </div>
    </div>

    @if(session('success'))<div class="flash-success">✅ {{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash-error">❌ {{ session('error') }}</div>@endif

    <div class="stats-row">
        <div class="stat-card"><p class="stat-label">Total Santri</p><p class="stat-value" style="color:#2563eb;">{{ $totalAll }}</p></div>
        <div class="stat-card"><p class="stat-label">Aktif</p><p class="stat-value" style="color:#059669;">{{ $totalAktif }}</p></div>
        <div class="stat-card"><p class="stat-label">Tidak Aktif</p><p class="stat-value" style="color:#dc2626;">{{ $totalAll - $totalAktif }}</p></div>
    </div>

    <div class="filter-card">
        <form method="GET" class="filter-row">
            <div class="form-group" style="flex:1;min-width:160px;">
                <label class="form-label">Cari Nama / NIS</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau NIS..." class="form-ctrl">
            </div>
            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-ctrl">
                    <option value="">Semua Kelas</option>
                    @foreach($daftarKelas as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas')===$kelas?'selected':'' }}>{{ $kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-ctrl">
                    <option value="">Semua</option>
                    <option value="PA" {{ request('gender')==='PA'?'selected':'' }}>PA (Putra)</option>
                    <option value="PI" {{ request('gender')==='PI'?'selected':'' }}>PI (Putri)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Jenjang</label>
                <select name="jenjang" class="form-ctrl">
                    <option value="">Semua</option>
                    <option value="Reguler" {{ request('jenjang')==='Reguler'?'selected':'' }}>Reguler</option>
                    <option value="Tahfidz" {{ request('jenjang')==='Tahfidz'?'selected':'' }}>Tahfidz</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-ctrl">
                    <option value="">Semua</option>
                    <option value="aktif" {{ request('status')==='aktif'?'selected':'' }}>Aktif</option>
                    <option value="lulus" {{ request('status')==='lulus'?'selected':'' }}>Lulus</option>
                    <option value="mutasi" {{ request('status')==='mutasi'?'selected':'' }}>Mutasi</option>
                    <option value="dikeluarkan" {{ request('status')==='dikeluarkan'?'selected':'' }}>Dikeluarkan</option>
                    <option value="wafat" {{ request('status')==='wafat'?'selected':'' }}>Wafat</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">Cari</button>
            @if(request()->hasAny(['search','kelas','gender','jenjang','status']))
                <a href="{{ route('admin.santri.index') }}" class="btn-reset">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-card">
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>NIS</th><th>Nama Santri</th><th>Kelas</th><th>Gender</th><th>Jenjang</th><th>Masuk</th><th>Status</th><th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santri as $s)
                    <tr>
                        <td style="font-family:monospace;font-weight:600;color:#475569;font-size:0.8rem;">{{ $s->nis }}</td>
                        <td><div style="font-weight:600;color:#1e293b;" class="dark:text-white">{{ $s->nama }}</div></td>
                        <td style="font-weight:500;">{{ $s->kelas }}</td>
                        <td><span class="badge {{ $s->gender==='PA'?'badge-pa':'badge-pi' }}">{{ $s->gender }}</span></td>
                        <td style="font-size:0.78rem;color:#64748b;">{{ $s->jenjang }}</td>
                        <td style="font-size:0.78rem;color:#94a3b8;">{{ $s->tanggal_masuk?->format('Y') ?? '-' }}</td>
                        <td><span class="badge badge-{{ $s->status_color }}">{{ $s->status_label }}</span></td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:flex-end;">
                                <a href="{{ route('admin.santri.show', $s->nis) }}" class="action-btn action-view">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Detail
                                </a>
                                <a href="{{ route('admin.santri.edit', $s->nis) }}" class="action-btn action-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>Edit
                                </a>
                                <form action="{{ route('admin.santri.destroy', $s->nis) }}" method="POST" onsubmit="return confirm('Hapus santri {{ addslashes($s->nama) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-del">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916"/></svg>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="padding:48px 24px;text-align:center;color:#94a3b8;"><div style="font-weight:600;margin:0 0 4px;">Tidak ada data santri</div><div style="font-size:0.8rem;">Coba ubah filter atau tambah santri baru</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($santri->hasPages())<div class="pagination-wrap">{{ $santri->links() }}</div>@endif
    </div>
</div>
</div>

<div id="import-modal" style="display:none;" class="modal-overlay" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal-box">
        <h3 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0 0 4px;" class="dark:text-white">Import Data Santri</h3>
        <p style="font-size:0.8rem;color:#64748b;margin:0 0 20px;">Upload file CSV dengan format: NIS, Nama, Kelas</p>
        <form action="{{ route('admin.santri.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="upload-area" for="csv-file">
                <input type="file" id="csv-file" name="file" accept=".csv,.txt" onchange="document.getElementById('file-name').textContent=this.files[0]?.name||'Pilih file CSV'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:36px;height:36px;margin:0 auto 10px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                <p id="file-name" style="font-size:0.85rem;font-weight:600;color:#059669;margin:0;">Klik untuk pilih file CSV</p>
                <p style="font-size:0.75rem;color:#94a3b8;margin:4px 0 0;">Format: NIS, Nama, Kelas</p>
            </label>
            <div style="display:flex;gap:10px;margin-top:16px;">
                <button type="button" onclick="document.getElementById('import-modal').style.display='none'" style="flex:1;padding:10px;border-radius:10px;border:1.5px solid #e2e8f0;background:transparent;color:#64748b;font-weight:600;font-size:0.875rem;cursor:pointer;">Batal</button>
                <button type="submit" style="flex:2;padding:10px;border-radius:10px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-weight:700;font-size:0.875rem;border:none;cursor:pointer;">Import Sekarang</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>