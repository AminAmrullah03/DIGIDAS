<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
*{font-family:'Plus Jakarta Sans',sans-serif;}
.page-bg{min-height:100vh;background:#f1f5f9;padding:28px 16px;}
.dark .page-bg{background:#0f172a;}
.card{background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.04);margin-bottom:16px;}
.dark .card{background:#1e293b;border-color:#334155;}
.card-header{padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;}
.dark .card-header{border-color:#334155;}
.card-icon{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.card-title{font-size:0.88rem;font-weight:700;color:#1e293b;margin:0;}
.dark .card-title{color:#f1f5f9;}
.card-body{padding:18px 20px;}
.profile-banner{display:flex;align-items:center;gap:16px;padding:20px;background:linear-gradient(135deg,#064e3b,#059669);border-radius:16px;margin-bottom:16px;flex-wrap:wrap;}
.avatar-lg{width:60px;height:60px;border-radius:14px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;font-weight:700;color:#fff;flex-shrink:0;border:2px solid rgba(255,255,255,0.3);}
.profile-name{color:#fff;font-size:1.15rem;font-weight:700;margin:0 0 3px;}
.profile-nis{color:#6ee7b7;font-size:0.8rem;font-family:monospace;margin:0 0 8px;}
.pbadge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:999px;font-size:0.7rem;font-weight:600;background:rgba(255,255,255,0.18);color:#fff;border:1px solid rgba(255,255,255,0.25);margin-right:4px;}
.status-pill{display:inline-flex;align-items:center;padding:5px 14px;border-radius:999px;font-size:0.8rem;font-weight:700;}
.s-aktif{background:#dcfce7;color:#166534;}.s-lulus{background:#dbeafe;color:#1d4ed8;}.s-mutasi{background:#fef3c7;color:#92400e;}.s-dikeluarkan{background:#fee2e2;color:#991b1b;}.s-wafat{background:#f1f5f9;color:#475569;}
.dark .s-aktif{background:rgba(22,163,74,0.15);color:#4ade80;}.dark .s-lulus{background:rgba(37,99,235,0.15);color:#60a5fa;}.dark .s-mutasi{background:rgba(245,158,11,0.15);color:#fcd34d;}.dark .s-dikeluarkan{background:rgba(239,68,68,0.12);color:#fca5a5;}.dark .s-wafat{background:rgba(71,85,105,0.2);color:#94a3b8;}
.timeline{display:flex;flex-direction:column;gap:0;}
.tl-item{display:flex;gap:14px;position:relative;}
.tl-item:not(:last-child)::before{content:'';position:absolute;left:14px;top:30px;bottom:0;width:2px;background:#f1f5f9;}
.dark .tl-item:not(:last-child)::before{background:#334155;}
.tl-dot{width:28px;height:28px;border-radius:50%;background:#ecfdf5;border:2px solid #10b981;display:flex;align-items:center;justify-content:center;flex-shrink:0;z-index:1;}
.dark .tl-dot{background:rgba(16,185,129,0.1);}
.tl-body{padding-bottom:18px;flex:1;}
.tl-title{font-size:0.83rem;font-weight:700;color:#1e293b;margin:0 0 2px;}
.dark .tl-title{color:#f1f5f9;}
.tl-sub{font-size:0.73rem;color:#94a3b8;margin:0 0 3px;}
.tl-note{font-size:0.73rem;color:#64748b;font-style:italic;margin:0;}
.btn-back{display:inline-flex;align-items:center;gap:6px;font-size:0.8rem;color:#64748b;text-decoration:none;margin-bottom:16px;transition:color 0.15s;}
.btn-back:hover{color:#059669;}
.btn-edit{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;background:#ecfdf5;color:#059669;font-size:0.8rem;font-weight:600;text-decoration:none;border:1px solid #86efac;transition:all 0.15s;}
.btn-edit:hover{background:#dcfce7;}
.dark .btn-edit{background:rgba(16,185,129,0.1);border-color:rgba(16,185,129,0.3);color:#34d399;}
</style>
<div class="page-bg">
    <div style="max-width:720px;margin:0 auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <a href="{{ route('admin.santri.index') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.santri.edit', $santri->nis) }}" class="btn-edit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                Edit Data
            </a>
        </div>

        <div class="profile-banner">
            <div class="avatar-lg">{{ strtoupper(substr($santri->nama,0,1)) }}</div>
            <div style="flex:1;">
                <p class="profile-name">{{ $santri->nama }}</p>
                <p class="profile-nis">NIS: {{ $santri->nis }}</p>
                <div>
                    <span class="pbadge">{{ $santri->kelas }}</span>
                    <span class="pbadge">{{ $santri->gender }} • {{ $santri->jenjang }}</span>
                    @if($santri->tanggal_masuk)<span class="pbadge">Masuk {{ $santri->tanggal_masuk->format('Y') }}</span>@endif
                </div>
            </div>
            <span class="status-pill s-{{ $santri->status }}">{{ $santri->status_label }}</span>
        </div>

        @if($santri->keterangan)
        <div class="card">
            <div class="card-body">
                <p style="font-size:0.7rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 6px;">Keterangan</p>
                <p style="font-size:0.875rem;color:#475569;margin:0;">{{ $santri->keterangan }}</p>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="card-icon" style="background:#ecfdf5;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#059669" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25"/></svg>
                </div>
                <h3 class="card-title">Riwayat Perubahan Kelas</h3>
            </div>
            <div class="card-body">
                @if($santri->riwayatKelas->isNotEmpty())
                <div class="timeline">
                    @foreach($santri->riwayatKelas as $r)
                    <div class="tl-item">
                        <div class="tl-dot">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#10b981" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18"/></svg>
                        </div>
                        <div class="tl-body">
                            <p class="tl-title">
                                @if($r->kelas_lama) {{ $r->kelas_lama }} → {{ $r->kelas_baru }}
                                @else {{ $r->kelas_baru }} <span style="font-size:0.73rem;color:#94a3b8;font-weight:400;">(awal)</span>
                                @endif
                            </p>
                            <p class="tl-sub">{{ $r->created_at->format('d M Y, H:i') }} • oleh {{ $r->diubah_oleh ?? '-' }}</p>
                            @if($r->catatan)<p class="tl-note">{{ $r->catatan }}</p>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="text-align:center;padding:24px;color:#94a3b8;font-size:0.82rem;">Belum ada riwayat perubahan kelas</p>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>