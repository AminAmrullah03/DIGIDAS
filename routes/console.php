<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Artisan;
use App\Models\Izin;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('izin:tandai-kabur', function () {
    $count = Izin::where('status', Izin::STATUS_BELUM_KEMBALI)
        ->where('waktu_keluar', '<=', now('Asia/Jakarta')->subDay())
        ->update([
            'status' => Izin::STATUS_KABUR,
            'keterangan' => 'Otomatis tercatat Kabur karena tidak kembali lebih dari 1 hari.',
        ]);

    $this->info("{$count} izin keluar ditandai Kabur.");
})->purpose('Tandai izin keluar sebagai Kabur setelah lebih dari 1 hari belum kembali');

Schedule::command('izin:tandai-kabur')->everyMinute();
