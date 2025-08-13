<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PpdbResult;
use Carbon\Carbon;

class PpdbResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PpdbResult::create([
            'title' => 'Daftar Calon Siswa Diterima Gelombang 1',
            'file_path' => 'ppdb_result_gelombang1.pdf', // Nama file PDF di storage
            'content' => 'Selamat kepada calon siswa yang telah diterima pada gelombang 1 PPDB Tahun Ajaran 2025/2026. Silakan lihat daftar nama lengkap di file terlampir.',
            'published_at' => Carbon::parse('2025-08-20 10:00:00'),
        ]);

        PpdbResult::create([
            'title' => 'Informasi Daftar Ulang PPDB 2025',
            'file_path' => 'ppdb_daftar_ulang_info.pdf',
            'content' => 'Informasi lengkap mengenai prosedur dan jadwal daftar ulang bagi siswa yang diterima.',
            'published_at' => Carbon::parse('2025-08-21 09:00:00'),
        ]);
    }
}