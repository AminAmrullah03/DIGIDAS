<x-app-layout>
@php
$total = $izinList->count();
$belum = $izinList->where('status','Belum Kembali')->count();
$sudah = $izinList->where('status','Sudah Kembali')->count();
$terlambat = $izinList->where('status','Terlambat')->count();
$kabur = $izinList->where('status','Kabur')->count();
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family:'Plus Jakarta Sans',sans-serif; }
.page { min-height:100vh; background:#f1f5f9; padding:28px 16px; }
.dark .page { background:#0f172a; }
.banner { background:linear-gradient(135deg,#064e3b,#065f46,#059669); border-radius:20px; padding:24px 28px; margin-bottom:20px; }
.banner h1 { color:#fff; font-size:1.3rem; font-weight:800; margin:0 0 4px; }
.banner p { color:#6ee7b7; font-size:.82rem; margin:0; }
.actions { display:flex; gap:8px; margin-top:14px; flex-wrap:wrap; }
.btn-white { padding:8px 16px; border-radius:10px; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.25); color:#fff; text-decoration:none; font-size:.8rem; font-weight:700; }
.stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(130px,1fr)); gap:12px; margin-bottom:16px; }
.stat { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:16px; box-shadow:0 1px 4px rgba(0,0,0,.04); }
.dark .stat, .dark .filter, .dark .table-wrap { background:#1e293b; border-color:#334155; }
.stat-label { color:#94a3b8; font-size:.7rem; font-weight:800; text-transform:uppercase; margin:0 0 4px; }
.stat-value { font-size:1.4rem; font-weight:800; margin:0; }
.filter { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:16px 20px; margin-bottom:16px; }
.filter-row { display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
.form-group { display:flex; flex-direction:column; gap:4px; }
.label { font-size:.72rem; font-weight:700; color:#64748b; }
.ctrl { padding:9px 12px; border-radius:10px; border:1.5px solid #e2e8f0; background:#f8fafc; color:#1e293b; outline:none; }
.btn-filter { padding:9px 18px; border-radius:10px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; border:none; font-weight:700; cursor:pointer; }
.table-wrap { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.04); }
table { width:100%; border-collapse:collapse; font-size:.82rem; }
th { padding:11px 14px; text-align:left; color:#64748b; background:#f8fafc; border-bottom:1px solid #e2e8f0; font-size:.68rem; text-transform:uppercase; white-space:nowrap; }
td { padding:13px 14px; border-bottom:1px solid #f1f5f9; color:#374151; vertical-align:middle; }
.avatar { width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,#10b981,#059669); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; }
.badge { display:inline-flex; padding:5px 12px; border-radius:20px; font-size:.72rem; font-weight:800; white-space:nowrap; }
.badge-belum { background:#fef3c7; color:#92400e; border:1px solid #fcd34d; }
.badge-sudah { background:#dcfce7; color:#166534; border:1px solid #86efac; }
.badge-terlambat { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
.badge-kabur { background:#e2e8f0; color:#334155; border:1px solid #cbd5e1; }
.btn-kembali { padding:6px 14px; border-radius:8px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; border:none; cursor:pointer; font-size:.75rem; font-weight:800; white-space:nowrap; }
.btn-kembali:disabled { opacity:.55; cursor:not-allowed; }
.empty { text-align:center; padding:54px 24px; color:#94a3b8; }
.toast-wrap { position:fixed; top:20px; right:20px; z-index:999; display:flex; flex-direction:column; gap:8px; }
.toast { padding:12px 16px; border-radius:12px; color:#fff; font-size:.85rem; font-weight:700; box-shadow:0 8px 24px rgba(0,0,0,.15); }
.toast-success { background:linear-gradient(135deg,#059669,#10b981); }
.toast-error { background:linear-gradient(135deg,#dc2626,#ef4444); }
.toast-warning { background:linear-gradient(135deg,#d97706,#f59e0b); }
</style>

<div class="page">
    <div style="max-width:1180px;margin:0 auto;">
        <div class="banner">
            <h1>Rekap Izin Pulang Santri</h1>
            <p>Pantau santri yang sedang izin pulang - {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            <div class="actions">
                <a href="{{ route('izin-pulang.index') }}" class="btn-white">Input Izin Pulang</a>
                <a href="{{ route('dashboard') }}" class="btn-white">Dashboard</a>
            </div>
        </div>

        <div class="stats">
            <div class="stat"><p class="stat-label">Total</p><p class="stat-value" style="color:#059669;">{{ $total }}</p></div>
            <div class="stat"><p class="stat-label">Belum Kembali</p><p class="stat-value" style="color:#059669;">{{ $belum }}</p></div>
            <div class="stat"><p class="stat-label">Sudah Kembali</p><p class="stat-value" style="color:#059669;">{{ $sudah }}</p></div>
            <div class="stat"><p class="stat-label">Terlambat</p><p class="stat-value" style="color:#dc2626;">{{ $terlambat }}</p></div>
            <div class="stat"><p class="stat-label">Kabur</p><p class="stat-value" style="color:#475569;">{{ $kabur }}</p></div>
        </div>

        <div class="filter">
            <form method="GET" action="{{ route('izin-pulang.rekap') }}">
                <div class="filter-row">
                    <div class="form-group">
                        <label class="label">Tanggal Pulang</label>
                        <input type="date" name="tanggal" class="ctrl" value="{{ $tanggal }}">
                    </div>
                    <div class="form-group">
                        <label class="label">Kelas</label>
                        <select name="kelas" class="ctrl">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $kelasFilter == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label">Status</label>
                        <select name="status" class="ctrl">
                            <option value="">Semua Status</option>
                            <option value="Belum Kembali" {{ $statusFilter == 'Belum Kembali' ? 'selected' : '' }}>Belum Kembali</option>
                            <option value="Sudah Kembali" {{ $statusFilter == 'Sudah Kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                            <option value="Terlambat" {{ $statusFilter == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="Kabur" {{ $statusFilter == 'Kabur' ? 'selected' : '' }}>Kabur</option>
                        </select>
                    </div>
                    <button class="btn-filter" type="submit">Filter</button>
                </div>
            </form>
        </div>

        <div class="table-wrap">
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Santri</th>
                            <th>Kelas</th>
                            <th>Keperluan</th>
                            <th>Durasi / Tenggat</th>
                            <th>Waktu Pulang</th>
                            <th>Waktu Kembali</th>
                            <th>Ketepatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($izinList as $index => $izin)
                        <tr>
                            <td style="color:#94a3b8;">{{ $index + 1 }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="avatar">{{ strtoupper(substr($izin->santri->nama ?? '?', 0, 1)) }}</div>
                                    <div>
                                        <p style="font-weight:700;color:#1e293b;margin:0;">{{ $izin->santri->nama ?? '-' }}</p>
                                        <p style="font-size:.72rem;color:#94a3b8;margin:0;font-family:monospace;">{{ $izin->nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $izin->santri->kelas ?? '-' }}</td>
                            <td style="max-width:220px;">{{ $izin->keperluan }}</td>
                            <td>
                                <strong>{{ $izin->durasi_label }}</strong>
                                <p style="font-size:.7rem;color:#94a3b8;margin:2px 0 0;">Tenggat: {{ $izin->batas_waktu_kembali?->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</p>
                            </td>
                            <td>{{ $izin->waktu_pulang?->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                            <td>{{ $izin->waktu_kembali ? $izin->waktu_kembali->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}</td>
                            <td class="ketepatan-cell">{{ $izin->ketepatan_label }}</td>
                            <td class="status-cell">
                                @php
                                    $badgeClass = match($izin->status) {
                                        'Sudah Kembali' => 'badge-sudah',
                                        'Terlambat' => 'badge-terlambat',
                                        'Kabur' => 'badge-kabur',
                                        default => 'badge-belum',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $izin->status }}</span>
                            </td>
                            <td>
                                @if($izin->status === 'Belum Kembali')
                                    <button class="btn-kembali" onclick="catatKembali({{ $izin->id }}, this)">Catat Kembali</button>
                                @else
                                    <span style="color:#94a3b8;">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10"><div class="empty">Tidak ada data izin pulang</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="toast-wrap" id="toast-container"></div>

<script>
const CSRF = '{{ csrf_token() }}';

async function catatKembali(id, btn) {
    if(!confirm('Catat santri ini sudah kembali dari izin pulang?')) return;
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';
    try {
        const res = await fetch(`/izin-pulang/${id}/kembali`, {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
            body: JSON.stringify({})
        });
        const data = await res.json();
        if(data.success) {
            const status = data.data?.status || 'Sudah Kembali';
            showToast(status === 'Terlambat' ? 'warning' : 'success', data.message || 'Berhasil dicatat kembali');
            const row = btn.closest('tr');
            const badgeClass = status === 'Terlambat' ? 'badge-terlambat' : 'badge-sudah';
            row.querySelector('.status-cell').innerHTML = `<span class="badge ${badgeClass}">${status}</span>`;
            row.querySelector('.ketepatan-cell').textContent = data.data?.ketepatan_label || 'Tepat waktu';
            row.querySelector('td:nth-child(7)').textContent = data.data?.waktu_kembali || '-';
            btn.closest('td').innerHTML = '<span style="color:#94a3b8;">-</span>';
        } else {
            showToast('error', data.message || 'Gagal mencatat kembali');
            btn.disabled = false;
            btn.textContent = 'Catat Kembali';
        }
    } catch(err) {
        showToast('error', 'Terjadi kesalahan jaringan');
        btn.disabled = false;
        btn.textContent = 'Catat Kembali';
    }
}

function showToast(type, message) {
    const toast = document.createElement('div');
    const cls = type === 'error' ? 'toast-error' : type === 'warning' ? 'toast-warning' : 'toast-success';
    toast.className = `toast ${cls}`;
    toast.textContent = message;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity .3s'; setTimeout(() => toast.remove(), 300); }, 3500);
}
</script>
</x-app-layout>
