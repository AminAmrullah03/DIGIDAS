<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-bg { min-height:100vh; background:#f1f5f9; padding:28px 16px; }
.dark .page-bg { background:#0f172a; }
.page-wrap { max-width:1200px; margin:0 auto; }

/* ── Banner ── */
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
.page-banner p  { color:#c4b5fd; font-size:0.82rem; margin:0; position:relative; z-index:1; }
.banner-actions { display:flex; gap:8px; margin-top:14px; flex-wrap:wrap; position:relative; z-index:1; }

/* ── Buttons ── */
.btn-primary, .btn-white, .btn-soft, .btn-action, .btn-danger, .btn-success {
    display:inline-flex; align-items:center; justify-content:center; gap:7px;
    border-radius:10px; font-size:0.8rem; font-weight:700;
    text-decoration:none; border:none; cursor:pointer; transition:all 0.16s;
}
.btn-primary { padding:9px 17px; background:#fff; color:#4c1d95; box-shadow:0 2px 10px rgba(0,0,0,0.13); }
.btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,0,0,0.16); }
.btn-white  { padding:8px 15px; color:#fff; background:rgba(255,255,255,0.14); border:1px solid rgba(255,255,255,0.24); }
.btn-white:hover { background:rgba(255,255,255,0.23); }
.btn-soft   { padding:8px 12px; color:#475569; background:#f8fafc; border:1px solid #e2e8f0; }
.btn-soft:hover { color:#4c1d95; border-color:#ddd6fe; background:#f5f3ff; }
.btn-action { padding:8px 12px; color:#0369a1; background:#eff6ff; border:1px solid #bfdbfe; }
.btn-danger { padding:8px 12px; color:#be123c; background:#fff1f2; border:1px solid #fecdd3; }
.btn-success { padding:8px 12px; color:#166534; background:#dcfce7; border:1px solid #86efac; }

/* ── Alert ── */
.alert { display:flex; align-items:flex-start; gap:10px; padding:12px 15px; border-radius:12px; font-size:0.83rem; font-weight:600; margin-bottom:14px; }
.alert-success { background:#dcfce7; color:#166534; border:1px solid #86efac; }
.alert-error   { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }

/* ── Stats ── */
.stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:12px; margin-bottom:16px; }
.stat-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:14px;
    padding:15px 16px; box-shadow:0 1px 4px rgba(15,23,42,0.05);
}
.dark .stat-card { background:#1e293b; border-color:#334155; }
.stat-label { margin:0 0 5px; font-size:0.67rem; color:#94a3b8; font-weight:800; text-transform:uppercase; letter-spacing:0.05em; }
.stat-value { margin:0; font-size:1.42rem; color:#0f172a; font-weight:800; }
.dark .stat-value { color:#f1f5f9; }

/* ── Filter card ── */
.filter-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:16px;
    padding:16px 18px; margin-bottom:16px; box-shadow:0 1px 4px rgba(15,23,42,0.05);
}
.dark .filter-card { background:#1e293b; border-color:#334155; }
.filter-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; align-items:end; }
.filter-label { display:block; font-size:0.72rem; font-weight:700; color:#64748b; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.04em; }
.filter-input, .filter-select {
    width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:10px;
    font-size:0.82rem; color:#334155; background:#fff; font-family:inherit;
    transition:border-color 0.15s; box-sizing:border-box;
}
.filter-input:focus, .filter-select:focus {
    outline:none; border-color:#a78bfa; box-shadow:0 0 0 3px rgba(167,139,250,0.12);
}
.dark .filter-input, .dark .filter-select { background:#0f172a; border-color:#334155; color:#cbd5e1; }

/* ── Table card ── */
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
.table-head p  { margin:3px 0 0; font-size:0.76rem; color:#94a3b8; }
table { width:100%; border-collapse:collapse; font-size:0.79rem; }
th {
    padding:11px 14px; background:#f8fafc; color:#64748b; text-align:left;
    font-size:0.67rem; font-weight:800; text-transform:uppercase; letter-spacing:0.045em;
    border-bottom:1px solid #e2e8f0; white-space:nowrap;
}
td { padding:12px 14px; border-bottom:1px solid #f1f5f9; color:#334155; vertical-align:middle; }
.dark th { background:#0f172a; color:#94a3b8; border-color:#334155; }
.dark td { color:#cbd5e1; border-color:#334155; }
tbody tr:hover td { background:#faf5ff; }
.dark tbody tr:hover td { background:rgba(255,255,255,0.025); }
tbody tr:last-child td { border-bottom:none; }

/* ── Santri cell ── */
.santri-cell { display:flex; align-items:center; gap:10px; }
.santri-avatar {
    width:34px; height:34px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-size:0.7rem; font-weight:800; color:#fff; flex-shrink:0;
}
.avatar-pa { background:linear-gradient(135deg,#6d28d9,#8b5cf6); }
.avatar-pi { background:linear-gradient(135deg,#be185d,#ec4899); }
.santri-name { margin:0; font-weight:700; color:#0f172a; font-size:0.83rem; }
.dark .santri-name { color:#f8fafc; }
.santri-nis  { margin:2px 0 0; color:#94a3b8; font-size:0.71rem; }

/* ── Badge ── */
.badge {
    display:inline-flex; align-items:center; gap:4px; padding:4px 10px;
    border-radius:999px; font-size:0.68rem; font-weight:800; white-space:nowrap;
}
.badge-aktif    { background:#dbeafe; color:#1d4ed8; }
.badge-selesai  { background:#f1f5f9; color:#64748b; }
.badge-belum    { background:#fef9c3; color:#854d0e; }
.badge-sudah    { background:#dcfce7; color:#166534; }
.badge-terlambat{ background:#fee2e2; color:#991b1b; }

/* ── Event chip ── */
.event-chip {
    display:inline-flex; align-items:center; gap:6px; padding:5px 10px;
    background:#ede9fe; border-radius:10px; font-size:0.75rem;
    font-weight:700; color:#5b21b6;
}

/* ── Empty ── */
.empty-state {
    background:#fff; border:1.5px dashed #ddd6fe; border-radius:16px;
    padding:54px 20px; text-align:center;
}
.dark .empty-state { background:#1e293b; border-color:#4c1d95; }
.empty-icon {
    width:58px; height:58px; border-radius:16px; background:#ede9fe;
    display:flex; align-items:center; justify-content:center; margin:0 auto 14px;
}

/* ── Pagination ── */
.pagi-wrap { padding:14px 18px; border-top:1px solid #f1f5f9; }
.dark .pagi-wrap { border-color:#334155; }

/* ── Export note ── */
.export-bar {
    display:flex; align-items:center; justify-content:space-between;
    gap:12px; padding:10px 18px; background:#faf5ff;
    border-bottom:1px solid #ede9fe; flex-wrap:wrap;
}
.dark .export-bar { background:rgba(109,40,217,0.08); border-color:rgba(109,40,217,0.2); }
.export-bar p { margin:0; font-size:0.77rem; color:#7c3aed; font-weight:600; }

/* ── Responsive ── */
@media(max-width:700px) {
    th:nth-child(4), td:nth-child(4),
    th:nth-child(6), td:nth-child(6) { display:none; }
    .filter-grid { grid-template-columns:1fr; }
}
</style>

<?php
    use App\Models\Santri;
    $kelasList = Santri::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
?>

<div class="page-bg">
<div class="page-wrap">

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><span>✓</span><div><?php echo e(session('success')); ?></div></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-error"><span>!</span><div><?php echo e(session('error')); ?></div></div>
    <?php endif; ?>

    
    <div class="page-banner">
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;display:inline;margin-right:6px;vertical-align:-3px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
            </svg>
            Rekap Perpulangan
        </h1>
        <p>Pantau daftar santri berdasarkan event perpulangan yang sedang atau sudah berlangsung.</p>
        <div class="banner-actions">
            <a href="<?php echo e(route('admin.perpulangan.index')); ?>" class="btn-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kelola Event
            </a>
        </div>
    </div>

    
    <div class="stats-row">
        <div class="stat-card">
            <p class="stat-label">Total Santri Rekap</p>
            <p class="stat-value"><?php echo e($totalSantri); ?></p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Belum Kembali</p>
            <p class="stat-value" style="color:#d97706;"><?php echo e($belumKembali); ?></p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Sudah Kembali</p>
            <p class="stat-value" style="color:#16a34a;"><?php echo e($sudahKembali); ?></p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Event Aktif</p>
            <p class="stat-value" style="color:#7c3aed;"><?php echo e($totalEventAktif); ?></p>
        </div>
    </div>

    
    <div class="filter-card">
        <form method="GET" action="<?php echo e(route('admin.perpulangan.rekap')); ?>">
            <div class="filter-grid">
                <div>
                    <label class="filter-label">Event Perpulangan</label>
                    <select name="perpulangan_id" class="filter-select">
                        <option value="">Semua Event</option>
                        <?php $__currentLoopData = $eventList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($event->id); ?>" <?php echo e(request('perpulangan_id') == $event->id ? 'selected' : ''); ?>>
                                <?php echo e($event->nama_event); ?>

                                (<?php echo e($event->tanggal_mulai->format('d/m/Y')); ?> – <?php echo e($event->batas_kembali->format('d/m/Y')); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="filter-label">Kelas</label>
                    <select name="kelas" class="filter-select">
                        <option value="">Semua Kelas</option>
                        <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k); ?>" <?php echo e(request('kelas') === $k ? 'selected' : ''); ?>><?php echo e($k); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="filter-label">Status Kembali</label>
                    <select name="status_kembali" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="belum" <?php echo e(request('status_kembali') === 'belum' ? 'selected' : ''); ?>>Belum Kembali</option>
                        <option value="sudah" <?php echo e(request('status_kembali') === 'sudah' ? 'selected' : ''); ?>>Sudah Kembali</option>
                    </select>
                </div>
                <div>
                    <label class="filter-label">Cari Nama / NIS</label>
                    <input type="text" name="search" class="filter-input" placeholder="Nama atau NIS..." value="<?php echo e(request('search')); ?>">
                </div>
                <div style="display:flex;gap:8px;align-items:flex-end;">
                    <button type="submit" class="btn-action" style="flex:1;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/></svg>
                        Filter
                    </button>
                    <a href="<?php echo e(route('admin.perpulangan.rekap')); ?>" class="btn-soft">Reset</a>
                </div>
            </div>
        </form>
    </div>

    
    <?php if($santriList->isEmpty()): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7c3aed" style="width:26px;height:26px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
            </div>
            <p style="font-weight:800;color:#0f172a;margin:0 0 6px;">Tidak ada data santri</p>
            <p style="color:#94a3b8;font-size:0.82rem;margin:0 0 16px;">
                <?php if(request()->hasAny(['perpulangan_id','kelas','status_kembali','search'])): ?>
                    Tidak ada hasil untuk filter yang dipilih.
                <?php else: ?>
                    Belum ada data santri yang tercatat dalam event perpulangan.
                <?php endif; ?>
            </p>
            <?php if(request()->hasAny(['perpulangan_id','kelas','status_kembali','search'])): ?>
                <a href="<?php echo e(route('admin.perpulangan.rekap')); ?>" class="btn-soft">Tampilkan Semua</a>
            <?php else: ?>
                <a href="<?php echo e(route('admin.perpulangan.index')); ?>" class="btn-primary" style="color:#4c1d95;">Kelola Event Perpulangan</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="table-card">
            <div class="export-bar">
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;display:inline;vertical-align:-2px;margin-right:4px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                    Menampilkan <strong><?php echo e($santriList->total()); ?></strong> santri
                    <?php if(request('perpulangan_id')): ?>
                        · Event: <strong><?php echo e($eventList->firstWhere('id', request('perpulangan_id'))?->nama_event); ?></strong>
                    <?php endif; ?>
                    <?php if(request('kelas')): ?>
                        · Kelas: <strong><?php echo e(request('kelas')); ?></strong>
                    <?php endif; ?>
                </p>
            </div>

            <div class="table-head">
                <div>
                    <h2>Daftar Santri Perpulangan</h2>
                    <p><?php echo e($santriList->total()); ?> santri ditemukan</p>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Santri</th>
                            <th>Kelas</th>
                            <th>Event Perpulangan</th>
                            <th>Batas Kembali</th>
                            <th>Status Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $santriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $santri = $row['santri'];
                            $event  = $row['event'];
                            $sudah  = $row['sudah_kembali'];
                            $terlambat = $row['terlambat'];
                            $initials = collect(explode(' ', $santri->nama))->map(fn($w)=>strtoupper(substr($w,0,1)))->take(2)->join('');
                            $isPA = str_starts_with($santri->kelas ?? '', 'PA');
                        ?>
                        <tr>
                            <td style="color:#94a3b8;font-weight:700;font-size:0.75rem;"><?php echo e($santriList->firstItem() + $i); ?></td>
                            <td>
                                <div class="santri-cell">
                                    <div class="santri-avatar <?php echo e($isPA ? 'avatar-pa' : 'avatar-pi'); ?>"><?php echo e($initials); ?></div>
                                    <div>
                                        <p class="santri-name"><?php echo e($santri->nama); ?></p>
                                        <p class="santri-nis"><?php echo e($santri->nis); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight:700;color:#334155;"><?php echo e($santri->kelas ?? '-'); ?></span>
                            </td>
                            <td>
                                <span class="event-chip">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:12px;height:12px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                                    </svg>
                                    <?php echo e(Str::limit($event->nama_event, 30)); ?>

                                </span>
                            </td>
                            <td>
                                <span style="font-weight:600;color:<?php echo e(now()->gt($event->batas_kembali) && !$sudah ? '#dc2626' : '#334155'); ?>">
                                    <?php echo e($event->batas_kembali->translatedFormat('d M Y')); ?>

                                </span>
                                <?php if(now()->gt($event->batas_kembali) && !$sudah): ?>
                                    <br><span style="font-size:0.68rem;color:#dc2626;font-weight:700;">Melewati batas!</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($sudah && $terlambat): ?>
                                    <span class="badge badge-terlambat">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6" fill="currentColor" style="width:6px;height:6px;"><circle cx="3" cy="3" r="3"/></svg>
                                        Terlambat Kembali
                                    </span>
                                <?php elseif($sudah): ?>
                                    <span class="badge badge-sudah">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6" fill="currentColor" style="width:6px;height:6px;"><circle cx="3" cy="3" r="3"/></svg>
                                        Sudah Kembali
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-belum">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6" fill="currentColor" style="width:6px;height:6px;"><circle cx="3" cy="3" r="3"/></svg>
                                        Belum Kembali
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($santriList->hasPages()): ?>
                <div class="pagi-wrap">
                    <?php echo e($santriList->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\Pondok\web\digidas\DIGIDAS\resources\views/admin/perpulangan/rekap.blade.php ENDPATH**/ ?>