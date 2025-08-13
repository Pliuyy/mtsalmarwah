<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PpdbSchedule;
use Carbon\Carbon;

class PpdbScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PpdbSchedule::create([
            'title' => 'Pendaftaran Online',
            'start_date' => Carbon::parse('2025-07-01'),
            'end_date' => Carbon::parse('2025-07-31'),
            'description' => 'Pendaftaran calon siswa baru melalui formulir online di website.',
        ]);

        PpdbSchedule::create([
            'title' => 'Verifikasi Berkas',
            'start_date' => Carbon::parse('2025-08-05'),
            'end_date' => Carbon::parse('2025-08-10'),
            'description' => 'Verifikasi dokumen fisik dan kelengkapan berkas pendaftaran di sekolah.',
        ]);

        PpdbSchedule::create([
            'title' => 'Tes Akademik dan Wawancara',
            'start_date' => Carbon::parse('2025-08-15'),
            'end_date' => Carbon::parse('2025-08-16'),
            'description' => 'Pelaksanaan tes tertulis dan wawancara bagi calon siswa.',
        ]);

        PpdbSchedule::create([
            'title' => 'Pengumuman Hasil',
            'start_date' => Carbon::parse('2025-08-20'),
            'end_date' => Carbon::parse('2025-08-20'),
            'description' => 'Pengumuman hasil seleksi PPDB dapat dilihat di website atau papan pengumuman sekolah.',
        ]);

        PpdbSchedule::create([
            'title' => 'Daftar Ulang',
            'start_date' => Carbon::parse('2025-08-25'),
            'end_date' => Carbon::parse('2025-08-30'),
            'description' => 'Proses daftar ulang bagi calon siswa yang diterima.',
        ]);
    }
}