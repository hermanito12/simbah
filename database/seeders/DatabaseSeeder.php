<?php

namespace Database\Seeders;

use App\Models\Nasabah;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin',
            'email' => 'admin@simbah.internal',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kelurahan',
            'username' => 'kelurahan',
            'email' => 'kelurahan@simbah.internal',
            'password' => Hash::make('password'),
            'role' => 'kelurahan',
        ]);

        // Unit A
        $unit = Unit::create([
            'nama_unit' => 'Bank Sampah RW 01',
            'tingkat' => 'RW',
            'alamat' => 'Jl. Mawar No. 5',
            'status' => 'aktif',
        ]);

        $pengurus = User::create([
            'name' => 'Pengurus Unit A',
            'username' => 'pengurus',
            'email' => 'pengurus@simbah.internal',
            'password' => Hash::make('password'),
            'role' => 'pengurus',
            'unit_id' => $unit->id,
        ]);

        $userNasabah = User::create([
            'name' => 'Budi Nasabah',
            'username' => 'a001',
            'email' => 'nasabah@simbah.internal',
            'password' => Hash::make('password'),
            'role' => 'nasabah',
            'unit_id' => $unit->id,
        ]);

        Nasabah::create([
            'unit_id' => $unit->id,
            'user_id' => $userNasabah->id,
            'nomor_induk' => 'A001',
            'nama' => 'Budi Nasabah',
            'alamat' => 'Jl. Melati No. 10',
            'status' => 'aktif',
        ]);

        $kardus = \App\Models\JenisSampah::create(['nama' => 'Kardus', 'kategori' => 'Kertas', 'satuan' => 'kg']);
        $petBening = \App\Models\JenisSampah::create(['nama' => 'PET bening', 'kategori' => 'Plastik', 'satuan' => 'kg']);
        \App\Models\JenisSampah::create(['nama' => 'Kaleng', 'kategori' => 'Logam', 'satuan' => 'kg']);

        \App\Models\HargaSampah::create([
            'unit_id' => $unit->id,
            'jenis_sampah_id' => $kardus->id,
            'harga_pengepul' => 2000,
            'harga_nasabah' => 1800,
            'tanggal_mulai' => now()->subDays(10),
        ]);

        \App\Models\HargaSampah::create([
            'unit_id' => $unit->id,
            'jenis_sampah_id' => $petBening->id,
            'harga_pengepul' => 3500,
            'harga_nasabah' => 3000,
            'tanggal_mulai' => now()->subDays(10),
        ]);

        \App\Models\Tabungan::create([
            'nasabah_id' => \App\Models\Nasabah::where('nomor_induk', 'A001')->first()->id,
            'jenis' => 'masuk',
            'nominal' => 20000,
            'keterangan' => 'Saldo awal (demo)',
            'tanggal' => now()->subDays(5),
        ]);

        // Unit B — untuk demo bukti multi-tenant isolation
        $unitB = \App\Models\Unit::create([
            'nama_unit' => 'Bank Sampah RT 03',
            'tingkat' => 'RT',
            'alamat' => 'Jl. Anggrek No. 8',
            'status' => 'aktif',
        ]);

        $pengurusB = \App\Models\User::create([
            'name' => 'Pengurus Unit B',
            'username' => 'pengurusb',
            'email' => 'pengurusb@simbah.internal',
            'password' => Hash::make('password'),
            'role' => 'pengurus',
            'unit_id' => $unitB->id,
        ]);

        $userNasabahB = \App\Models\User::create([
            'name' => 'Siti Nasabah',
            'username' => 'b001',
            'email' => 'nasabahb@simbah.internal',
            'password' => Hash::make('password'),
            'role' => 'nasabah',
            'unit_id' => $unitB->id,
        ]);

        $nasabahB = \App\Models\Nasabah::create([
            'unit_id' => $unitB->id,
            'user_id' => $userNasabahB->id,
            'nomor_induk' => 'B001',
            'nama' => 'Siti Nasabah',
            'alamat' => 'Jl. Kenanga No. 2',
            'status' => 'aktif',
        ]);

        // Harga di Unit B sengaja dibuat beda dari Unit A, biar kelihatan harga memang per-unit
        \App\Models\HargaSampah::create([
            'unit_id' => $unitB->id,
            'jenis_sampah_id' => $kardus->id,
            'harga_pengepul' => 1900,
            'harga_nasabah' => 1700,
            'tanggal_mulai' => now()->subDays(7),
        ]);

        \App\Models\Tabungan::create([
            'nasabah_id' => $nasabahB->id,
            'jenis' => 'masuk',
            'nominal' => 15000,
            'keterangan' => 'Saldo awal (demo)',
            'tanggal' => now()->subDays(3),
        ]);
    }
}
