<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use Carbon\Carbon;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'name' => 'Budi Santoso, S.Pd.',
            'published_at' => Carbon::now()->subHours(1),
            'subject' => 'Matematika',
            'photo' => 'teacher_budi.jpg', // Contoh nama file gambar
            'bio' => 'Bapak Budi adalah guru matematika senior dengan pengalaman mengajar lebih dari 15 tahun. Beliau dikenal dengan metode pengajaran yang interaktif dan mudah dipahami.',
        ]);

        Teacher::create([
            'name' => 'Siti Aminah, M.Pd.',
            'published_at' => Carbon::now()->subHours(1),
            'subject' => 'Bahasa Indonesia',
            'photo' => 'teacher_siti.jpg',
            'bio' => 'Ibu Siti adalah guru Bahasa Indonesia yang berdedikasi. Beliau sering membawa siswa-siswinya meraih prestasi dalam lomba menulis dan membaca puisi.',
        ]);

        Teacher::create([
            'name' => 'Andi Wijaya, S.Kom.',
            'published_at' => Carbon::now()->subHours(1),
            'subject' => 'Ilmu Komputer',
            'photo' => 'teacher_andi.jpg',
            'bio' => 'Bapak Andi adalah guru muda yang ahli di bidang teknologi informasi. Beliau membimbing ekstrakurikuler robotik dan coding di sekolah.',
        ]);
    }
}
