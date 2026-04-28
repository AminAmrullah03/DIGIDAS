<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
*{font-family:'Plus Jakarta Sans',sans-serif;}
.page-bg{min-height:100vh;background:#f1f5f9;padding:28px 16px;}
.dark .page-bg{background:#0f172a;}
.form-card{background:#fff;border-radius:20px;border:1px solid #e2e8f0;box-shadow:0 4px 24px rgba(0,0,0,0.06);overflow:hidden;max-width:640px;margin:0 auto;}
.dark .form-card{background:#1e293b;border-color:#334155;}
.form-header{background:linear-gradient(135deg,#064e3b,#059669);padding:22px 24px;}
.form-header h2{color:#fff;font-size:1.1rem;font-weight:700;margin:0 0 3px;}
.form-header p{color:#6ee7b7;font-size:0.8rem;margin:0;}
.form-body{padding:24px;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-group{display:flex;flex-direction:column;gap:5px;}
.form-group.full{grid-column:1/-1;}
.form-label{font-size:0.75rem;font-weight:700;color:#374151;}
.dark .form-label{color:#cbd5e1;}
.form-ctrl{padding:10px 12px;border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;font-size:0.875rem;outline:none;transition:border-color 0.2s,box-shadow 0.2s;width:100%;box-sizing:border-box;}
.dark .form-ctrl{background:#0f172a;border-color:#334155;color:#f1f5f9;}
.form-ctrl:focus{border-color:#10b981;box-shadow:0 0 0 3px rgba(16,185,129,0.1);}
.form-ctrl:disabled{opacity:0.6;cursor:not-allowed;}
.form-error{font-size:0.72rem;color:#dc2626;}
.divider{height:1px;background:#f1f5f9;margin:20px 0;}
.dark .divider{background:#334155;}
.section-title{font-size:0.75rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 14px;}
.btn-submit{width:100%;padding:12px;border-radius:12px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-weight:700;font-size:0.9rem;border:none;cursor:pointer;transition:all 0.2s;box-shadow:0 2px 8px rgba(16,185,129,0.3);}
.btn-submit:hover{transform:translateY(-1px);}
.btn-back{display:inline-flex;align-items:center;gap:6px;font-size:0.8rem;color:#64748b;text-decoration:none;margin-bottom:16px;transition:color 0.15s;}
.btn-back:hover{color:#059669;}
.kelas-notice{padding:10px 14px;background:#fef3c7;border:1px solid #fcd34d;border-radius:10px;font-size:0.8rem;color:#92400e;margin-top:8px;display:none;}
.dark .kelas-notice{background:rgba(245,158,11,0.1);border-color:rgba(252,211,77,0.3);color:#fcd34d;}
</style>
<div class="page-bg">
    <div style="max-width:640px;margin:0 auto;">
        <a href="{{ route('admin.santri.index') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali ke Daftar Santri
        </a>
        <div class="form-card">
            <div class="form-header"><h2>✏️ Edit Data Santri</h2><p>{{ $santri->nama }} — NIS: {{ $santri->nis }}</p></div>
            <div class="form-body">
                <form action="{{ route('admin.santri.update', $santri->nis) }}" method="POST">
                    @csrf @method('PUT')
                    <p class="section-title">Data Identitas</p>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">NIS</label>
                            <input type="text" value="{{ $santri->nis }}" disabled class="form-ctrl" style="font-family:monospace;">
                            <span style="font-size:0.72rem;color:#94a3b8;">NIS tidak dapat diubah</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $santri->tanggal_masuk?->format('Y-m-d')) }}" class="form-ctrl">
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" name="nama" value="{{ old('nama', $santri->nama) }}" required class="form-ctrl">
                            @error('nama')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="divider"></div>
                    <p class="section-title">Data Kelas</p>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Gender *</label>
                            <select name="gender" id="gender" required class="form-ctrl" onchange="updateKelas()">
                                <option value="PA" {{ old('gender',$santri->gender)==='PA'?'selected':'' }}>PA (Putra)</option>
                                <option value="PI" {{ old('gender',$santri->gender)==='PI'?'selected':'' }}>PI (Putri)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenjang *</label>
                            <select name="jenjang" id="jenjang" required class="form-ctrl" onchange="updateKelas()">
                                <option value="Reguler" {{ old('jenjang',$santri->jenjang)==='Reguler'?'selected':'' }}>Reguler</option>
                                <option value="Tahfidz" {{ old('jenjang',$santri->jenjang)==='Tahfidz'?'selected':'' }}>Tahfidz</option>
                            </select>
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Kelas *</label>
                            <select name="kelas" id="kelas" required class="form-ctrl" onchange="checkKelasChange()"></select>
                            <div class="kelas-notice" id="kelas-notice">⚠️ Kelas berubah dari <strong>{{ $santri->kelas }}</strong> — perubahan ini akan dicatat di riwayat kelas.</div>
                            @error('kelas')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group full" id="catatan-wrap" style="display:none;">
                            <label class="form-label">Catatan Perubahan Kelas</label>
                            <input type="text" name="catatan_kelas" class="form-ctrl" placeholder="Misal: Naik kelas, pindah jalur...">
                        </div>
                    </div>
                    <div class="divider"></div>
                    <p class="section-title">Status</p>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label class="form-label">Status Santri *</label>
                            <select name="status" required class="form-ctrl">
                                <option value="aktif" {{ old('status',$santri->status)==='aktif'?'selected':'' }}>Aktif</option>
                                <option value="lulus" {{ old('status',$santri->status)==='lulus'?'selected':'' }}>Lulus</option>
                                <option value="mutasi" {{ old('status',$santri->status)==='mutasi'?'selected':'' }}>Mutasi</option>
                                <option value="dikeluarkan" {{ old('status',$santri->status)==='dikeluarkan'?'selected':'' }}>Dikeluarkan</option>
                                <option value="wafat" {{ old('status',$santri->status)==='wafat'?'selected':'' }}>Wafat</option>
                            </select>
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="form-ctrl" placeholder="Catatan tambahan...">{{ old('keterangan', $santri->keterangan) }}</textarea>
                        </div>
                    </div>
                    <div style="margin-top:24px;"><button type="submit" class="btn-submit">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
const KELAS = @json($daftarKelas);
const KELAS_AWAL = '{{ $santri->kelas }}';
function updateKelas() {
    const gender = document.getElementById('gender').value;
    const jenjang = document.getElementById('jenjang').value;
    const select = document.getElementById('kelas');
    select.innerHTML = '';
    (KELAS[gender]?.[jenjang] ?? []).forEach(k => {
        const opt = document.createElement('option');
        opt.value = k; opt.textContent = k;
        if ((select.options.length === 0 ? KELAS_AWAL : null) === k || KELAS_AWAL === k) opt.selected = true;
        select.appendChild(opt);
    });
    checkKelasChange();
}
function checkKelasChange() {
    const changed = document.getElementById('kelas').value !== KELAS_AWAL;
    document.getElementById('kelas-notice').style.display = changed ? 'block' : 'none';
    document.getElementById('catatan-wrap').style.display = changed ? 'block' : 'none';
}
updateKelas();
</script>
</x-app-layout>