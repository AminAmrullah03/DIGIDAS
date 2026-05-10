<?php

use App\Models\Izin;
use App\Models\Santri;
use App\Models\User;

it('mencatat santri kembali dari tombol rekap berbasis id izin', function () {
    $user = User::factory()->create(['role' => User::ROLE_GURU]);
    $santri = Santri::create([
        'nis' => '20260001',
        'nama' => 'Ahmad',
        'kelas' => 'PA 1A',
    ]);
    $izin = Izin::create([
        'nis' => $santri->nis,
        'keperluan' => 'Pulang',
        'waktu_keluar' => now('Asia/Jakarta')->subHour(),
        'status' => 'Belum Kembali',
    ]);

    $this->actingAs($user)
        ->postJson(route('izin.kembaliById', $izin))
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.id', $izin->id)
        ->assertJsonPath('data.status', 'Sudah Kembali');

    $this->assertDatabaseHas('izin', [
        'id' => $izin->id,
        'status' => 'Sudah Kembali',
    ]);
    expect($izin->fresh()->waktu_kembali)->not->toBeNull();
});

it('mencatat santri kembali dari halaman input berbasis nis', function () {
    $user = User::factory()->create(['role' => User::ROLE_GURU]);
    $santri = Santri::create([
        'nis' => '20260002',
        'nama' => 'Fatimah',
        'kelas' => 'PI 1A',
    ]);
    Izin::create([
        'nis' => $santri->nis,
        'keperluan' => 'Berobat',
        'waktu_keluar' => now('Asia/Jakarta')->subMinutes(30),
        'status' => 'Belum Kembali',
    ]);

    $this->actingAs($user)
        ->postJson(route('izin.kembali'), ['nis' => $santri->nis])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.status', 'Sudah Kembali');

    $this->assertDatabaseHas('izin', [
        'nis' => $santri->nis,
        'status' => 'Sudah Kembali',
    ]);
});

it('mencatat keterlambatan ketika santri scan kembali lewat tenggat', function () {
    $user = User::factory()->create(['role' => User::ROLE_GURU]);
    $santri = Santri::create([
        'nis' => '20260003',
        'nama' => 'Zaid',
        'kelas' => 'PA 2A',
    ]);
    Izin::create([
        'nis' => $santri->nis,
        'keperluan' => 'Ke klinik',
        'durasi_menit' => 30,
        'waktu_keluar' => now('Asia/Jakarta')->subHour(),
        'batas_waktu_kembali' => now('Asia/Jakarta')->subMinutes(30),
        'status' => 'Belum Kembali',
    ]);

    $this->actingAs($user)
        ->postJson(route('izin.kembali'), ['nis' => $santri->nis])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.status', 'Terlambat');

    $this->assertDatabaseHas('izin', [
        'nis' => $santri->nis,
        'status' => 'Terlambat',
    ]);
    expect(Izin::where('nis', $santri->nis)->first()->terlambat_menit)->toBeGreaterThan(0);
});

it('menandai kabur otomatis jika tidak kembali lebih dari satu hari', function () {
    $user = User::factory()->create(['role' => User::ROLE_GURU]);
    $santri = Santri::create([
        'nis' => '20260004',
        'nama' => 'Hasan',
        'kelas' => 'PA 3A',
    ]);
    Izin::create([
        'nis' => $santri->nis,
        'keperluan' => 'Pulang',
        'durasi_menit' => 60,
        'waktu_keluar' => now('Asia/Jakarta')->subDay()->subMinute(),
        'batas_waktu_kembali' => now('Asia/Jakarta')->subDay()->addHour(),
        'status' => 'Belum Kembali',
    ]);

    $this->actingAs($user)
        ->getJson(route('izin.santri', ['nis' => $santri->nis]))
        ->assertOk()
        ->assertJsonPath('izin_aktif', null)
        ->assertJsonPath('izin_terakhir.status', 'Kabur');

    $this->assertDatabaseHas('izin', [
        'nis' => $santri->nis,
        'status' => 'Kabur',
    ]);
});
