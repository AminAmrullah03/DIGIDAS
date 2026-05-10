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
    /* Icon dalam nav-pill (bukan chevron): scale on hover/active */
    .nav-pill svg:not(.chevron) { flex-shrink: 0; opacity: 0.8; transition: opacity 0.2s, transform 0.2s; }
    .nav-pill:hover svg:not(.chevron), .nav-pill.active svg:not(.chevron) { opacity: 1; transform: scale(1.1); }
    /* Button nav-pill reset */
    button.nav-pill {
        background: transparent;
        border: none;
        cursor: pointer;
        outline: none;
        font-family: inherit;
    }
    button.nav-pill:focus { outline: none; }
    /* Chevron: hanya rotate, tidak scale */
    button.nav-pill .chevron { flex-shrink: 0; opacity: 0.55; transition: transform 0.2s; }
    button.nav-pill:hover .chevron, button.nav-pill.active .chevron { opacity: 0.9; }
    /* Admin pill: ungu saat tidak active */
    .nav-pill.admin-pill { color: #a78bfa; }
    .nav-pill.admin-pill:hover { color: #fff; }
    .nav-pill.admin-pill.active { color: #fff; }

    /* ── User dropdown trigger ── */
    .user-trigger {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 5px 10px 5px 5px;
        border-radius: 12px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        cursor: pointer;
        transition: all 0.2s;
        color: #e2e8f0;
        font-size: 0.8125rem;
        font-weight: 500;
        font-family: inherit;
        outline: none;
        white-space: nowrap;
    }
    .user-trigger:hover {
        background: rgba(16,185,129,0.1);
        border-color: rgba(16,185,129,0.3);
        box-shadow: 0 4px 16px rgba(16,185,129,0.12);
    }
    .user-trigger:focus { outline: none; }
    .user-avatar {
        width: 32px; height: 32px;
        border-radius: 9px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; font-weight: 700; color: #fff;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(16,185,129,0.35);
    }
    .user-info { text-align: left; line-height: 1.25; }
    .user-info-name { color: #f1f5f9; font-size: 0.8rem; font-weight: 600; max-width: 110px; overflow: hidden; text-overflow: ellipsis; }
    .user-chevron {
        width: 14px; height: 14px;
        color: #64748b;
        transition: transform 0.2s, color 0.2s;
        flex-shrink: 0;
        margin-left: 2px;
    }
    .user-trigger:hover .user-chevron { color: #94a3b8; }
    .role-badge {
        display: inline-block;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 1px 5px;
        border-radius: 999px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-top: 2px;
    }
    .role-badge.superadmin { background: rgba(167,139,250,0.18); color: #c4b5fd; border: 1px solid rgba(167,139,250,0.3); }
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
    .nav-dropdown a.active-item, .nav-dropdown a.active-item:hover {
        color: #10b981;
        background: rgba(16,185,129,0.12);
        padding-left: 20px;
        font-weight: 600;
    }
    .mobile-pill.mobile-sub { padding-left: 32px; font-size: 0.85rem; }

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
                    <img src="{{ asset('images/logo1.png') }}" alt="DIGIDAS Logo"
                         style="height:34px;width:auto;object-fit:contain;filter:drop-shadow(0 0 8px rgba(16,185,129,0.4));transition:filter 0.2s;"
                         class="group-hover:drop-shadow-[0_0_12px_rgba(16,185,129,0.7)]">
                    <span style="font-size:0.9rem;font-weight:700;color:#f1f5f9;letter-spacing:-0.01em;">DIGI<span style="color:#10b981">DAS</span></span>
                </a>

                {{-- ── Desktop Nav Links ── --}}
                <div class="hidden sm:flex items-center gap-1">

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}" class="nav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>

                    {{-- Dropdown: Absensi --}}
                    <div class="nav-dropdown-wrap" x-data="{ absenOpen: false }" @click.outside="absenOpen = false" style="position:relative;">
                        <button @click="absenOpen = !absenOpen"
                            class="nav-pill {{ request()->routeIs('absen') || request()->routeIs('rekap') ? 'active' : '' }}"
                            :class="{ 'active': absenOpen }">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                            Absensi
                            <svg class="chevron" :style="absenOpen ? 'transform:rotate(180deg)' : ''" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="absenOpen" class="nav-dropdown" style="display:none;left:0;right:auto;min-width:180px;">
                            <div style="padding:4px 0;">
                                <a href="{{ route('absen') }}" class="{{ request()->routeIs('absen') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
                                    Scan Absensi
                                </a>
                                <a href="{{ route('rekap') }}" class="{{ request()->routeIs('rekap') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                    Rekap Absensi
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Dropdown: Izin Keluar --}}
                    <div class="nav-dropdown-wrap" x-data="{ izinOpen: false }" @click.outside="izinOpen = false" style="position:relative;">
                        <button @click="izinOpen = !izinOpen"
                            class="nav-pill {{ request()->routeIs('izin.*') ? 'active' : '' }}"
                            :class="{ 'active': izinOpen }">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Izin Keluar
                            <svg class="chevron" :style="izinOpen ? 'transform:rotate(180deg)' : ''" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="izinOpen" class="nav-dropdown" style="display:none;left:0;right:auto;min-width:180px;">
                            <div style="padding:4px 0;">
                                <a href="{{ route('izin.index') }}" class="{{ request()->routeIs('izin.index') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Input Izin Keluar
                                </a>
                                <a href="{{ route('izin.rekap') }}" class="{{ request()->routeIs('izin.rekap') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                    Rekap Izin Keluar
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Dropdown: Admin (superadmin only) --}}
                    @if(Auth::user()->isSuperAdmin())
                    <div class="nav-dropdown-wrap" x-data="{ adminOpen: false }" @click.outside="adminOpen = false" style="position:relative;">
                        <button @click="adminOpen = !adminOpen"
                            class="nav-pill admin-pill {{ request()->routeIs('jadwal.*') || request()->routeIs('spp.*') || request()->routeIs('admin.users.*') || request()->routeIs('admin.santri.*') || request()->routeIs('admin.tahun-ajaran.*') || request()->routeIs('admin.santri.kelola-kelas') ? 'active' : '' }}"
                            :class="{ 'active': adminOpen }">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Admin
                            <svg class="chevron" :style="adminOpen ? 'transform:rotate(180deg)' : ''" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="adminOpen" class="nav-dropdown" style="display:none;left:0;right:auto;min-width:190px;">
                            <div style="padding:6px 16px 6px;border-bottom:1px solid rgba(167,139,250,0.15);">
                                <div style="font-size:0.65rem;color:#a78bfa;text-transform:uppercase;letter-spacing:0.08em;font-weight:700;">Panel Admin</div>
                            </div>
                            <div style="padding:4px 0;">
                                <a href="{{ route('jadwal.index') }}" class="{{ request()->routeIs('jadwal.*') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    Jadwal
                                </a>
                                <a href="{{ route('spp.rekap') }}" class="{{ request()->routeIs('spp.*') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                                    SPP
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                    Kelola User
                                </a>
                                <a href="{{ route('admin.santri.index') }}" class="{{ request()->routeIs('admin.santri.index') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                    Santri
                                </a>
                                <a href="{{ route('admin.santri.kelola-kelas') }}" class="{{ request()->routeIs('admin.santri.kelola-kelas') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 17h7m-3.5-3.5v7"/></svg>
                                    Kelola Kelas
                                </a>
                                <a href="{{ route('admin.tahun-ajaran.index') }}" class="{{ request()->routeIs('admin.tahun-ajaran.*') ? 'active-item' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                    Tahun Ajaran
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ── User Dropdown ── --}}
            <div class="hidden sm:flex items-center" style="position:relative;" x-data="{ dropOpen: false }" @click.outside="dropOpen = false">
                <button @click="dropOpen = !dropOpen" class="user-trigger">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="user-info">
                        <div class="user-info-name">{{ Str::limit(Auth::user()->name, 18) }}</div>
                        <span class="role-badge {{ Auth::user()->isSuperAdmin() ? 'superadmin' : 'guru' }}">
                            {{ Auth::user()->isSuperAdmin() ? 'Superadmin' : 'Guru' }}
                        </span>
                    </div>
                    <svg class="user-chevron" :style="dropOpen ? 'transform:rotate(180deg)' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
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

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" class="mobile-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            {{-- Absensi Section --}}
            <div style="height:1px;background:rgba(255,255,255,0.06);margin:4px 20px;"></div>
            <div style="padding:6px 20px 4px;font-size:0.65rem;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;font-weight:700;">Absensi</div>
            <a href="{{ route('absen') }}" class="mobile-pill mobile-sub {{ request()->routeIs('absen') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
                Scan Absensi
            </a>
            <a href="{{ route('rekap') }}" class="mobile-pill mobile-sub {{ request()->routeIs('rekap') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Rekap Absensi
            </a>

            {{-- Izin Keluar Section --}}
            <div style="height:1px;background:rgba(255,255,255,0.06);margin:4px 20px;"></div>
            <div style="padding:6px 20px 4px;font-size:0.65rem;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;font-weight:700;">Izin Keluar</div>
            <a href="{{ route('izin.index') }}" class="mobile-pill mobile-sub {{ request()->routeIs('izin.index') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Input Izin Keluar
            </a>
            <a href="{{ route('izin.rekap') }}" class="mobile-pill mobile-sub {{ request()->routeIs('izin.rekap') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Rekap Izin Keluar
            </a>

            {{-- Admin Section (superadmin only) --}}
            @if(Auth::user()->isSuperAdmin())
                <div style="height:1px;background:rgba(167,139,250,0.2);margin:4px 20px;"></div>
                <div style="padding:6px 20px 4px;font-size:0.65rem;color:#a78bfa;text-transform:uppercase;letter-spacing:0.08em;font-weight:700;">Admin</div>
                <a href="{{ route('jadwal.index') }}" class="mobile-pill mobile-sub {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jadwal
                </a>
                <a href="{{ route('spp.rekap') }}" class="mobile-pill mobile-sub {{ request()->routeIs('spp.*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                    SPP
                </a>
                <a href="{{ route('admin.users.index') }}" class="mobile-pill mobile-sub {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    Kelola User
                </a>
                <a href="{{ route('admin.santri.index') }}" class="mobile-pill mobile-sub {{ request()->routeIs('admin.santri.index') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    Santri
                </a>
                <a href="{{ route('admin.santri.kelola-kelas') }}" class="mobile-pill mobile-sub {{ request()->routeIs('admin.santri.kelola-kelas') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 17h7m-3.5-3.5v7"/></svg>
                    Kelola Kelas
                </a>
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="mobile-pill mobile-sub {{ request()->routeIs('admin.tahun-ajaran.*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    Tahun Ajaran
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
