<?php

use App\Models\Perpulangan;
use App\Models\PerpulanganApproval;
use App\Models\PerpulanganSantri;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Support\Carbon;

function createPerpulanganFixture(): array
{
    $santri = Santri::create([
        'nis' => '240001',
        'nama' => 'Ahmad Fulan',
        'kelas' => 'PA 1A',
        'gender' => 'L',
        'jenjang' => 'SMP',
        'status' => 'aktif',
    ]);

    $event = Perpulangan::create([
        'nama_event' => 'Perpulangan Tes',
        'tanggal_mulai' => now()->toDateString(),
        'batas_kembali' => now()->addDays(7)->toDateString(),
        'status' => Perpulangan::STATUS_AKTIF,
    ]);

    $event->daftarkanSemuaSantri();

    return [$santri, $event];
}

test('halaman web scan perpulangan bisa memakai session web tanpa bearer token', function () {
    [$santri] = createPerpulanganFixture();

    $user = User::factory()->create(['role' => User::ROLE_GURU]);

    $this->actingAs($user)
        ->getJson("/perpulangan/ajax/scan/{$santri->nis}")
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.nis', $santri->nis)
        ->assertJsonPath('data.nama', $santri->nama);
});

test('approval musrif dari halaman web tersimpan dengan user session', function () {
    [$santri] = createPerpulanganFixture();

    $user = User::factory()->create(['role' => User::ROLE_GURU]);

    $this->actingAs($user)
        ->postJson('/perpulangan/ajax/approve/musrif', [
            'nis' => $santri->nis,
            'catatan' => 'Lengkap',
        ])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.approvals.musrif.approved_by', $user->name);

    $this->assertDatabaseHas('perpulangan_approvals', [
        'approval_type' => 'musrif',
        'approved_by' => $user->id,
        'catatan' => 'Lengkap',
    ]);

    expect(PerpulanganApproval::where('approval_type', 'musrif')->count())->toBe(1);
});

test('approval spp web tetap hanya untuk superadmin', function () {
    [$santri] = createPerpulanganFixture();

    $guru = User::factory()->create(['role' => User::ROLE_GURU]);
    $superadmin = User::factory()->create(['role' => User::ROLE_SUPERADMIN]);

    $this->actingAs($guru)
        ->postJson('/perpulangan/ajax/approve/spp', ['nis' => $santri->nis])
        ->assertForbidden();

    $this->actingAs($superadmin)
        ->postJson('/perpulangan/ajax/approve/spp', ['nis' => $santri->nis])
        ->assertOk()
        ->assertJsonPath('success', true);
});

test('scan web otomatis mendaftarkan santri aktif yang belum masuk event', function () {
    $santri = Santri::create([
        'nis' => '240002',
        'nama' => 'Zaid Fulan',
        'kelas' => 'PA 1B',
        'gender' => 'L',
        'jenjang' => 'SMP',
        'status' => 'aktif',
    ]);

    $event = Perpulangan::create([
        'nama_event' => 'Perpulangan Tanpa Peserta',
        'tanggal_mulai' => now()->toDateString(),
        'batas_kembali' => now()->addDays(7)->toDateString(),
        'status' => Perpulangan::STATUS_AKTIF,
    ]);

    expect(PerpulanganSantri::where('perpulangan_id', $event->id)->count())->toBe(0);

    $user = User::factory()->create(['role' => User::ROLE_GURU]);

    $this->actingAs($user)
        ->getJson("/perpulangan/ajax/scan/{$santri->nis}")
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.nis', $santri->nis)
        ->assertJsonPath('data.status', PerpulanganSantri::STATUS_MENUNGGU);

    $this->assertDatabaseHas('perpulangan_santri', [
        'perpulangan_id' => $event->id,
        'nis' => $santri->nis,
        'status' => PerpulanganSantri::STATUS_MENUNGGU,
    ]);
});

