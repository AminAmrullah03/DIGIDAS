<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->ensureTahunAjaranRows();

        if (! Schema::hasColumn('spp_tagihan', 'tahun_ajaran_id')) {
            Schema::table('spp_tagihan', function (Blueprint $table) {
                $table->foreignId('tahun_ajaran_id')->nullable()->after('nis')->constrained('tahun_ajaran');
            });
        }

        if (! Schema::hasColumn('spp_pembayaran', 'tahun_ajaran_id')) {
            Schema::table('spp_pembayaran', function (Blueprint $table) {
                $table->foreignId('tahun_ajaran_id')->nullable()->after('nis')->constrained('tahun_ajaran');
            });
        }

        $this->mapTahunAjaranId('spp_tagihan');
        $this->mapTahunAjaranId('spp_pembayaran');

        if (Schema::hasColumn('spp_tagihan', 'tahun')) {
            // Drop unique index dulu dalam statement terpisah — MySQL tidak
            // mengizinkan drop index dan drop column dalam satu ALTER TABLE
            // ketika index tersebut masih direferensikan secara internal.
            try {
                Schema::table('spp_tagihan', function (Blueprint $table) {
                    $table->dropUnique('spp_tagihan_nis_bulan_tahun_unique');
                });
            } catch (Throwable $e) {
                // Constraint may already be gone on databases fixed manually.
            }

            // Baru drop column setelah index sudah hilang
            Schema::table('spp_tagihan', function (Blueprint $table) {
                $table->dropColumn('tahun');
            });
        }

        try {
            Schema::table('spp_tagihan', function (Blueprint $table) {
                $table->unique(['nis', 'bulan', 'tahun_ajaran_id'], 'spp_tagihan_nis_bulan_tahun_ajaran_unique');
            });
        } catch (Throwable $e) {
            // Index may already exist on databases fixed manually.
        }

        if (Schema::hasColumn('spp_pembayaran', 'tahun')) {
            Schema::table('spp_pembayaran', function (Blueprint $table) {
                $table->dropColumn('tahun');
            });
        }
    }

    public function down(): void
    {
        Schema::table('spp_tagihan', function (Blueprint $table) {
            try {
                $table->dropUnique('spp_tagihan_nis_bulan_tahun_ajaran_unique');
            } catch (Throwable $e) {
                // Ignore missing index.
            }

            if (! Schema::hasColumn('spp_tagihan', 'tahun')) {
                $table->smallInteger('tahun')->after('bulan')->default(1446);
            }

            if (Schema::hasColumn('spp_tagihan', 'tahun_ajaran_id')) {
                $table->dropForeign(['tahun_ajaran_id']);
                $table->dropColumn('tahun_ajaran_id');
            }

            try {
                $table->unique(['nis', 'bulan', 'tahun']);
            } catch (Throwable $e) {
                // Ignore existing index.
            }
        });

        Schema::table('spp_pembayaran', function (Blueprint $table) {
            if (! Schema::hasColumn('spp_pembayaran', 'tahun')) {
                $table->smallInteger('tahun')->after('bulan')->default(1446);
            }

            if (Schema::hasColumn('spp_pembayaran', 'tahun_ajaran_id')) {
                $table->dropForeign(['tahun_ajaran_id']);
                $table->dropColumn('tahun_ajaran_id');
            }
        });
    }

    private function ensureTahunAjaranRows(): void
    {
        $years = collect();

        if (Schema::hasColumn('spp_tagihan', 'tahun')) {
            $years = $years->merge(
                DB::table('spp_tagihan')
                    ->whereNotNull('tahun')
                    ->distinct()
                    ->pluck('tahun')
            );
        }

        if (Schema::hasColumn('spp_pembayaran', 'tahun')) {
            $years = $years->merge(
                DB::table('spp_pembayaran')
                    ->whereNotNull('tahun')
                    ->distinct()
                    ->pluck('tahun')
            );
        }

        if ($years->filter()->isEmpty()) {
            $years = collect([1446]);
        }

        foreach ($years->filter()->unique()->sort()->values() as $tahunHijriah) {
            $tahunHijriah = (int) $tahunHijriah;
            $tahunMasehi = $tahunHijriah + 579;
            $isDefault = $tahunHijriah === 1446;
            $existing = DB::table('tahun_ajaran')->where('tahun_hijriah', $tahunHijriah)->first();
            $hasActive = DB::table('tahun_ajaran')->where('status', 'aktif')->exists();

            DB::table('tahun_ajaran')->updateOrInsert(
                ['tahun_hijriah' => $tahunHijriah],
                [
                    'nama' => $isDefault ? '2025/2026' : "{$tahunMasehi}/".($tahunMasehi + 1),
                    'tahun_masehi' => $tahunMasehi,
                    'tanggal_mulai' => $isDefault ? '2025-07-14' : "{$tahunMasehi}-01-01",
                    'tanggal_selesai' => $isDefault ? '2026-07-02' : "{$tahunMasehi}-12-31",
                    'nominal_spp' => 50000,
                    'status' => $existing?->status === 'aktif' || ! $hasActive ? 'aktif' : 'selesai',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function mapTahunAjaranId(string $table): void
    {
        if (! Schema::hasColumn($table, 'tahun') || ! Schema::hasColumn($table, 'tahun_ajaran_id')) {
            return;
        }

        $years = DB::table($table)
            ->whereNull('tahun_ajaran_id')
            ->whereNotNull('tahun')
            ->distinct()
            ->pluck('tahun');

        foreach ($years as $tahunHijriah) {
            $tahunAjaranId = DB::table('tahun_ajaran')
                ->where('tahun_hijriah', $tahunHijriah)
                ->value('id');

            if (! $tahunAjaranId) {
                continue;
            }

            DB::table($table)
                ->whereNull('tahun_ajaran_id')
                ->where('tahun', $tahunHijriah)
                ->update(['tahun_ajaran_id' => $tahunAjaranId]);
        }

        $fallbackId = DB::table('tahun_ajaran')
            ->where('status', 'aktif')
            ->value('id') ?? DB::table('tahun_ajaran')->orderBy('id')->value('id');

        if ($fallbackId) {
            DB::table($table)
                ->whereNull('tahun_ajaran_id')
                ->update(['tahun_ajaran_id' => $fallbackId]);
        }
    }
};