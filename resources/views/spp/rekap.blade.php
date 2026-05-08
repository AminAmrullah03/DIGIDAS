<x-app-layout>
@php
$bulanShort = [1=>'Muh',2=>'Saf',3=>'R.Aw',4=>'R.Ak',5=>'J.Aw',6=>'J.Ak',7=>'Raj',8=>'Sya',9=>'Ram',10=>'Syw',11=>'Dzq',12=>'Dzh'];
$bulanFull  = [1=>'Muharram',2=>'Safar',3=>'Rabiul Awal',4=>'Rabiul Akhir',5=>'Jumadil Awal',6=>'Jumadil Akhir',7=>'Rajab',8=>'Syaban',9=>'Ramadhan',10=>'Syawal',11=>'Dzulqaidah',12=>'Dzulhijjah'];
$totalSantri = count($rekapData);
$totalLunas  = collect($rekapData)->filter(fn($d) => $d['tagihan']->every(fn($t) => $t->status === 'lunas'))->count();
$totalBelum  = $totalSantri - $totalLunas;
@endphp
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
.btn-white{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s;backdrop-filter:blur(4px);}
.btn-white:hover{background:rgba(255,255,255,0.25);}

.stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:12px;margin-bottom:20px;}
.stat-card{background:#fff;border-radius:14px;padding:14px 16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .stat-card{background:#1e293b;border-color:#334155;}
.stat-label{font-size:0.68rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 5px;}
.stat-value{font-size:1.4rem;font-weight:700;margin:0;}

.filter-card{background:#fff;border-radius:16px;padding:16px 20px;border:1px solid #e2e8f0;margin-bottom:20px;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .filter-card{background:#1e293b;border-color:#334155;}
.filter-row{display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;}
.form-group{display:flex;flex-direction:column;gap:4px;}
.form-label{font-size:0.72rem;font-weight:600;color:#64748b;}
.dark .form-label{color:#94a3b8;}
.form-ctrl{padding:8px 12px;border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;font-size:0.83rem;outline:none;transition:border-color 0.2s;}
.dark .form-ctrl{background:#0f172a;border-color:#334155;color:#f1f5f9;}
.form-ctrl:focus{border-color:#10b981;}
.btn-filter{padding:8px 18px;border-radius:10px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-weight:600;font-size:0.83rem;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(16,185,129,0.25);transition:all 0.2s;}
.btn-filter:hover{transform:translateY(-1px);}

.table-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch;background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .table-scroll{background:#1e293b;border-color:#334155;}

table{width:100%;border-collapse:collapse;font-size:0.8rem;min-width:900px;}

th,td{white-space:nowrap;}
th{padding:10px 12px;text-align:center;font-size:0.68rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;background:#f8fafc;border-bottom:1px solid #e2e8f0;}
.dark th{background:#0f172a;color:#94a3b8;border-color:#334155;}
th:first-child,td:first-child{position:sticky;left:0;z-index:10;text-align:left;}
th:first-child{background:#f8fafc;z-index:20;}
.dark th:first-child{background:#0f172a;}
.dark td:first-child{background:#1e293b;}
td:first-child{background:#fff;}
tbody tr:hover td:first-child{background:#f8fafc;}
.dark tbody tr:hover td:first-child{background:rgba(255,255,255,0.03);}

td{padding:9px 12px;border-bottom:1px solid #f1f5f9;text-align:center;color:#374151;}
.dark td{border-color:#334155;color:#cbd5e1;}
tbody tr:hover td{background:#f8fafc;}
.dark tbody tr:hover td{background:rgba(255,255,255,0.02);}
tbody tr:last-child td{border-bottom:none;}

td.left{text-align:left;}

.cell-lunas{width:32px;height:32px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;}
.c-lunas{background:#dcfce7;color:#166534;}
.c-sebagian{background:#fef3c7;color:#92400e;}
.c-belum{background:#fee2e2;color:#991b1b;}
.dark .c-lunas{background:rgba(22,163,74,0.15);color:#4ade80;}
.dark .c-sebagian{background:rgba(245,158,11,0.15);color:#fcd34d;}
.dark .c-belum{background:rgba(239,68,68,0.12);color:#fca5a5;}

.total-cell{font-weight:700;font-size:0.8rem;}
.total-lunas{color:#059669;}
.total-sisa{color:#dc2626;}
.dark .total-lunas{color:#34d399;}
.dark .total-sisa{color:#f87171;}

.legend{display:flex;gap:16px;flex-wrap:wrap;padding:14px 20px;border-top:1px solid #f1f5f9;font-size:0.75rem;background:#fff;border-radius:0 0 16px 16px;margin-top:-1px;border:1px solid #e2e8f0;border-top:none;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .legend{background:#1e293b;border-color:#334155;}
.legend-item{display:flex;align-items:center;gap:6px;color:#64748b;}
.dark .legend-item{color:#94a3b8;}
.legend-dot{width:22px;height:22px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;}
</style>

<div class="page-bg">
    <div style="max-width:100%;margin:0 auto;">

        {{-- Banner --}}
        <div class="page-banner">
            <h1>📊 Rekap Pembayaran SPP</h1>
            <p>Status pembayaran SPP seluruh santri — {{ $tahunAjaran?->nama ?? 'Semua' }} {{ $tahunAjaran?->tahun_hijriah ? '('.$tahunAjaran->tahun_hijriah.'H)' : '' }}</p>
            <div class="banner-actions">
                <a href="{{ route('spp.index') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Input Pembayaran
                </a>
                <a href="{{ route('spp.riwayat') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-card"><p class="stat-label">Total Santri</p><p class="stat-value" style="color:#2563eb;">{{ $totalSantri }}</p></div>
            <div class="stat-card"><p class="stat-label">Lunas Semua</p><p class="stat-value" style="color:#059669;">{{ $totalLunas }}</p></div>
            <div class="stat-card"><p class="stat-label">Ada Tunggakan</p><p class="stat-value" style="color:#dc2626;">{{ $totalBelum }}</p></div>
            <div class="stat-card"><p class="stat-label">SPP/Bulan</p><p class="stat-value" style="font-size:0.95rem;color:#475569;">Rp {{ number_format($tahunAjaran?->nominal_spp ?? 0, 0, ',', '.') }}</p></div>
        </div>

        {{-- Filter --}}
        <div class="filter-card">
            <form method="GET">
                <div class="filter-row">
                    <div class="form-group">
                        <label class="form-label">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-ctrl">
                            @foreach($semua as $ta)
                                <option value="{{ $ta->id }}" {{ $tahunAjaran?->id == $ta->id ? 'selected' : '' }}>{{ $ta->nama }} {{ $ta->isAktif() ? '(Aktif)' : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" class="form-ctrl">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $kelasFilter==$kelas?'selected':'' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-filter">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px;">#</th>
                        <th style="min-width:100px;">NIS</th>
                        <th style="min-width:180px;">Nama</th>
                        <th style="min-width:80px;">Kelas</th>
                        @for($b=1;$b<=12;$b++)
                            <th title="{{ $bulanFull[$b] }}" style="min-width:52px;">{{ $bulanShort[$b] }}</th>
                        @endfor
                        <th style="min-width:100px;background:#ecfdf5;color:#059669;" class="dark:bg-emerald-900/20 dark:text-emerald-400">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapData as $index => $data)
                    @php
                        $totalBayar   = 0;
                        $totalTagihan = 0;
                    @endphp
                    <tr>
                        <td class="left" style="color:#94a3b8;font-size:0.72rem;">{{ $index+1 }}</td>
                        <td class="left" style="font-family:monospace;font-weight:600;color:#475569;border-right:1px solid #f1f5f9;" class="dark:border-slate-700 dark:text-slate-300">{{ $data['santri']->nis }}</td>
                        <td class="left" style="font-weight:600;color:#1e293b;border-right:1px solid #f1f5f9;" class="dark:border-slate-700 dark:text-white">{{ $data['santri']->nama }}</td>
                        <td style="font-size:0.78rem;color:#64748b;">{{ $data['kelas'] ?? $data['santri']->kelas }}</td>
                        @for($b=1;$b<=12;$b++)
                            @php
                                $t      = $data['tagihan'][$b] ?? null;
                                $status = $t ? $t->status : 'belum';
                                $nom    = $t ? $t->nominal : ($tahunAjaran?->nominal_spp ?? 0);
                                $totalTagihan += $nom;
                                if($status==='lunas') $totalBayar += $nom;
                                elseif($status==='sebagian'){
                                    $bayar = \App\Models\SppPembayaran::where('nis',$data['santri']->nis)->where('bulan',$b)->where('tahun_ajaran_id',$tahunAjaran?->id)->sum('nominal_bayar');
                                    $totalBayar += $bayar;
                                }
                            @endphp
                            <td>
                                <span class="cell-lunas {{ $status==='lunas' ? 'c-lunas' : ($status==='sebagian' ? 'c-sebagian' : 'c-belum') }}" title="{{ $bulanFull[$b] }}: {{ $status }}">
                                    {{ $status==='lunas' ? '✓' : ($status==='sebagian' ? '◑' : '✗') }}
                                </span>
                            </td>
                        @endfor
                        <td class="total-cell" style="background:#f0fdf4;" class="dark:bg-emerald-900/10">
                            @if($totalBayar>=$totalTagihan)
                                <span class="total-lunas">Lunas ✓</span>
                            @else
                                <span class="total-sisa">-Rp{{ number_format($totalTagihan-$totalBayar,0,',','.') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="17" style="padding:48px 24px;text-align:center;color:#94a3b8;">
                                <p style="font-weight:600;margin:0 0 4px;">Belum ada data santri</p>
                                <p style="font-size:0.8rem;margin:0;">Coba ubah filter kelas atau tahun</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Legend --}}
        <div class="legend">
            <div class="legend-item"><span class="legend-dot c-lunas">✓</span> Lunas</div>
            <div class="legend-item"><span class="legend-dot c-sebagian">◑</span> Sebagian</div>
            <div class="legend-item"><span class="legend-dot c-belum">✗</span> Belum Bayar</div>
            <div style="margin-left:auto;color:#94a3b8;font-size:0.75rem;align-self:center;">{{ $totalSantri }} santri ditampilkan</div>
        </div>

    </div>
</div>
</x-app-layout>
