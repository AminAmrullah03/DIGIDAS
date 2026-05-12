<?php

use App\Models\Perpulangan;
use App\Models\PerpulanganApproval;
use App\Models\Santri;
use App\Models\User;

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
