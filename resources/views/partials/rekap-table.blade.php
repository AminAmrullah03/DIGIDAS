@foreach ($rekap as $i => $a)
    @php
        $status = strtolower($a['status'] ?? '');
        $badge = match (true) {
            str_contains($status, 'hadir') => 'badge-hadir',
            str_contains($status, 'izin') => 'badge-izin',
            str_contains($status, 'sakit') => 'badge-sakit',
            str_contains($status, 'alpha') => 'badge-alpha',
            default => 'badge-default'
        };

        $waktu = $a['waktu'] ? \Carbon\Carbon::parse($a['waktu'])->setTimezone('Asia/Jakarta')->format('H:i:s') : '-';
    @endphp
    <tr data-nis="{{ $a['nis'] }}">
        <td>{{ $i + 1 }}</td>
        <td>{{ $a['nis'] }}</td>
        <td>{{ $a['nama'] }}</td>
        <td>{{ $a['kelas'] }}</td>
        <td>{{ $a['kegiatan'] }}</td>
        <td>{{ $waktu }}</td>
        <td>
            <span class="status-badge badge {{ $badge }}">
                {{ ucfirst($a['status']) }}
            </span>
        </td>
        <td>
            <select class="status-select" data-nis="{{ $a['nis'] }}" data-current="{{ $a['status'] }}">
                <option value="" disabled selected>Edit</option>
                <option value="Hadir" {{ $a['status'] == 'Hadir' ? 'disabled' : '' }}>Hadir</option>
                <option value="Izin" {{ $a['status'] == 'Izin' ? 'disabled' : '' }}>Izin</option>
                <option value="Sakit" {{ $a['status'] == 'Sakit' ? 'disabled' : '' }}>Sakit</option>
                <option value="Alpha" {{ $a['status'] == 'Alpha' ? 'disabled' : '' }}>Alpha</option>
            </select>
        </td>
    </tr>
@endforeach
