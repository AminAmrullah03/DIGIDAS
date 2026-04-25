{{-- ============================================================
     NAVIGATION — Dark Navy + Emerald, Glassmorphism, Animated
     ============================================================ --}}

<style>
    /* ── Font ── */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .nav-root { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Navbar base ── */
    .navbar {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        border-bottom: 1px solid rgba(16,185,129,0.2);
        box-shadow: 0 4px 32px rgba(0,0,0,0.4), 0 0 0 1px rgba(16,185,129,0.05);
        position: relative;
        overflow: visible;
    }
    .navbar::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
        opacity: 0.5;
    }

    /* ── Nav link pill ── */
    .nav-pill {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
    }
    .nav-pill:hover {
        color: #fff;
        background: rgba(16,185,129,0.12);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16,185,129,0.15);
    }
    .nav-pill.active {
        color: #fff;
        background: linear-gradient(135deg, rgba(16,185,129,0.25), rgba(5,150,105,0.15));
        box-shadow: 0 0 0 1px rgba(16,185,129,0.4), 0 4px 16px rgba(16,185,129,0.2);
    }
    .nav-pill.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 2px;
        background: #10b981;
        border-radius: 999px;
        box-shadow: 0 0 8px #10b981;
    }
    .nav-pill svg { flex-shrink: 0; opacity: 0.8; transition: opacity 0.2s, transform 0.2s; }
    .nav-pill:hover svg, .nav-pill.active svg { opacity: 1; transform: scale(1.1); }

    /* ── User dropdown trigger ── */
    .user-trigger {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px 6px 6px;
        border-radius: 12px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        cursor: pointer;
        transition: all 0.2s;
        color: #e2e8f0;
        font-size: 0.8125rem;
        font-weight: 500;
    }
    .user-trigger:hover {
        background: rgba(16,185,129,0.12);
        border-color: rgba(16,185,129,0.3);
        color: #fff;
    }
    .user-avatar {
        width: 30px; height: 30px;
        border-radius: 8px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }
    .role-badge {
        font-size: 0.65rem;
        font-weight: 600;
        padding: 1px 6px;
        border-radius: 999px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .role-badge.superadmin { background: rgba(167,139,250,0.2); color: #a78bfa; border: 1px solid rgba(167,139,250,0.3); }
    .role-badge.guru { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.25); }

    /* ── Dropdown ── */
    .nav-dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        width: 200px;
        background: #1e293b;
        border: 1px solid rgba(16,185,129,0.2);
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.03);
        overflow: hidden;
        transform-origin: top right;
        animation: dropIn 0.18s cubic-bezier(0.34,1.56,0.64,1) forwards;
        z-index: 9999;
    }
    @keyframes dropIn {
        from { opacity: 0; transform: scale(0.92) translateY(-6px); }
        to   { opacity: 1; transform: scale(1)   translateY(0);     }
    }
    .nav-dropdown a, .nav-dropdown button {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 10px 16px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #94a3b8;
        text-decoration: none;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
        text-align: left;
    }
    .nav-dropdown a:hover, .nav-dropdown button:hover {
        background: rgba(16,185,129,0.1);
        color: #fff;
        padding-left: 20px;
    }
    .nav-dropdown .divider { height: 1px; background: rgba(255,255,255,0.06); margin: 4px 0; }

    /* ── Mobile menu ── */
    .mobile-menu {
        background: #0f172a;
        border-top: 1px solid rgba(16,185,129,0.15);
        animation: slideDown 0.22s ease forwards;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .mobile-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.15s;
        border-left: 3px solid transparent;
    }
    .mobile-pill:hover { color: #fff; background: rgba(16,185,129,0.08); border-left-color: rgba(16,185,129,0.4); }
    .mobile-pill.active { color: #10b981; background: rgba(16,185,129,0.08); border-left-color: #10b981; font-weight: 600; }

    /* ── Hamburger ── */
    .hamburger { color: #64748b; transition: color 0.2s; }
    .hamburger:hover { color: #10b981; }
</style>

<nav class="navbar nav-root" x-data="{ open: false, dropOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- ── Logo ── --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;box-shadow:0 0 16px rgba(16,185,129,0.4);transition:box-shadow 0.2s;" class="group-hover:shadow-[0_0_24px_rgba(16,185,129,0.6)]">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/><path d="M3 17l2 2 4-4"/>
                        </svg>
                    </div>
                    <span style="font-size:0.9rem;font-weight:700;color:#f1f5f9;letter-spacing:-0.01em;">DIGI<span style="color:#10b981">DAS</span></span>
                </a>

                {{-- ── Desktop Nav Links ── --}}
                <div class="hidden sm:flex items-center gap-1">

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}" class="nav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>

                    {{-- Absensi --}}
                    <a href="{{ route('absen') }}" class="nav-pill {{ request()->routeIs('absen') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                        Absensi
                    </a>

                    {{-- Rekap --}}
                    <a href="{{ route('rekap') }}" class="nav-pill {{ request()->routeIs('rekap') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Rekap
                    </a>

                    {{-- Izin --}}
                    <a href="{{ route('izin.index') }}" class="nav-pill {{ request()->routeIs('izin.*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Izin
                    </a>

                    {{-- Superadmin only --}}
                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('jadwal.index') }}" class="nav-pill {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Jadwal
                        </a>
                        <a href="{{ route('spp.rekap') }}" class="nav-pill {{ request()->routeIs('spp.*') ? 'active' : '' }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                            SPP
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-pill {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                            Pengguna
                        </a>
                    @endif
                </div>
            </div>

            {{-- ── User Dropdown ── --}}
            <div class="hidden sm:flex items-center" x-data="{ dropOpen: false }" @click.outside="dropOpen = false">
                <button @click="dropOpen = !dropOpen" class="user-trigger">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div style="text-align:left;line-height:1.2;">
                        <div style="color:#f1f5f9;font-size:0.8rem;font-weight:600;">{{ Str::limit(Auth::user()->name, 16) }}</div>
                        <div>
                            <span class="role-badge {{ Auth::user()->isSuperAdmin() ? 'superadmin' : 'guru' }}">
                                {{ Auth::user()->isSuperAdmin() ? 'Superadmin' : 'Guru' }}
                            </span>
                        </div>
                    </div>
                    <svg style="width:14px;height:14px;color:#64748b;transition:transform 0.2s;" :style="dropOpen ? 'transform:rotate(180deg)' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>

                <div x-show="dropOpen" class="nav-dropdown" style="display:none;">
                    <div style="padding:12px 16px 10px;border-bottom:1px solid rgba(255,255,255,0.06);">
                        <div style="font-size:0.7rem;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;font-weight:600;">NIP</div>
                        <div style="font-size:0.8rem;color:#94a3b8;font-family:monospace;margin-top:2px;">{{ Auth::user()->nip }}</div>
                    </div>
                    <div style="padding:4px 0;">
                        <a href="{{ route('profile.edit') }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Profil Saya
                        </a>
                        <div class="divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="color:#f87171;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ── Hamburger ── --}}
            <button @click="open = !open" class="hamburger sm:hidden p-2 rounded-lg">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ── Mobile Menu ── --}}
    <div x-show="open" class="mobile-menu sm:hidden" style="display:none;">
        <div style="padding:8px 0 4px;">
            <a href="{{ route('dashboard') }}" class="mobile-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="{{ route('absen') }}" class="mobile-pill {{ request()->routeIs('absen') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                Absensi
            </a>
            <a href="{{ route('rekap') }}" class="mobile-pill {{ request()->routeIs('rekap') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Rekap
            </a>
            <a href="{{ route('izin.index') }}" class="mobile-pill {{ request()->routeIs('izin.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Izin
            </a>
            @if(Auth::user()->isSuperAdmin())
                <div style="height:1px;background:rgba(255,255,255,0.06);margin:6px 20px;"></div>
                <a href="{{ route('jadwal.index') }}" class="mobile-pill {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jadwal
                </a>
                <a href="{{ route('spp.rekap') }}" class="mobile-pill {{ request()->routeIs('spp.*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                    SPP
                </a>
                <a href="{{ route('admin.users.index') }}" class="mobile-pill {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    Pengguna
                </a>
            @endif
        </div>

        {{-- Mobile user info --}}
        <div style="padding:12px 20px 16px;border-top:1px solid rgba(255,255,255,0.06);margin-top:4px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <div>
                    <div style="font-size:0.875rem;font-weight:600;color:#f1f5f9;">{{ Auth::user()->name }}</div>
                    <div style="font-size:0.75rem;color:#64748b;font-family:monospace;">{{ Auth::user()->nip }}</div>
                </div>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('profile.edit') }}" style="flex:1;text-align:center;padding:7px;border-radius:8px;background:rgba(255,255,255,0.05);color:#94a3b8;font-size:0.8rem;font-weight:500;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='rgba(16,185,129,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">Profil</a>
                <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                    @csrf
                    <button type="submit" style="width:100%;padding:7px;border-radius:8px;background:rgba(248,113,113,0.1);color:#f87171;font-size:0.8rem;font-weight:500;border:none;cursor:pointer;transition:background 0.15s;" onmouseover="this.style.background='rgba(248,113,113,0.2)'" onmouseout="this.style.background='rgba(248,113,113,0.1)'">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>