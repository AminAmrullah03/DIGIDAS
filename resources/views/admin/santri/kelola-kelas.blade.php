<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
*{font-family:'Plus Jakarta Sans',sans-serif;}
.page-bg{min-height:100vh;background:#f1f5f9;padding:28px 16px;}
.dark .page-bg{background:#0f172a;}

.page-banner{background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#059669 100%);border-radius:20px;padding:24px 28px;margin-bottom:20px;position:relative;overflow:hidden;}
.page-banner::before{content:'';position:absolute;top:-50px;right:-50px;width:180px;height:180px;border-radius:50%;background:rgba(16,185,129,0.12);pointer-events:none;}
.page-banner h1{color:#fff;font-size:1.3rem;font-weight:700;margin:0 0 4px;position:relative;z-index:1;}
.page-banner p{color:#6ee7b7;font-size:0.82rem;margin:0;position:relative;z-index:1;}
.btn-white{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.15s;cursor:pointer;backdrop-filter:blur(4px);margin-top:14px;position:relative;z-index:1;}
.btn-white:hover{background:rgba(255,255,255,0.25);}

.card{background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 6px rgba(0,0,0,0.05);margin-bottom:16px;}
.dark .card{background:#1e293b;border-color:#334155;}
.card-body{padding:20px;}

/* Filter step */
.step-label{display:flex;align-items:center;gap:8px;font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 14px;}
.step-num{width:22px;height:22px;border-radius:50%;background:#10b981;color:#fff;font-size:0.7rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;}

.filter-row{display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;}
.form-group{display:flex;flex-direction:column;gap:4px;}
.form-label{font-size:0.73rem;font-weight:600;color:#64748b;}
.dark .form-label{color:#94a3b8;}
.form-ctrl{padding:10px 12px;border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;font-size:0.875rem;outline:none;transition:border-color 0.2s,box-shadow 0.2s;box-sizing:border-box;}
.dark .form-ctrl{background:#0f172a;border-color:#334155;color:#f1f5f9;}
.form-ctrl:focus{border-color:#10b981;box-shadow:0 0 0 3px rgba(16,185,129,0.1);}
.form-error{font-size:0.72rem;color:#dc2626;margin-top:2px;}
.btn-filter{padding:10px 20px;border-radius:10px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-weight:600;font-size:0.875rem;border:none;cursor:pointer;transition:all 0.2s;box-shadow:0 2px 8px rgba(16,185,129,0.25);}
.btn-filter:hover{transform:translateY(-1px);}

/* Select all bar */
.select-bar{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:#f0fdf4;border-radius:10px;margin-bottom:12px;border:1px solid #bbf7d0;}
.dark .select-bar{background:rgba(16,185,129,0.07);border-color:rgba(16,185,129,0.2);}
.select-bar-left{display:flex;align-items:center;gap:10px;}
.select-count{font-size:0.82rem;font-weight:600;color:#059669;}
.dark .select-count{color:#34d399;}

/* Santri list */
.santri-list{display:flex;flex-direction:column;gap:6px;max-height:440px;overflow-y:auto;padding-right:2px;}
.santri-list::-webkit-scrollbar{width:4px;}
.santri-list::-webkit-scrollbar-thumb{background:#10b981;border-radius:999px;}
.santri-item{display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;border:1.5px solid #e2e8f0;background:#fff;cursor:pointer;transition:all 0.15s;user-select:none;}
.dark .santri-item{background:#0f172a;border-color:#334155;}
.santri-item:hover{border-color:#10b981;background:#f0fdf4;}
.dark .santri-item:hover{background:rgba(16,185,129,0.06);border-color:rgba(16,185,129,0.4);}
.santri-item.selected{border-color:#10b981;background:#ecfdf5;box-shadow:0 0 0 1px #10b981;}
.dark .santri-item.selected{background:rgba(16,185,129,0.1);border-color:#10b981;}

.item-check{width:20px;height:20px;border-radius:6px;border:2px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.15s;}
.dark .item-check{background:#1e293b;border-color:#475569;}
.santri-item.selected .item-check{background:#10b981;border-color:#10b981;}

.item-avatar{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:700;color:#fff;flex-shrink:0;}
.item-name{font-size:0.875rem;font-weight:600;color:#1e293b;margin:0 0 2px;}
.dark .item-name{color:#f1f5f9;}
.item-nis{font-size:0.72rem;color:#94a3b8;font-family:monospace;margin:0;}

/* Kelas baru section */
.kelas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:8px;}
.kelas-option{padding:8px 10px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#475569;font-size:0.78rem;font-weight:600;cursor:pointer;text-align:center;transition:all 0.15s;user-select:none;}
.dark .kelas-option{background:#0f172a;border-color:#334155;color:#94a3b8;}
.kelas-option:hover{border-color:#10b981;color:#059669;background:#ecfdf5;}
.dark .kelas-option:hover{background:rgba(16,185,129,0.08);color:#34d399;border-color:#10b981;}
.kelas-option.selected{border-color:#10b981;background:#ecfdf5;color:#059669;font-weight:700;box-shadow:0 0 0 1px #10b981;}
.dark .kelas-option.selected{background:rgba(16,185,129,0.15);color:#34d399;}

.gender-tabs{display:flex;gap:6px;margin-bottom:12px;}
.gender-tab{padding:5px 16px;border-radius:8px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:0.78rem;font-weight:600;cursor:pointer;transition:all 0.15s;}
.dark .gender-tab{background:#0f172a;border-color:#334155;color:#94a3b8;}
.gender-tab.active{background:#ecfdf5;border-color:#10b981;color:#059669;}
.dark .gender-tab.active{background:rgba(16,185,129,0.1);color:#34d399;border-color:#10b981;}
.jenjang-tabs{display:flex;gap:6px;margin-bottom:10px;}
.jenjang-tab{padding:4px 12px;border-radius:7px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:0.75rem;font-weight:600;cursor:pointer;transition:all 0.15s;}
.dark .jenjang-tab{background:#0f172a;border-color:#334155;color:#94a3b8;}
.jenjang-tab.active{background:#ecfdf5;border-color:#10b981;color:#059669;}
.dark .jenjang-tab.active{background:rgba(16,185,129,0.1);color:#34d399;border-color:#10b981;}

/* Preview box */
.preview-box{padding:14px 16px;border-radius:12px;background:#f0fdf4;border:1px solid #bbf7d0;margin-top:16px;}
.dark .preview-box{background:rgba(16,185,129,0.07);border-color:rgba(16,185,129,0.2);}
.preview-title{font-size:0.75rem;font-weight:700;color:#059669;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 8px;}
.dark .preview-title{color:#34d399;}
.preview-arrow{display:flex;align-items:center;gap:8px;font-size:0.875rem;font-weight:700;color:#1e293b;margin-bottom:4px;}
.dark .preview-arrow{color:#f1f5f9;}
.preview-sub{font-size:0.78rem;color:#64748b;margin:0;}

.btn-submit{width:100%;padding:13px;border-radius:12px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-weight:700;font-size:0.9rem;border:none;cursor:pointer;transition:all 0.2s;box-shadow:0 2px 10px rgba(16,185,129,0.3);margin-top:16px;}
.btn-submit:hover{transform:translateY(-1px);box-shadow:0 4px 18px rgba(16,185,129,0.4);}
.btn-submit:disabled{opacity:0.5;cursor:not-allowed;transform:none;}

.flash-success{padding:12px 16px;background:#dcfce7;border:1px solid #86efac;color:#166534;border-radius:12px;font-size:0.85rem;margin-bottom:16px;}
.dark .flash-success{background:rgba(22,163,74,0.15);border-color:rgba(74,222,128,0.3);color:#4ade80;}
.flash-error{padding:12px 16px;background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;border-radius:12px;font-size:0.85rem;margin-bottom:16px;}
.dark .flash-error{background:rgba(239,68,68,0.12);border-color:rgba(252,165,165,0.3);color:#fca5a5;}

.empty-state{text-align:center;padding:40px 20px;color:#94a3b8;}
.empty-state svg{margin:0 auto 12px;display:block;opacity:0.35;}

.btn-back{display:inline-flex;align-items:center;gap:6px;font-size:0.8rem;color:#64748b;text-decoration:none;margin-bottom:16px;transition:color 0.15s;}
.btn-back:hover{color:#059669;}

.divider{height:1px;background:#f1f5f9;margin:20px 0;}
.dark .divider{background:#334155;}
</style>

<div class="page-bg">
<div style="max-width:1000px;margin:0 auto;">

    {{-- Banner --}}
    <div class="page-banner">
        <h1>🏫 Kelola Kelas Santri</h1>
        <p>Pindahkan kelas beberapa santri sekaligus dengan cepat</p>
        <a href="{{ route('admin.santri.index') }}" class="btn-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali ke Daftar Santri
        </a>
    </div>

    @if(session('success'))<div class="flash-success">✅ {{ session('success') }}</div>@endif
    @if($errors->any())
        <div class="flash-error">
            ❌ @foreach($errors->all() as $e) {{ $e }}@if(!$loop->last), @endif @endforeach
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;" class="main-grid">

        {{-- ── Kolom Kiri: Filter + Daftar Santri ── --}}
        <div>
            {{-- Step 1: Filter kelas asal --}}
            <div class="card">
                <div class="card-body">
                    <p class="step-label"><span class="step-num">1</span> Pilih Kelas Asal</p>
                    <form method="GET" class="filter-row">
                        <div class="form-group" style="flex:1;">
                            <label class="form-label">Kelas yang ingin dikelola</label>
                            <select name="kelas_asal" id="kelas_asal_select" class="form-ctrl" onchange="this.form.submit()">
                                <option value="">-- Pilih kelas --</option>
                                @foreach($daftarKelas as $kelas)
                                    <option value="{{ $kelas }}" {{ $kelasFilter === $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Step 2: Pilih santri --}}
            <div class="card">
                <div class="card-body">
                    <p class="step-label"><span class="step-num">2</span> Pilih Santri</p>

                    @if($santri !== null)
                        @if($santri->count() > 0)
                            {{-- Select all bar --}}
                            <div class="select-bar">
                                <div class="select-bar-left">
                                    <input type="checkbox" id="select-all" style="width:16px;height:16px;accent-color:#10b981;cursor:pointer;" onchange="toggleAll(this.checked)">
                                    <label for="select-all" style="font-size:0.82rem;font-weight:600;color:#374151;cursor:pointer;" class="dark:text-slate-300">Pilih Semua</label>
                                </div>
                                <span class="select-count" id="select-count">0 / {{ $santri->count() }} dipilih</span>
                            </div>

                            <div class="santri-list" id="santri-list">
                                @foreach($santri as $s)
                                <div class="santri-item" onclick="toggleItem(this)" data-nis="{{ $s->nis }}">
                                    <div class="item-check">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="white" style="width:12px;height:12px;display:none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                        </svg>
                                    </div>
                                    <div class="item-avatar">{{ strtoupper(substr($s->nama, 0, 1)) }}</div>
                                    <div>
                                        <p class="item-name">{{ $s->nama }}</p>
                                        <p class="item-nis">{{ $s->nis }} • {{ $s->kelas }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:44px;height:44px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                <p style="font-weight:600;margin:0 0 4px;">Tidak ada santri aktif di kelas ini</p>
                                <p style="font-size:0.78rem;margin:0;">Coba pilih kelas lain</p>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:44px;height:44px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            <p style="font-weight:600;margin:0 0 4px;">Pilih kelas asal terlebih dahulu</p>
                            <p style="font-size:0.78rem;margin:0;">Daftar santri akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Kolom Kanan: Kelas Tujuan + Form Submit ── --}}
        <div>
            <div class="card" style="position:sticky;top:20px;">
                <div class="card-body">
                    <p class="step-label"><span class="step-num">3</span> Pilih Kelas Tujuan</p>

                    {{-- Gender tabs --}}
                    <div class="gender-tabs" id="gender-tabs">
                        <button type="button" class="gender-tab active" onclick="switchGender('PA', this)">PA (Putra)</button>
                        <button type="button" class="gender-tab" onclick="switchGender('PI', this)">PI (Putri)</button>
                    </div>

                    {{-- Jenjang tabs --}}
                    <div class="jenjang-tabs" id="jenjang-tabs">
                        <button type="button" class="jenjang-tab active" onclick="switchJenjang('Reguler', this)">Reguler</button>
                        <button type="button" class="jenjang-tab" onclick="switchJenjang('Tahfidz', this)">Tahfidz</button>
                    </div>

                    {{-- Kelas grid --}}
                    <div class="kelas-grid" id="kelas-grid"></div>

                    <div class="divider"></div>
                    <p class="step-label"><span class="step-num">4</span> Catatan & Simpan</p>

                    <form id="form-pindah" action="{{ route('admin.santri.kelola-kelas.update') }}" method="POST">
                        @csrf
                        <div id="nis-inputs"></div>
                        <input type="hidden" name="kelas_baru" id="input-kelas-baru">

                        <div class="form-group" style="margin-bottom:12px;">
                            <label class="form-label">Catatan Perubahan Kelas <span style="color:#dc2626;">*</span></label>
                            <input type="text" name="catatan_kelas" id="input-catatan" required class="form-ctrl"
                                placeholder="Misal: Naik kelas tahun ajaran 1446-1447 H"
                                value="{{ old('catatan_kelas') }}">
                            @error('catatan_kelas')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        {{-- Preview --}}
                        <div class="preview-box" id="preview-box" style="display:none;">
                            <p class="preview-title">Preview Perubahan</p>
                            <div class="preview-arrow">
                                <span id="preview-asal" style="padding:3px 10px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:0.8rem;">-</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#10b981" style="width:16px;height:16px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                <span id="preview-tujuan" style="padding:3px 10px;background:#dcfce7;color:#166534;border-radius:6px;font-size:0.8rem;">-</span>
                            </div>
                            <p class="preview-sub" id="preview-jumlah">0 santri akan dipindah</p>
                        </div>

                        <button type="button" class="btn-submit" id="btn-submit" disabled onclick="submitForm()">
                            Pindahkan Kelas
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
@media (max-width: 640px) {
    .main-grid { grid-template-columns: 1fr !important; }
}
</style>

<script>
const KELAS = @json($daftarKelas);
const KELAS_ASAL = '{{ $kelasFilter ?? '' }}';

let selectedNis   = new Set();
let selectedKelas = '';
let currentGender  = 'PA';
let currentJenjang = 'Reguler';

// ── Render kelas grid ──────────────────────────────────────────────────────
function renderKelasGrid() {
    const grid  = document.getElementById('kelas-grid');
    // Filter flat array by gender and jenjang
    const list = KELAS.filter(k => {
        const isPA = k.startsWith('PA');
        const isPI = k.startsWith('PI');
        const isTahfidz = k.includes('TAHFIDZ');
        if (currentGender === 'PA' && !isPA) return false;
        if (currentGender === 'PI' && !isPI) return false;
        if (currentJenjang === 'Tahfidz' && !isTahfidz) return false;
        if (currentJenjang === 'Reguler' && isTahfidz) return false;
        return true;
    });
    grid.innerHTML = '';
    list.forEach(k => {
        const div = document.createElement('div');
        div.className = 'kelas-option' + (selectedKelas === k ? ' selected' : '');
        div.textContent = k;
        div.onclick = () => selectKelas(k, div);
        grid.appendChild(div);
    });
}

function switchGender(g, el) {
    currentGender = g;
    document.querySelectorAll('.gender-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    selectedKelas = '';
    renderKelasGrid();
    updatePreview();
}

function switchJenjang(j, el) {
    currentJenjang = j;
    document.querySelectorAll('.jenjang-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    selectedKelas = '';
    renderKelasGrid();
    updatePreview();
}

function selectKelas(kelas, el) {
    selectedKelas = kelas;
    document.querySelectorAll('.kelas-option').forEach(k => k.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('input-kelas-baru').value = kelas;
    updatePreview();
    updateSubmitBtn();
}

// ── Santri selection ───────────────────────────────────────────────────────
function toggleItem(el) {
    const nis = el.dataset.nis;
    const check = el.querySelector('.item-check svg');
    if (selectedNis.has(nis)) {
        selectedNis.delete(nis);
        el.classList.remove('selected');
        check.style.display = 'none';
    } else {
        selectedNis.add(nis);
        el.classList.add('selected');
        check.style.display = 'block';
    }
    updateCount();
    updatePreview();
    updateSubmitBtn();
    // sync select-all checkbox
    const total = document.querySelectorAll('.santri-item').length;
    document.getElementById('select-all').checked = selectedNis.size === total;
}

function toggleAll(checked) {
    document.querySelectorAll('.santri-item').forEach(el => {
        const nis   = el.dataset.nis;
        const check = el.querySelector('.item-check svg');
        if (checked) {
            selectedNis.add(nis);
            el.classList.add('selected');
            check.style.display = 'block';
        } else {
            selectedNis.delete(nis);
            el.classList.remove('selected');
            check.style.display = 'none';
        }
    });
    updateCount();
    updatePreview();
    updateSubmitBtn();
}

function updateCount() {
    const el = document.getElementById('select-count');
    if (el) {
        const total = document.querySelectorAll('.santri-item').length;
        el.textContent = `${selectedNis.size} / ${total} dipilih`;
    }
}

// ── Preview ────────────────────────────────────────────────────────────────
function updatePreview() {
    const box = document.getElementById('preview-box');
    if (selectedNis.size > 0 && selectedKelas) {
        document.getElementById('preview-asal').textContent   = KELAS_ASAL || 'Kelas asal';
        document.getElementById('preview-tujuan').textContent = selectedKelas;
        document.getElementById('preview-jumlah').textContent = `${selectedNis.size} santri akan dipindah`;
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
}

// ── Submit button ──────────────────────────────────────────────────────────
function updateSubmitBtn() {
    const btn = document.getElementById('btn-submit');
    btn.disabled = selectedNis.size === 0 || !selectedKelas;
    if (!btn.disabled) {
        btn.textContent = `Pindahkan ${selectedNis.size} Santri ke ${selectedKelas}`;
    } else {
        btn.textContent = 'Pindahkan Kelas';
    }
}

function submitForm() {
    const catatan = document.getElementById('input-catatan').value.trim();
    if (!catatan) {
        document.getElementById('input-catatan').focus();
        document.getElementById('input-catatan').style.borderColor = '#dc2626';
        return;
    }
    if (selectedNis.size === 0) { alert('Pilih minimal 1 santri!'); return; }
    if (!selectedKelas)         { alert('Pilih kelas tujuan!'); return; }

    // Build hidden inputs
    const container = document.getElementById('nis-inputs');
    container.innerHTML = '';
    selectedNis.forEach(nis => {
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'nis[]'; inp.value = nis;
        container.appendChild(inp);
    });

    document.getElementById('form-pindah').submit();
}

// ── Init ───────────────────────────────────────────────────────────────────
renderKelasGrid();

// Set gender/jenjang tab sesuai kelas asal jika ada
@if($kelasFilter)
    const asalUpper = '{{ strtoupper($kelasFilter ?? '') }}';
    if (asalUpper.startsWith('PI')) {
        currentGender = 'PI';
        document.querySelectorAll('.gender-tab').forEach((t,i) => t.classList.toggle('active', i===1));
    }
    if (asalUpper.includes('TAHFIDZ')) {
        currentJenjang = 'Tahfidz';
        document.querySelectorAll('.jenjang-tab').forEach((t,i) => t.classList.toggle('active', i===1));
    }
    renderKelasGrid();
@endif
</script>
</x-app-layout>