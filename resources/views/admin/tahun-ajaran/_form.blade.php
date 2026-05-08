@php $m = $model ?? null; @endphp

<div class="form-grid">
    <div class="form-group span-2">
        <label class="form-label">Nama Tahun Ajaran <span>*</span></label>
        <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15A1.5 1.5 0 0121 6.75v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12A1.5 1.5 0 014.5 5.25z"/>
            </svg>
            <input type="text" name="nama" value="{{ old('nama', $m?->nama) }}" placeholder="Contoh: 2025/2026" class="form-ctrl @error('nama') is-error @enderror">
        </div>
        @error('nama')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label class="form-label">Tahun Hijriah <span>*</span></label>
        <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <input type="number" name="tahun_hijriah" value="{{ old('tahun_hijriah', $m?->tahun_hijriah) }}" placeholder="1447" class="form-ctrl @error('tahun_hijriah') is-error @enderror">
        </div>
        @error('tahun_hijriah')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label class="form-label">Tahun Masehi <span>*</span></label>
        <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m4-4H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <input type="number" name="tahun_masehi" value="{{ old('tahun_masehi', $m?->tahun_masehi) }}" placeholder="2026" class="form-ctrl @error('tahun_masehi') is-error @enderror">
        </div>
        @error('tahun_masehi')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label class="form-label">Tanggal Mulai <span>*</span></label>
        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $m?->tanggal_mulai?->format('Y-m-d')) }}" class="form-ctrl no-icon @error('tanggal_mulai') is-error @enderror">
        @error('tanggal_mulai')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label class="form-label">Tanggal Selesai <span>*</span></label>
        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $m?->tanggal_selesai?->format('Y-m-d')) }}" class="form-ctrl no-icon @error('tanggal_selesai') is-error @enderror">
        @error('tanggal_selesai')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group span-2">
        <label class="form-label">Nominal SPP per Bulan <span>*</span></label>
        <div class="input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m3-9.75H9.75a2.25 2.25 0 000 4.5h4.5a2.25 2.25 0 010 4.5H8.25"/>
            </svg>
            <input type="number" name="nominal_spp" value="{{ old('nominal_spp', $m?->nominal_spp ?? 50000) }}" min="1000" step="500" class="form-ctrl @error('nominal_spp') is-error @enderror">
        </div>
        <p class="form-help">Nominal ini dipakai saat membuat tagihan SPP. Jika tagihan sudah dibuat, nominal tidak bisa diubah.</p>
        @error('nominal_spp')<p class="form-error">{{ $message }}</p>@enderror
    </div>
</div>
