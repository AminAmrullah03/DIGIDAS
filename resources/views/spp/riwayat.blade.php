<x-app-layout>
@php
$bulanHijriah = [
    1=>'Muharram',2=>'Safar',3=>'Rabiul Awal',4=>'Rabiul Akhir',
    5=>'Jumadil Awal',6=>'Jumadil Akhir',7=>'Rajab',8=>'Syaban',
    9=>'Ramadhan',10=>'Syawal',11=>'Dzulqaidah',12=>'Dzulhijjah'
];
@endphp
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
*{font-family:'Plus Jakarta Sans',sans-serif;}
.page-bg{min-height:100vh;background:#f1f5f9;padding:28px 16px;}
.dark .page-bg{background:#0f172a;}

/* Banner */
.page-banner{background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#059669 100%);border-radius:20px;padding:24px 28px;margin-bottom:20px;position:relative;overflow:hidden;}
.page-banner::before{content:'';position:absolute;top:-50px;right:-50px;width:180px;height:180px;border-radius:50%;background:rgba(16,185,129,0.12);pointer-events:none;}
.page-banner h1{color:#fff;font-size:1.3rem;font-weight:700;margin:0 0 4px;position:relative;z-index:1;}
.page-banner p{color:#6ee7b7;font-size:0.82rem;margin:0;position:relative;z-index:1;}
.banner-actions{display:flex;gap:8px;margin-top:16px;flex-wrap:wrap;position:relative;z-index:1;}
.btn-white{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s;backdrop-filter:blur(4px);}
.btn-white:hover{background:rgba(255,255,255,0.25);}

/* Stats row */
.stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;margin-bottom:20px;}
.stat-card{background:#fff;border-radius:14px;padding:16px 18px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .stat-card{background:#1e293b;border-color:#334155;}
.stat-label{font-size:0.7rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 6px;}
.stat-value{font-size:1.3rem;font-weight:700;margin:0;}
.stat-green .stat-value{color:#059669;}
.stat-blue .stat-value{color:#2563eb;}
.dark .stat-green .stat-value{color:#34d399;}
.dark .stat-blue .stat-value{color:#60a5fa;}

/* Filter card */
.filter-card{background:#fff;border-radius:16px;padding:18px 20px;border:1px solid #e2e8f0;margin-bottom:20px;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .filter-card{background:#1e293b;border-color:#334155;}
.filter-title{font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 12px;}
.dark .filter-title{color:#94a3b8;}

/* Period tabs */
.period-tabs{display:flex;gap:6px;margin-bottom:14px;flex-wrap:wrap;}
.period-tab{padding:6px 14px;border-radius:8px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:0.78rem;font-weight:600;cursor:pointer;text-decoration:none;transition:all 0.15s;}
.dark .period-tab{background:#0f172a;border-color:#334155;color:#94a3b8;}
.period-tab:hover,.period-tab.active{background:#ecfdf5;border-color:#10b981;color:#059669;}
.dark .period-tab:hover,.dark .period-tab.active{background:rgba(16,185,129,0.1);color:#34d399;border-color:#10b981;}

.filter-row{display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;}
.form-group{display:flex;flex-direction:column;gap:4px;}
.form-label{font-size:0.73rem;font-weight:600;color:#64748b;}
.dark .form-label{color:#94a3b8;}
.form-ctrl{padding:8px 12px;border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;font-size:0.83rem;outline:none;transition:border-color 0.2s;}
.dark .form-ctrl{background:#0f172a;border-color:#334155;color:#f1f5f9;}
.form-ctrl:focus{border-color:#10b981;}
.btn-filter{padding:8px 18px;border-radius:10px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-weight:600;font-size:0.83rem;border:none;cursor:pointer;transition:all 0.2s;box-shadow:0 2px 8px rgba(16,185,129,0.25);}
.btn-filter:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(16,185,129,0.35);}

/* Table */
.table-card{background:#fff;border-radius:16px;border:1px solid #e2e8f0;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.04);}
.dark .table-card{background:#1e293b;border-color:#334155;}
table{width:100%;border-collapse:collapse;}
thead th{background:#f8fafc;padding:11px 16px;text-align:left;font-size:0.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #e2e8f0;}
.dark thead th{background:#0f172a;color:#94a3b8;border-color:#334155;}
tbody tr{transition:background 0.15s;}
tbody tr:hover{background:#f8fafc;}
.dark tbody tr:hover{background:rgba(255,255,255,0.02);}
tbody td{padding:12px 16px;font-size:0.83rem;color:#374151;border-bottom:1px solid #f1f5f9;}
.dark tbody td{color:#cbd5e1;border-color:#1e293b;}
tbody tr:last-child td{border-bottom:none;}

.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:999px;font-size:0.72rem;font-weight:600;}
.badge-cash{background:#dcfce7;color:#166534;}
.badge-transfer{background:#dbeafe;color:#1d4ed8;}
.dark .badge-cash{background:rgba(22,163,74,0.15);color:#4ade80;}
.dark .badge-transfer{background:rgba(37,99,235,0.15);color:#60a5fa;}

.nominal-cell{font-weight:700;color:#059669;}
.dark .nominal-cell{color:#34d399;}

.empty-state{padding:48px 24px;text-align:center;color:#94a3b8;}
.empty-state svg{width:48px;height:48px;margin:0 auto 12px;opacity:0.4;}

/* Pagination */
.pagination-wrap{padding:14px 20px;border-top:1px solid #f1f5f9;}
.dark .pagination-wrap{border-color:#334155;}
</style>

<div class="page-bg">
    <div style="max-width:1100px;margin:0 auto;">

        {{-- Banner --}}
        <div class="page-banner">
            <h1>📜 Riwayat Pembayaran SPP</h1>
            <p>Daftar seluruh transaksi pembayaran SPP santri</p>
            <div class="banner-actions">
                <a href="{{ route('spp.index') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Input Pembayaran
                </a>
                <a href="{{ route('spp.rekap') }}" class="btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    Rekap SPP
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-card stat-blue">
                <p class="stat-label">Total Transaksi</p>
                <p class="stat-value">{{ $pembayaran->total() }}</p>
            </div>
            <div class="stat-card stat-green">
                <p class="stat-label">Total Nominal</p>
                <p class="stat-value" style="font-size:1rem;">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Periode</p>
                <p class="stat-value" style="font-size:0.95rem;color:#475569;" class="dark:text-slate-300">
                    @if($period === 'today') Hari Ini
                    @elseif($period === 'week') Minggu Ini
                    @elseif($period === 'custom' && $dari && $sampai) {{ \Carbon\Carbon::parse($dari)->format('d/m') }} – {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}
                    @else Semua
                    @endif
                </p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="filter-card">
            <p class="filter-title">Filter</p>

            {{-- Period tabs --}}
            <div class="period-tabs">
                <a href="{{ request()->fullUrlWithQuery(['period'=>'all','dari'=>null,'sampai'=>null,'page'=>null]) }}" class="period-tab {{ $period==='all' ? 'active':'' }}">Semua</a>
                <a href="{{ request()->fullUrlWithQuery(['period'=>'today','dari'=>null,'sampai'=>null,'page'=>null]) }}" class="period-tab {{ $period==='today' ? 'active':'' }}">Hari Ini</a>
                <a href="{{ request()->fullUrlWithQuery(['period'=>'week','dari'=>null,'sampai'=>null,'page'=>null]) }}" class="period-tab {{ $period==='week' ? 'active':'' }}">Minggu Ini</a>
                <a href="#" class="period-tab {{ $period==='custom' ? 'active':'' }}" onclick="document.getElementById('custom-range').style.display=document.getElementById('custom-range').style.display==='none'?'flex':'none';return false;">Rentang Tanggal</a>
            </div>

            <form method="GET">
                {{-- Custom date range --}}
                <div id="custom-range" style="display:{{ $period==='custom' ? 'flex' : 'none' }};gap:10px;flex-wrap:wrap;align-items:flex-end;margin-bottom:12px;padding:14px;background:#f8fafc;border-radius:12px;border:1px dashed #e2e8f0;">
                    <input type="hidden" name="period" value="custom">
                    <div class="form-group">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ $dari }}" class="form-ctrl">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ $sampai }}" class="form-ctrl">
                    </div>
                    <button type="submit" class="btn-filter">Terapkan</button>
                </div>

                {{-- NIS & Tahun filter --}}
                <div class="filter-row">
                    @if($period !== 'custom')
                        <input type="hidden" name="period" value="{{ $period }}">
                        @if($dari)<input type="hidden" name="dari" value="{{ $dari }}">@endif
                        @if($sampai)<input type="hidden" name="sampai" value="{{ $sampai }}">@endif
                    @endif
                    <div class="form-group">
                        <label class="form-label">NIS Santri</label>
                        <input type="text" name="nis" value="{{ $nis }}" placeholder="Cari NIS..." class="form-ctrl" style="width:140px;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tahun Hijriah</label>
                        <select name="tahun" class="form-ctrl">
                            @for($y=1448;$y>=1444;$y--)
                                <option value="{{ $y }}" {{ $tahun==$y ? 'selected':'' }}>{{ $y }} H</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn-filter">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        Filter
                    </button>
                    @if($nis || $period !== 'all')
                        <a href="{{ route('spp.riwayat') }}" style="padding:8px 14px;border-radius:10px;border:1.5px solid #e2e8f0;color:#64748b;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal & Waktu</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th>Bulan SPP</th>
                            <th>Nominal</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayaran as $item)
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#1e293b;" class="dark:text-white">{{ $item->created_at->format('d M Y') }}</div>
                                <div style="font-size:0.75rem;color:#94a3b8;">{{ $item->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td style="font-family:monospace;font-weight:600;color:#475569;" class="dark:text-slate-300">{{ $item->nis }}</td>
                            <td>
                                <div style="font-weight:600;color:#1e293b;" class="dark:text-white">{{ $item->santri->nama ?? '-' }}</div>
                                <div style="font-size:0.75rem;color:#94a3b8;">{{ $item->santri->kelas ?? '' }}</div>
                            </td>
                            <td>{{ $bulanHijriah[$item->bulan] ?? '-' }} {{ $item->tahun }}H</td>
                            <td class="nominal-cell">Rp {{ number_format($item->nominal_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($item->metode === 'cash')
                                    <span class="badge badge-cash">💵 Cash</span>
                                @else
                                    <span class="badge badge-transfer">🏦 Transfer</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                    <p style="font-weight:600;margin:0 0 4px;">Belum ada data pembayaran</p>
                                    <p style="font-size:0.8rem;margin:0;">Coba ubah filter periode atau tahun</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pembayaran->hasPages())
                <div class="pagination-wrap">{{ $pembayaran->links() }}</div>
            @endif
        </div>

    </div>
</div>
</x-app-layout>