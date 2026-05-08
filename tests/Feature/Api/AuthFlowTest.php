<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('api login returns token payload', function () {
    $user = User::factory()->create([
        'nip' => '1987654321',
        'password' => Hash::make('secret-password'),
        'role' => User::ROLE_GURU,
    ]);

    $response = $this->postJson('/api/login', [
        'nip' => '1987654321',
        'password' => 'secret-password',
        'device_name' => 'flutter-test',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'token',
        ]);

    expect(array_keys($response->json()))->toBe(['token']);
    expect($response->json('token'))->toBeString()->not->toBeEmpty();

    $this->assertDatabaseHas('personal_access_tokens', [
        'tokenable_id' => $user->id,
        'tokenable_type' => User::class,
        'name' => 'flutter-test',
    ]);
});

test('api login validation errors use json envelope', function () {
    $response = $this->postJson('/api/login', []);

    $response->assertUnprocessable()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Validasi gagal.')
        ->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors' => ['nip', 'password'],
        ]);
});

test('api login rejects invalid credentials with json envelope', function () {
    User::factory()->create([
        'nip' => '1987654321',
        'password' => Hash::make('secret-password'),
    ]);

    $response = $this->postJson('/api/login', [
        'nip' => '1987654321',
        'password' => 'wrong-password',
        'device_name' => 'flutter-test',
    ]);

    $response->assertUnprocessable()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'NIP atau password yang Anda masukkan salah.')
        ->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors' => ['nip'],
        ]);
});

test('protected api routes require bearer token', function () {
    $response = $this->getJson('/api/me');

    $response->assertUnauthorized()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Unauthenticated.')
        ->assertJsonStructure(['success', 'message', 'data']);
});

test('authenticated user can fetch me and logout current token', function () {
    $user = User::factory()->create([
        'nip' => '1987654321',
        'password' => Hash::make('secret-password'),
    ]);

    $login = $this->postJson('/api/login', [
        'nip' => '1987654321',
        'password' => 'secret-password',
        'device_name' => 'flutter-test',
    ]);

    $token = $login->json('token');

    $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/me')
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.user.id', $user->id);

    $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson('/api/logout')
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Logout berhasil.');

    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $user->id,
        'tokenable_type' => User::class,
        'name' => 'flutter-test',
    ]);

    app('auth')->forgetGuards();

    $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/me')
        ->assertUnauthorized()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Unauthenticated.');
});

test('role middleware returns json forbidden response', function () {
    $user = User::factory()->create([
        'role' => User::ROLE_GURU,
    ]);

    $token = $user->createToken('flutter-test')->plainTextToken;

    $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/spp/tagihan')
        ->assertForbidden()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Akses ditolak. Anda tidak memiliki izin.')
        ->assertJsonStructure(['success', 'message', 'data']);
});

test('unknown api route returns json envelope', function () {
    $this->getJson('/api/tidak-ada')
        ->assertNotFound()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Endpoint tidak ditemukan.')
        ->assertJsonStructure(['success', 'message', 'data']);
});
