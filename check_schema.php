<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$checks = [];

$checks[] = ['tahun_ajaran table', Schema::hasTable('tahun_ajaran')];
$checks[] = ['santri_kelas table', Schema::hasTable('santri_kelas')];
$checks[] = ['spp_tagihan.tahun dropped', Schema::hasTable('spp_tagihan') && ! Schema::hasColumn('spp_tagihan', 'tahun')];
$checks[] = ['spp_pembayaran.tahun dropped', Schema::hasTable('spp_pembayaran') && ! Schema::hasColumn('spp_pembayaran', 'tahun')];
$checks[] = ['spp_tagihan.tahun_ajaran_id exists', Schema::hasTable('spp_tagihan') && Schema::hasColumn('spp_tagihan', 'tahun_ajaran_id')];
$checks[] = ['spp_pembayaran.tahun_ajaran_id exists', Schema::hasTable('spp_pembayaran') && Schema::hasColumn('spp_pembayaran', 'tahun_ajaran_id')];
$checks[] = ['absensi.tahun_ajaran_id exists', Schema::hasTable('absensi') && Schema::hasColumn('absensi', 'tahun_ajaran_id')];

foreach ($checks as [$label, $ok]) {
    echo sprintf("[%s] %s\n", $ok ? 'OK' : 'FAIL', $label);
}

if (Schema::hasTable('tahun_ajaran')) {
    $totalTahun = DB::table('tahun_ajaran')->count();
    $aktif = DB::table('tahun_ajaran')->where('status', 'aktif')->count();
    echo "tahun_ajaran rows: {$totalTahun}\n";
    echo "tahun_ajaran aktif: {$aktif}\n";
    echo sprintf("[%s] exactly one tahun ajaran aktif\n", $aktif === 1 ? 'OK' : 'FAIL');
}

foreach (['spp_tagihan', 'spp_pembayaran', 'absensi'] as $table) {
    if (Schema::hasTable($table) && Schema::hasColumn($table, 'tahun_ajaran_id')) {
        $nulls = DB::table($table)->whereNull('tahun_ajaran_id')->count();
        echo "{$table} null tahun_ajaran_id: {$nulls}\n";
        echo sprintf("[%s] {$table} tahun_ajaran_id complete\n", $nulls === 0 ? 'OK' : 'FAIL');
    }
}

if (Schema::hasTable('santri_kelas')) {
    echo 'santri_kelas rows: ' . DB::table('santri_kelas')->count() . "\n";
}
