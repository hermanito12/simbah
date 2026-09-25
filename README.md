# SIMBAH

SIMBAH adalah aplikasi web untuk membantu pengelolaan bank sampah pada tingkat kelurahan dan pos bank sampah.

## Fitur Utama

- Login dan akses berdasarkan role: Admin, Pengurus, Nasabah, dan Kelurahan.
- Pengelolaan unit atau pos bank sampah.
- Pengelolaan akun dan nasabah.
- Master jenis sampah dan kategori.
- Pengaturan harga pengepul dan harga untuk nasabah per unit.
- Pencatatan setoran dengan beberapa detail jenis sampah.
- Saldo tabungan dan pencatatan penarikan.
- Riwayat transaksi dan rekap per periode.
- Isolasi data antar-unit untuk pengurus.

## Teknologi

- PHP 8.3+
- Laravel 13
- MySQL
- Blade dan Bootstrap 5
- Vite dan JavaScript

## Persiapan

Pastikan perangkat sudah memiliki:

- PHP dan ekstensi database yang sesuai
- Composer
- Node.js dan npm

## Instalasi Lokal

Di PowerShell, jalankan dari folder project:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Buka `http://localhost:8000` di browser.

Untuk pengembangan frontend dengan hot reload:

```powershell
npm run dev
```

Pastikan database MySQL `simbah_kelurahan` sudah dibuat, lalu sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env` sebelum menjalankan migration.

## Akun Demo Lokal

Seeder menyediakan akun demo berikut. Semua akun demo memakai password awal `password` dan hanya boleh digunakan untuk pengembangan atau presentasi lokal.

| Role            | Username    |
| --------------- | ----------- |
| Admin           | `admin`     |
| Kelurahan       | `kelurahan` |
| Pengurus Unit A | `pengurus`  |
| Pengurus Unit B | `pengurusb` |
| Nasabah Unit A  | `a001`      |
| Nasabah Unit B  | `b001`      |

Ganti seluruh password demo sebelum deployment atau penggunaan dengan data nyata.

## Pengujian

```powershell
php artisan test
```

## Catatan Keamanan

- Jangan commit `.env`, credential database, API key, atau secret deployment.
- Gunakan `APP_DEBUG=false` pada environment production.
- File `vendor`, `node_modules`, cache, log, dan hasil build lokal sudah dikecualikan melalui `.gitignore`.
- Jangan menggunakan password demo untuk production.

## Struktur Penting

```text
app/                 Logic aplikasi, controller, model, middleware
database/migrations/ Struktur tabel database
database/seeders/    Data demo lokal
resources/views/     Template Blade
routes/web.php       Route aplikasi
tests/               Test otomatis
```