test('tiga approval perpulangan tetap berjalan walau peserta event belum tersinkron', function () {
    $santri = Santri::create([
        'nis' => '240003',
        'nama' => 'Umar Fulan',
        'kelas' => 'PA 2A',
        'gender' => 'L',
        'jenjang' => 'SMP',
        'status' => 'aktif',
    ]);

    Perpulangan::create([
        'nama_event' => 'Perpulangan Approval',
        'tanggal_mulai' => now()->toDateString(),
        'batas_kembali' => now()->addDays(7)->toDateString(),
        'status' => Perpulangan::STATUS_AKTIF,
    ]);

    $guru = User::factory()->create(['role' => User::ROLE_GURU]);
    $superadmin = User::factory()->create(['role' => User::ROLE_SUPERADMIN]);

    $this->actingAs($guru)
        ->postJson('/perpulangan/ajax/approve/musrif', ['nis' => $santri->nis])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.status', PerpulanganSantri::STATUS_SEBAGIAN);

    $this->actingAs($superadmin)
        ->postJson('/perpulangan/ajax/approve/spp', ['nis' => $santri->nis])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.status', PerpulanganSantri::STATUS_DIIZINKAN);

    $this->actingAs($guru)
        ->postJson('/perpulangan/ajax/approve/keamanan', ['nis' => $santri->nis])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.status', PerpulanganSantri::STATUS_KELUAR);

    $this->assertDatabaseHas('perpulangan_approvals', [
        'approval_type' => 'musrif',
        'approved_by' => $guru->id,
    ]);

    $this->assertDatabaseHas('perpulangan_approvals', [
        'approval_type' => 'spp',
        'approved_by' => $superadmin->id,
    ]);

    $this->assertDatabaseHas('perpulangan_approvals', [
        'approval_type' => 'keamanan',
        'approved_by' => $guru->id,
    ]);
});

test('approval perpulangan ditolak sebelum hari perpulangan', function () {
    Carbon::setTestNow(now()->startOfDay());

    $santri = Santri::create([
        'nis' => '240004',
        'nama' => 'Ali Fulan',
        'kelas' => 'PA 2B',
        'gender' => 'L',
        'jenjang' => 'SMP',
        'status' => 'aktif',
    ]);

    Perpulangan::create([
        'nama_event' => 'Perpulangan Besok',
        'tanggal_mulai' => now()->addDay()->toDateString(),
        'batas_kembali' => now()->addDays(3)->toDateString(),
        'status' => Perpulangan::STATUS_AKTIF,
    ]);

    $user = User::factory()->create(['role' => User::ROLE_GURU]);

    $this->actingAs($user)
        ->postJson('/perpulangan/ajax/approve/musrif', ['nis' => $santri->nis])
        ->assertStatus(422);

    Carbon::setTestNow();
});

test('scan kembali tidak wajib pernah scan keluar dan menandai terlambat jika lewat batas kembali', function () {
    Carbon::setTestNow(now()->startOfDay());

    $santri = Santri::create([
        'nis' => '240005',
        'nama' => 'Bilal Fulan',
        'kelas' => 'PA 3A',
        'gender' => 'L',
        'jenjang' => 'SMP',
        'status' => 'aktif',
    ]);

    $event = Perpulangan::create([
        'nama_event' => 'Perpulangan Kembali',
        'tanggal_mulai' => now()->subDays(2)->toDateString(),
        'batas_kembali' => now()->subDay()->toDateString(),
        'status' => Perpulangan::STATUS_AKTIF,
    ]);

    $event->daftarkanSemuaSantri();

    $user = User::factory()->create(['role' => User::ROLE_GURU]);

    $this->actingAs($user)
        ->postJson('/perpulangan/ajax/kembali', ['nis' => $santri->nis])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.status', PerpulanganSantri::STATUS_TERLAMBAT_KEMBALI);

    Carbon::setTestNow();
});

test('sinkron status menandai semua santri yang belum scan kembali sebagai terlambat', function () {
    Carbon::setTestNow(now()->startOfDay());

    $santri = Santri::create([
        'nis' => '240006',
        'nama' => 'Hamzah Fulan',
        'kelas' => 'PA 3B',
        'gender' => 'L',
        'jenjang' => 'SMP',
        'status' => 'aktif',
    ]);

    $event = Perpulangan::create([
        'nama_event' => 'Perpulangan Sinkron Kembali',
        'tanggal_mulai' => now()->subDays(4)->toDateString(),
        'batas_kembali' => now()->subDay()->toDateString(),
        'status' => Perpulangan::STATUS_AKTIF,
    ]);

    $event->daftarkanSemuaSantri();
    $event->sinkronkanStatusOtomatis();

    $this->assertDatabaseHas('perpulangan_santri', [
        'perpulangan_id' => $event->id,
        'nis' => $santri->nis,
        'status' => PerpulanganSantri::STATUS_TERLAMBAT_KEMBALI,
    ]);

    Carbon::setTestNow();
});
