<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-bg { min-height:100vh; background:#f1f5f9; padding:28px 16px; }
.dark .page-bg { background:#0f172a; }
.page-wrap { max-width:640px; margin:0 auto; }

.page-banner {
    background:linear-gradient(135deg,#1e1b4b 0%,#312e81 52%,#4c1d95 100%);
    border-radius:20px; padding:22px 28px; margin-bottom:18px;
    position:relative; overflow:hidden;
}
.page-banner h1 { color:#fff; font-size:1.18rem; font-weight:700; margin:0 0 4px; }
.page-banner p { color:#c4b5fd; font-size:0.82rem; margin:0; }

.form-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:18px;
    box-shadow:0 2px 10px rgba(15,23,42,0.06); overflow:hidden;
}
.dark .form-card { background:#1e293b; border-color:#334155; }
.form-header {
    padding:18px 22px; border-bottom:1px solid #f1f5f9;
    display:flex; align-items:center; gap:12px;
}
.dark .form-header { border-color:#334155; }
.form-header-icon {
    width:40px; height:40px; border-radius:12px; background:#ede9fe;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.form-header h2 { margin:0; font-size:0.98rem; font-weight:800; color:#0f172a; }
.dark .form-header h2 { color:#f8fafc; }
.form-body { padding:22px; }

.field { margin-bottom:18px; }
.field:last-child { margin-bottom:0; }
.field label {
    display:block; margin-bottom:6px;
    font-size:0.76rem; font-weight:800; color:#374151; letter-spacing:0.02em;
}
.dark .field label { color:#cbd5e1; }
.field input, .field textarea, .field select {
    width:100%; padding:11px 14px; border-radius:10px;
    border:1.5px solid #e2e8f0; background:#f8fafc; color:#1e293b;
    font-size:0.86rem; outline:none; box-sizing:border-box; transition:.15s;
}
.field input:focus, .field textarea:focus, .field select:focus {
    border-color:#7c3aed; box-shadow:0 0 0 3px rgba(124,58,237,0.1);
    background:#fff;
}
.dark .field input, .dark .field textarea, .dark .field select {
    background:#0f172a; border-color:#334155; color:#f1f5f9;
}
.field textarea { min-height:90px; resize:vertical; }
.field .hint { margin:5px 0 0; font-size:0.72rem; color:#94a3b8; }

.field-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

.error-msg {
    margin:4px 0 0; font-size:0.72rem; color:#dc2626; font-weight:600;
}
.input-error { border-color:#fca5a5 !important; }

.form-footer {
    padding:16px 22px; border-top:1px solid #f1f5f9;
    display:flex; gap:10px; justify-content:flex-end;
}
.dark .form-footer { border-color:#334155; }
.btn-back {
    padding:10px 18px; border-radius:10px; border:1.5px solid #e2e8f0;
    background:transparent; color:#64748b; font-size:0.84rem; font-weight:700;
    cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px;
}
.btn-back:hover { background:#f8fafc; }
.btn-submit {
    padding:10px 22px; border-radius:10px; border:none;
    background:linear-gradient(135deg,#4c1d95,#7c3aed); color:#fff;
    font-size:0.84rem; font-weight:700; cursor:pointer;
    display:inline-flex; align-items:center; gap:7px; transition:.16s;
}
.btn-submit:hover { opacity:0.9; transform:translateY(-1px); }

.alert-error {
    display:flex; align-items:flex-start; gap:10px; padding:12px 15px;
    border-radius:12px; font-size:0.83rem; font-weight:600; margin-bottom:14px;
    background:#fee2e2; color:#991b1b; border:1px solid #fca5a5;
}

@media (max-width:520px) {
    .field-row { grid-template-columns:1fr; }
}
</style>

<div class="page-bg">
    <div class="page-wrap">

        @if($errors->any())
            <div class="alert-error">
                <span>!</span>
                <div>
                    <strong>Ada kesalahan pada form:</strong>
                    <ul style="margin:4px 0 0;padding-left:16px;">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Banner --}}
        <div class="page-banner">
            <h1>Tambah Event Perpulangan</h1>
            <p>Buat event perpulangan baru — liburan semester, hari raya, dan lainnya.</p>
        </div>

        {{-- Form --}}
        <div class="form-card">
            <div class="form-header">
                <div class="form-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7c3aed" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                    </svg>
                </div>
                <div>
                    <h2>Detail Event Perpulangan</h2>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.perpulangan.store') }}">
                @csrf
                <div class="form-body">

                    {{-- Nama Event --}}
                    <div class="field">
                        <label for="nama_event">Nama Event <span style="color:#dc2626;">*</span></label>
                        <input
                            type="text"
                            id="nama_event"
                            name="nama_event"
                            value="{{ old('nama_event') }}"
                            placeholder="Contoh: Perpulangan Liburan Semester Ganjil 2025"
                            class="{{ $errors->has('nama_event') ? 'input-error' : '' }}"
                            required>
                        @error('nama_event')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Mulai & Batas Kembali --}}
                    <div class="field-row">
                        <div class="field">
                            <label for="tanggal_mulai">Tanggal Mulai <span style="color:#dc2626;">*</span></label>
                            <input
                                type="date"
                                id="tanggal_mulai"
                                name="tanggal_mulai"
                                value="{{ old('tanggal_mulai') }}"
                                class="{{ $errors->has('tanggal_mulai') ? 'input-error' : '' }}"
                                required>
                            @error('tanggal_mulai')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="batas_kembali">Batas Kembali <span style="color:#dc2626;">*</span></label>
                            <input
                                type="date"
                                id="batas_kembali"
                                name="batas_kembali"
                                value="{{ old('batas_kembali') }}"
                                class="{{ $errors->has('batas_kembali') ? 'input-error' : '' }}"
                                required>
                            <p class="hint">Deadline santri harus sudah kembali ke pondok.</p>
                            @error('batas_kembali')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="field">
                        <label for="keterangan">Keterangan <span style="color:#94a3b8;font-weight:500;">(opsional)</span></label>
                        <textarea
                            id="keterangan"
                            name="keterangan"
                            placeholder="Catatan tambahan untuk event ini, misalnya: khusus santri kelas 1-3, dsb.">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="form-footer">
                    <a href="{{ route('admin.perpulangan.index') }}" class="btn-back">
                        ← Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tambah Perpulangan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
// Pastikan batas_kembali tidak bisa lebih awal dari tanggal_mulai
document.getElementById('tanggal_mulai').addEventListener('change', function () {
    const batas = document.getElementById('batas_kembali');
    if (batas.value && batas.value < this.value) {
        batas.value = this.value;
    }
    batas.min = this.value;
});
</script>
</x-app-layout>
