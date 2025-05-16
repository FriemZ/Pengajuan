<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dosen;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua data (urutan penting karena foreign key)
        DB::table('dosens')->delete();
        DB::table('users')->delete();
        DB::table('jurusans')->delete();

        // Buat jurusan
        $ti = Jurusan::create(['nama' => 'Teknik Informatika']);
        $si = Jurusan::create(['nama' => 'Sistem Informasi']);

        // Admin
        User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'conf_pass' => 'admin',
            'role' => 'admin',
            'jurusan_id' => $ti->id,
        ]);

        // Dosen
        $dosenUser = User::create([
            'nama' => 'Dosen A',
            'email' => 'dosen@example.com',
            'password' => Hash::make('dosen'),
            'conf_pass' => 'dosen',
            'role' => 'dosen',
            'jurusan_id' => $ti->id,
        ]);

        Dosen::create([
            'user_id' => $dosenUser->id,
            'nip' => '197812312022111001', // Jika pakai NIP
            'jabatan' => 'Koordinator Magang',
            'ttd_path' => 'ttd/dosen-a.png',
        ]);

        // Mahasiswa A
        User::create([
            'nama' => 'Mahasiswa A',
            'email' => 'mahasiswa1@example.com',
            'nim' => '1234567890',
            'password' => Hash::make('maha1'),
            'conf_pass' => 'maha1',
            'role' => 'mahasiswa',
            'jurusan_id' => $ti->id,
        ]);

        // Mahasiswa B
        User::create([
            'nama' => 'Mahasiswa B',
            'email' => 'mahasiswa2@example.com',
            'nim' => '0987654321',
            'password' => Hash::make('maha2'),
            'conf_pass' => 'maha2',
            'role' => 'mahasiswa',
            'jurusan_id' => $si->id,
        ]);
    }
}
