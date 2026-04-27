<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-bg { min-height: 100vh; background: #f1f5f9; padding: 28px 16px; }
.dark .page-bg { background: #0f172a; }

.page-banner {
    background: linear-gradient(135deg,#064e3b 0%,#065f46 50%,#059669 100%);
    border-radius: 20px; padding: 22px 28px; margin-bottom: 20px;
    position: relative; overflow: hidden;
}
.page-banner::before {
    content:''; position:absolute; top:-40px; right:-40px;
    width:150px; height:150px; border-radius:50%;
    background:rgba(16,185,129,0.12); pointer-events:none;
}
.page-banner h1 { color:#fff; font-size:1.2rem; font-weight:700; margin:0 0 4px; position:relative; z-index:1; }
.page-banner p  { color:#6ee7b7; font-size:0.82rem; margin:0; position:relative; z-index:1; }

.alert {
    display:flex; align-items:flex-start; gap:10px;
    padding:12px 16px; border-radius:12px;
    font-size:0.83rem; font-weight:500; margin-bottom:16px;
}
.alert-error { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
.dark .alert-error { background:rgba(239,68,68,0.12); color:#fca5a5; border-color:rgba(252,165,165,0.3); }

.form-card {
    background:#fff; border-radius:20px;
    border:1px solid #e2e8f0;
    box-shadow:0 4px 24px rgba(0,0,0,0.06);
    overflow:hidden;
}
.dark .form-card { background:#1e293b; border-color:#334155; }

.form-card-header {
    padding:20px 24px; border-bottom:1px solid #f1f5f9;
    display:flex; align-items:center; gap:12px;
}
.dark .form-card-header { border-color:#334155; }
.form-card-icon {
    width:40px; height:40px; border-radius:12px;
    background:linear-gradient(135deg,#fef3c7,#fde68a);
    display:flex; align-items:center; justify-content:center;
}
.dark .form-card-icon { background:rgba(245,158,11,0.12); }
.form-card-title { font-size:0.95rem; font-weight:700; color:#1e293b; margin:0; }
.dark .form-card-title { color:#f1f5f9; }
.form-card-sub   { font-size:0.75rem; color:#94a3b8; margin:0; }

.form-body { padding:24px; }

.form-section { margin-bottom:22px; }
.form-section-title {
    font-size:0.7rem; font-weight:700; color:#94a3b8;
    text-transform:uppercase; letter-spacing:0.08em;
    margin:0 0 12px; padding-bottom:8px;
    border-bottom:1px solid #f1f5f9;
}
.dark .form-section-title { border-color:#334155; }

.form-group { margin-bottom:14px; }
.form-label {
    display:block; font-size:0.78rem; font-weight:600;
    color:#475569; margin-bottom:6px;
}
.dark .form-label { color:#94a3b8; }
.form-label span { color:#ef4444; margin-left:2px; }

.form-input {
    width:100%; padding:11px 14px; border-radius:11px;
    border:1.5px solid #e2e8f0; background:#f8fafc;
    color:#1e293b; font-size:0.875rem; font-weight:500;
    outline:none; transition:border-color 0.2s, box-shadow 0.2s;
    box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;
}
.dark .form-input { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.form-input:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.1); }

.form-textarea {
    width:100%; padding:11px 14px; border-radius:11px;
    border:1.5px solid #e2e8f0; background:#f8fafc;
    color:#1e293b; font-size:0.875rem; font-weight:500;
    outline:none; transition:border-color 0.2s, box-shadow 0.2s;
    box-sizing:border-box; resize:vertical; min-height:80px;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.dark .form-textarea { background:#0f172a; border-color:#334155; color:#f1f5f9; }
.form-textarea:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.1); }

.form-hint { font-size:0.72rem; color:#94a3b8; margin-top:4px; }
.form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
@media(max-width:480px) { .form-grid-2 { grid-template-columns:1fr; } }

.hari-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:8px; }
@media(max-width:500px) { .hari-grid { grid-template-columns:repeat(2,1fr); } }

.hari-checkbox { display:none; }
.hari-label {
    display:flex; align-items:center; justify-content:center;
    padding:9px 8px; border-radius:10px;
    border:1.5px solid #e2e8f0; background:#f8fafc;
    font-size:0.8rem; font-weight:600; color:#64748b;
    cursor:pointer; transition:all 0.15s; user-select:none;
}
.dark .hari-label { background:#0f172a; border-color:#334155; color:#94a3b8; }
.hari-label:hover { border-color:#10b981; color:#059669; background:#ecfdf5; }
.dark .hari-label:hover { background:rgba(16,185,129,0.08); color:#34d399; border-color:#10b981; }
.hari-checkbox:checked + .hari-label {
    border-color:#10b981; background:#ecfdf5; color:#059669; font-weight:700;
    box-shadow:0 0 0 3px rgba(16,185,129,0.1);
}
.dark .hari-checkbox:checked + .hari-label {
    background:rgba(16,185,129,0.15); color:#34d399; border-color:#10b981;
}

.aktif-toggle-wrap {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 16px; border-radius:12px;
    background:#f8fafc; border:1.5px solid #e2e8f0;
}
.dark .aktif-toggle-wrap { background:#0f172a; border-color:#334155; }
.aktif-toggle-wrap p { font-size:0.85rem; font-weight:600; color:#1e293b; margin:0 0 2px; }
.dark .aktif-toggle-wrap p { color:#f1f5f9; }
.aktif-toggle-wrap span { font-size:0.72rem; color:#94a3b8; }

.toggle-switch {
    position:relative; width:44px; height:24px;
    display:inline-block; cursor:pointer; flex-shrink:0;
}
.toggle-switch input { opacity:0; width:0; height:0; }
.toggle-slider {
    position:absolute; inset:0; border-radius:24px;
    background:#cbd5e1; transition:background 0.2s;
}
.toggle-slider::before {
    content:''; position:absolute;
    width:18px; height:18px; border-radius:50%;
    background:#fff; left:3px; top:3px;
    transition:transform 0.2s;
    box-shadow:0 1px 4px rgba(0,0,0,0.2);
}
input:checked + .toggle-slider { background:#10b981; }
input:checked + .toggle-slider::before { transform:translateX(20px); }

.form-actions {
    display:flex; gap:10px; justify-content:flex-end;
    padding-top:20px; border-top:1px solid #f1f5f9; margin-top:8px;
}
.dark .form-actions { border-color:#334155; }

.btn-batal {
    padding:10px 20px; border-radius:10px;
    border:1.5px solid #e2e8f0; background:transparent;
    color:#64748b; font-weight:600; font-size:0.875rem;
    text-decoration:none; transition:all 0.15s;
    display:inline-flex; align-items:center; gap:6px;
}
.dark .btn-batal { border-color:#334155; color:#94a3b8; }
.btn-batal:hover { background:#f8fafc; }

.btn-simpan {
    padding:10px 24px; border-radius:10px;
    background:linear-gradient(135deg,#059669,#10b981);
    color:#fff; font-weight:700; font-size:0.875rem;
    border:none; cursor:pointer; transition:all 0.2s;
    box-shadow:0 2px 8px rgba(16,185,129,0.3);
    display:inline-flex; align-items:center; gap:6px;
}
.btn-simpan:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(16,185,129,0.4); }
</style>

<div class="page-bg">
    <div style="max-width:640px;margin:0 auto;">

        @if($errors->any())
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif

        <div class="page-banner">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;display:inline;margin-right:6px;vertical-align:-2px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                </svg>
                Edit Jadwal Absensi
            </h1>
            <p>Perbarui detail jadwal "{{ $jadwal->nama_kegiatan }}"</p>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                    </svg>
                </div>
                <div>
                    <p class="form-card-title">Edit Jadwal</p>
                    <p class="form-card-sub">Perbarui informasi jadwal kegiatan</p>
                </div>
            </div>

            <div class="form-body">
                <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-section">
                        <p class="form-section-title">Detail Kegiatan</p>
                        <div class="form-group">
                            <label class="form-label">Nama Kegiatan <span>*</span></label>
                            <input type="text" name="nama_kegiatan"
                                value="{{ old('nama_kegiatan', $jadwal->nama_kegiatan) }}"
                                class="form-input" placeholder="Contoh: Sholat Subuh Berjamaah" required>
                        </div>
                        <div class="form-grid-2">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Kode (opsional)</label>
                                <input type="text" name="kode"
                                    value="{{ old('kode', $jadwal->kode) }}"
                                    class="form-input" placeholder="Mis. NGP">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">&nbsp;</label>
                                <div class="aktif-toggle-wrap">
                                    <div>
                                        <p>Status Jadwal</p>
                                        <span>Aktifkan saat jadwal berlaku</span>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="aktif" value="1" {{ old('aktif', $jadwal->aktif) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <p class="form-section-title">Waktu Pelaksanaan</p>
                        <div class="form-grid-2">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Jam Mulai <span>*</span></label>
                                <input type="time" name="jam_mulai"
                                    value="{{ old('jam_mulai', substr($jadwal->jam_mulai,0,5)) }}"
                                    class="form-input" required>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Jam Selesai <span>*</span></label>
                                <input type="time" name="jam_selesai"
                                    value="{{ old('jam_selesai', substr($jadwal->jam_selesai,0,5)) }}"
                                    class="form-input" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <p class="form-section-title">Hari Berlaku</p>
                        @php
                            $selectedDays = (array)old('hari', $jadwal->hari ?? []);
                            $days = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];
                        @endphp
                        <div class="hari-grid">
                            @foreach($days as $k => $label)
                            <div>
                                <input type="checkbox" name="hari[]" value="{{ $k }}" id="hari_{{ $k }}"
                                    class="hari-checkbox" {{ in_array($k, $selectedDays) ? 'checked' : '' }}>
                                <label for="hari_{{ $k }}" class="hari-label">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                        <p class="form-hint">Biarkan kosong jika jadwal berlaku setiap hari.</p>
                    </div>

                    <div class="form-section" style="margin-bottom:0;">
                        <p class="form-section-title">Keterangan Tambahan</p>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Keterangan (opsional)</label>
                            <textarea name="keterangan" class="form-textarea"
                                placeholder="Tambahkan catatan atau keterangan...">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('jadwal.index') }}" class="btn-batal">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                            Batal
                        </a>
                        <button type="submit" class="btn-simpan">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Update Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
</x-app-layout>