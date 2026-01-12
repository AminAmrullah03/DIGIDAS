<?php

namespace Database\Seeders;

use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WaliSantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Password default: nis santri (misal NIS 250103008, password = 250103008)
     */
    public function run(): void
    {
        $santriList = Santri::all();
        $count = 0;

        foreach ($santriList as $santri) {
            // Cek apakah sudah ada akun wali untuk NIS ini
            $exists = WaliSantri::where('nis', $santri->nis)->exists();
            
            if (!$exists) {
                WaliSantri::create([
                    'nis' => $santri->nis,
                    'nama_wali' => 'Wali ' . $santri->nama,
                    'no_hp' => null,
                    'password' => Hash::make($santri->nis), // Password = NIS
                    'hubungan' => 'Orang Tua',
                ]);
                $count++;
            }
        }

        $this->command->info("✅ Berhasil membuat {$count} akun wali santri.");
        $this->command->info("📌 Login: NIS santri | Password: NIS santri");
    }
}
