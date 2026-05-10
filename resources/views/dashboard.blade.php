<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
    .dash-root { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Page background ── */
    .dash-bg {
        min-height: 100vh;
        background: #f0f4f8;
        background-image: radial-gradient(ellipse 70% 40% at 60% 0%, rgba(16,185,129,0.07) 0%, transparent 60%);
        padding: 32px 0 48px;
    }

    /* ── Welcome banner ── */
    .welcome-banner {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 70%, #059669 100%);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 8px 32px rgba(4,120,87,0.35), 0 0 0 1px rgba(16,185,129,0.2);
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(16,185,129,0.12);
        pointer-events: none;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 30%;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(6,78,59,0.4);
        pointer-events: none;
    }
    .welcome-title { font-size: 1.6rem; font-weight: 700; color: #fff; margin: 0 0 6px; position: relative; z-index: 1; }
    .welcome-sub   { color: #6ee7b7; font-size: 0.9rem; margin: 0; position: relative; z-index: 1; }
    .date-chip {
        display: inline-flex; align-items: center; gap: 10px;
        background: rgba(0,0,0,0.2); backdrop-filter: blur(8px);
        border: 1px solid rgba(16,185,129,0.3); border-radius: 14px;
        padding: 10px 16px; color: #fff; position: relative; z-index: 1;
    }
    .date-chip-label { font-size: 0.7rem; color: #6ee7b7; }
    .date-chip-val   { font-size: 0.85rem; font-weight: 600; }

    /* ── Section heading ── */
    .section-heading { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
    .section-icon {
        width: 34px; height: 34px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .section-heading h2 { font-size: 1rem; font-weight: 700; color: #1e293b; margin: 0; }

    /* ── Cards — clean light style ── */
    .dash-card {
        display: flex; align-items: flex-start; gap: 16px;
        background: #ffffff;
        border-radius: 16px; padding: 20px;
        border: 1.5px solid transparent;
        text-decoration: none;
        transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
        position: relative; overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
    }
    .dash-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 3px; border-radius: 16px 16px 0 0;
        background: var(--accent);
        opacity: 0;
        transition: opacity 0.22s;
    }
    .dash-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(0,0,0,0.1);
        border-color: var(--accent-border);
    }
    .dash-card:hover::before { opacity: 1; }

    /* Color variants */
    .card-green   { --accent: #10b981; --accent-border: rgba(16,185,129,0.3); --accent-light: #059669; }
    .card-teal    { --accent: #0d9488; --accent-border: rgba(13,148,136,0.3); --accent-light: #0d9488; }
    .card-emerald { --accent: #059669; --accent-border: rgba(5,150,105,0.3);  --accent-light: #059669; }
    .card-lime    { --accent: #65a30d; --accent-border: rgba(101,163,13,0.3); --accent-light: #65a30d; }
    .card-violet  { --accent: #8b5cf6; --accent-border: rgba(139,92,246,0.3); --accent-light: #7c3aed; }
    .card-sky     { --accent: #0ea5e9; --accent-border: rgba(14,165,233,0.3); --accent-light: #0284c7; }
    .card-amber   { --accent: #d97706; --accent-border: rgba(217,119,6,0.3); --accent-light: #b45309; }

    /* Icon wrap */
    .card-icon-wrap {
        width: 52px; height: 52px; border-radius: 14px;
        background: var(--accent-bg, #f0fdf4);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-green   .card-icon-wrap { background: #ecfdf5; }
    .card-teal    .card-icon-wrap { background: #f0fdfa; }
    .card-emerald .card-icon-wrap { background: #ecfdf5; }
    .card-lime    .card-icon-wrap { background: #f7fee7; }
    .card-violet  .card-icon-wrap { background: #f5f3ff; }
    .card-sky     .card-icon-wrap { background: #f0f9ff; }
    .card-amber   .card-icon-wrap { background: #fffbeb; }
    .dash-card:hover .card-icon-wrap { transform: scale(1.08); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .card-icon-wrap svg { color: var(--accent); }

    .card-title {
        font-size: 0.95rem; font-weight: 600;
        color: #1e293b; margin: 0 0 4px;
        transition: color 0.2s;
    }
    .dash-card:hover .card-title { color: var(--accent-light); }
    .card-desc { font-size: 0.8rem; color: #94a3b8; margin: 0; line-height: 1.4; }

    .card-arrow {
        flex-shrink: 0; color: #cbd5e1;
        transition: color 0.2s, transform 0.2s; margin-top: 2px;
    }
    .dash-card:hover .card-arrow { color: var(--accent); transform: translateX(3px); }

    /* ── Section divider ── */
    .section-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 0 0 28px;
    }

    /* ── Section label icon bg ── */
    .section-icon-green  { background: #ecfdf5; }
    .section-icon-violet { background: #f5f3ff; }

    /* ── Tips card ── */
    .tips-card {
        background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        border: 1px solid rgba(16,185,129,0.25);
        border-radius: 16px; padding: 20px 24px;
        display: flex; align-items: flex-start; gap: 14px;
        margin-top: 8px;
        box-shadow: 0 1px 6px rgba(16,185,129,0.08);
    }
</style>

<div class="dash-root dash-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Welcome Banner ── --}}
        <div class="welcome-banner">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="welcome-title">أهلاً وسهلاً 👋</h1>
                    <p class="welcome-sub">Sistem Digital — Pondok Pesantren Darus Sholah</p>
                </div>
                <div class="date-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;color:#6ee7b7;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <div>
                        <div class="date-chip-label">Hari ini</div>
                        <div class="date-chip-val">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Absensi ── --}}
        <div class="section-heading">
            <div class="section-icon section-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:18px;height:18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2>Absensi</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('absen') }}" class="dash-card card-green">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Scan Absensi</p>
                    <p class="card-desc">Lakukan absensi dengan scan QR Code santri</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>

            <a href="{{ route('rekap') }}" class="dash-card card-teal">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Rekap Absensi</p>
                    <p class="card-desc">Lihat data rekap kehadiran santri</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>

            @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('jadwal.index') }}" class="dash-card card-sky">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Kelola Jadwal</p>
                    <p class="card-desc">Atur jadwal kegiatan absensi</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
            @endif
        </div>

        {{-- ── SPP (superadmin only) ── --}}
        @if(Auth::user()->isSuperAdmin())
        <div class="section-divider"></div>
        <div class="section-heading">
            <div class="section-icon section-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:18px;height:18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75"/>
                </svg>
            </div>
            <h2>SPP</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('spp.index') }}" class="dash-card card-green">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Input Pembayaran</p>
                    <p class="card-desc">Input pembayaran SPP santri</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>

            <a href="{{ route('spp.rekap') }}" class="dash-card card-teal">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Rekap SPP</p>
                    <p class="card-desc">Lihat rekap pembayaran SPP santri</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>

            <a href="{{ route('spp.riwayat') }}" class="dash-card card-lime">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Riwayat Pembayaran</p>
                    <p class="card-desc">Lihat riwayat transaksi SPP</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
        </div>
        @endif

        {{-- ── Izin Keluar ── --}}
        <div class="section-divider"></div>
        <div class="section-heading">
            <div class="section-icon section-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:18px;height:18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
            </div>
            <h2>Izin Keluar</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('izin.index') }}" class="dash-card card-emerald">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Input Izin Keluar</p>
                    <p class="card-desc">Scan QR untuk input izin keluar santri</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>

            <a href="{{ route('izin.rekap') }}" class="dash-card card-teal">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Rekap Izin Keluar</p>
                    <p class="card-desc">Lihat daftar santri yang sedang izin keluar</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
        </div>

        {{-- ── Manajemen User (superadmin only) ── --}}
        @if(Auth::user()->isSuperAdmin())
        <div class="section-divider"></div>
        <div class="section-heading">
            <div class="section-icon section-icon-violet">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#a78bfa" style="width:18px;height:18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </div>
            <h2>Manajemen User</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('admin.users.index') }}" class="dash-card card-violet">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Kelola User</p>
                    <p class="card-desc">Kelola akun superadmin dan guru</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>

            <a href="{{ route('admin.santri.index') }}" class="dash-card card-violet">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Kelola Santri</p>
                    <p class="card-desc">Kelola data santri</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>

            <a href="{{ route('admin.santri.kelola-kelas') }}" class="dash-card card-violet">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Kelola Kelas</p>
                    <p class="card-desc">Atur penempatan kelas santri</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>

            <a href="{{ route('admin.tahun-ajaran.index') }}" class="dash-card card-amber">
                <div class="card-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15A1.5 1.5 0 0121 6.75v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12A1.5 1.5 0 014.5 5.25z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="card-title">Tahun Ajaran</p>
                    <p class="card-desc">Kelola periode akademik dan nominal SPP</p>
                </div>
                <svg class="card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
        </div>
        @endif

        {{-- ── Tips ── --}}
        <div class="tips-card">
            <div style="width:40px;height:40px;border-radius:12px;background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:20px;height:20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                </svg>
            </div>
            <div>
                <p style="font-weight:600;color:#065f46;font-size:0.875rem;margin:0 0 4px;">Tips Penggunaan</p>
                <p style="font-size:0.8rem;color:#047857;margin:0;line-height:1.5;">Pastikan kamera device berfungsi dengan baik untuk scan QR Code. Absensi hanya bisa dilakukan pada waktu yang sudah dijadwalkan.</p>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
