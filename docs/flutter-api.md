# Integrasi Flutter Android

Dokumen ini mencatat kontrak API Laravel untuk aplikasi Flutter Android.

## Base URL

Saat development lokal:

- Android emulator: `http://10.0.2.2:8000/api`
- HP fisik satu Wi-Fi: `http://IP-LAPTOP:8000/api`
- Web/browser lokal: `http://127.0.0.1:8000/api`

Jalankan Laravel dengan:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Setelah Sanctum dipasang, jalankan migrasi:

```bash
php artisan migrate
```

## Header Flutter

Semua request JSON sebaiknya memakai header:

```http
Accept: application/json
Content-Type: application/json
```

Untuk endpoint yang butuh login, tambahkan token:

```http
Authorization: Bearer TOKEN_DARI_LOGIN
```

## Auth

### Login

`POST /login`

Body:

```json
{
  "nip": "12345",
  "password": "password",
  "device_name": "android"
}
```

Response sukses berisi `data.token`, `data.token_type`, dan `data.user`. Simpan token di secure storage Flutter.

### User Aktif

`GET /me`

### Logout Device Ini

`POST /logout`

### Logout Semua Device

`POST /logout-all`

## Santri

Endpoint ini bisa diakses role `superadmin` dan `guru`.

- `GET /santri`
- `GET /santri?search=ahmad&kelas=PA%201A&status=aktif`
- `GET /santri/kelas`
- `GET /santri/{nis}`

## Jadwal Absen

- `GET /jadwal-absen`
- `GET /jadwal-absen?aktif=1`
- `GET /jadwal-absen?hari=1`
- `GET /jadwal-absen/current`

`hari` mengikuti ISO weekday: Senin `1` sampai Ahad `7`.

## Absensi QR

Endpoint ini bisa diakses role `superadmin` dan `guru`.

### Catat Absensi

`POST /absensi`

Body:

```json
{
  "nis": "20240001"
}
```

Backend akan otomatis mengambil jadwal aktif berdasarkan waktu server Asia/Jakarta.

### Rekap Absensi

`GET /absensi/rekap?tanggal=2026-05-02&kelas=PA%201A&jadwal_id=1`

### Ubah Status Absensi

`PATCH /absensi/status`

Body:

```json
{
  "nis": "20240001",
  "jadwal_id": 1,
  "tanggal": "2026-05-02",
  "status": "Hadir"
}
```

Status yang valid: `Hadir`, `Izin`, `Sakit`, `Alpha`.

## Izin

Endpoint ini bisa diakses role `superadmin` dan `guru`.

- `GET /izin/santri?nis=20240001`
- `POST /izin`
- `POST /izin/kembali`
- `GET /izin/rekap?tanggal=2026-05-02&status=Belum%20Kembali`
- `PATCH /izin/status`

Body buat izin:

```json
{
  "nis": "20240001",
  "keperluan": "Ke klinik"
}
```

Body kembali:

```json
{
  "nis": "20240001"
}
```

## SPP

Endpoint ini hanya bisa diakses role `superadmin`.

- `GET /spp/tagihan?nis=20240001&tahun=1446`
- `POST /spp/bayar`
- `GET /spp/riwayat?tahun=1446&period=today`

Body pembayaran:

```json
{
  "nis": "20240001",
  "tahun": 1446,
  "nominal_bayar": 50000,
  "metode": "cash",
  "keterangan": "Pembayaran dari aplikasi"
}
```

`metode` yang valid: `cash`, `transfer`.

## Format Error

Semua response API memakai envelope yang sama:

```json
{
  "success": true,
  "message": "OK",
  "data": {}
}
```

Response list biasanya menambahkan `meta.pagination`. Validasi Laravel akan mengembalikan HTTP `422` dengan field `errors`.

Role tidak sesuai akan mengembalikan:

```json
{
  "success": false,
  "message": "Akses ditolak. Anda tidak memiliki izin.",
  "data": null
}
```

Token kosong, salah, atau sudah logout akan mengembalikan HTTP `401`:

```json
{
  "success": false,
  "message": "Unauthenticated.",
  "data": null
}
```
