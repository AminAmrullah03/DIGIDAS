<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family:'Plus Jakarta Sans', sans-serif; }
.page-bg { min-height:100vh; background:#f1f5f9; padding:28px 16px; }
.form-shell { max-width:780px; margin:0 auto; }
.page-banner {
    background:linear-gradient(135deg,#064e3b 0%,#065f46 52%,#0d9488 100%);
    border-radius:20px; padding:24px 28px; margin-bottom:18px; position:relative; overflow:hidden;
}
.page-banner::before { content:''; position:absolute; top:-54px; right:-42px; width:176px; height:176px; border-radius:50%; background:rgba(45,212,191,0.14); }
.page-banner h1 { color:#fff; font-size:1.25rem; font-weight:800; margin:0 0 5px; position:relative; z-index:1; }
.page-banner p { color:#a7f3d0; font-size:0.82rem; margin:0; position:relative; z-index:1; }
.form-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 5px rgba(15,23,42,0.06); }
.form-card-head { padding:16px 18px; border-bottom:1px solid #e2e8f0; display:flex; gap:12px; align-items:center; }
.head-icon { width:42px; height:42px; border-radius:12px; background:#ecfdf5; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.form-card h2 { margin:0 0 2px; color:#0f172a; font-size:0.98rem; font-weight:800; }
.form-card p { margin:0; color:#94a3b8; font-size:0.76rem; }
.form-body { padding:18px; }
.form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; }
.span-2 { grid-column:span 2; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-label { color:#475569; font-size:0.76rem; font-weight:800; }
.form-label span { color:#dc2626; }
.input-wrap { position:relative; }
.input-wrap svg { position:absolute; left:12px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:#94a3b8; pointer-events:none; }
.form-ctrl {
    width:100%; border:1.5px solid #e2e8f0; border-radius:10px; background:#f8fafc;
    color:#0f172a; font-size:0.84rem; padding:10px 12px 10px 38px; outline:none; transition:all 0.16s;
}
.form-ctrl.no-icon { padding-left:12px; }
.form-ctrl:focus { border-color:#14b8a6; box-shadow:0 0 0 3px rgba(20,184,166,0.12); background:#fff; }
.form-ctrl.is-error { border-color:#ef4444; background:#fff7f7; }
.form-error { color:#dc2626; font-size:0.72rem; font-weight:600; }
.form-help { color:#94a3b8; font-size:0.73rem; line-height:1.45; }
.error-box { margin-bottom:14px; padding:12px 14px; border-radius:12px; background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; font-size:0.8rem; font-weight:600; }
.form-actions { display:flex; justify-content:flex-end; gap:9px; padding:15px 18px; background:#f8fafc; border-top:1px solid #e2e8f0; }
.btn-cancel, .btn-submit {
    display:inline-flex; align-items:center; justify-content:center; gap:7px;
    padding:9px 16px; border-radius:10px; font-size:0.82rem; font-weight:800;
    text-decoration:none; border:none; cursor:pointer; transition:all 0.16s;
}
.btn-cancel { background:#fff; border:1px solid #e2e8f0; color:#64748b; }
.btn-cancel:hover { color:#0f766e; border-color:#99f6e4; background:#f0fdfa; }
.btn-submit { background:linear-gradient(135deg,#059669,#14b8a6); color:#fff; box-shadow:0 2px 10px rgba(20,184,166,0.24); }
.btn-submit:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(20,184,166,0.30); }
@media (max-width:640px) { .form-grid { grid-template-columns:1fr; } .span-2 { grid-column:span 1; } .form-actions { flex-direction:column-reverse; } .btn-cancel,.btn-submit { width:100%; } }
</style>

<div class="page-bg">
    <div class="form-shell">
        <div class="page-banner">
            <h1>Tambah Tahun Ajaran</h1>
            <p>Buat periode akademik baru untuk kelas, absensi, dan SPP.</p>
        </div>

        <div class="form-card">
            <div class="form-card-head">
                <div class="head-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#059669" style="width:22px;height:22px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                </div>
                <div>
                    <h2>Data Tahun Ajaran</h2>
                    <p>Tahun ajaran baru akan dibuat dengan status selesai sampai diaktifkan.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.tahun-ajaran.store') }}">
                @csrf
                <div class="form-body">
                    @if($errors->any())
                        <div class="error-box">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    @include('admin.tahun-ajaran._form')
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Simpan Tahun Ajaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
