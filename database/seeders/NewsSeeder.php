<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('role', 'superadmin')->first();

        if (!$adminUser) {
            // Fallback jika UserSeeder belum dijalankan atau tidak ada admin
            $adminUser = User::factory()->create([
                'name' => 'Default Admin',
                'email' => 'default_admin@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        News::create([
            'title' => 'Sekolah Kita Meraih Juara 1 Lomba Sains Tingkat Kabupaten!',
            'slug' => 'sekolah-kita-meraih-juara-1-lomba-sains-tingkat-kabupaten',
            'content' => '...',
            'thumbnail' => 'news_sains.jpg',
            'user_id' => $adminUser->id,
            'published_at' => Carbon::now()->subHours(1),
        ]);

        News::create([
            'title' => 'Jadwal Rapat Wali Murid Semester Genap 2025',
            'slug' => 'jadwal-rapat-wali-murid-semester-genap-2025',
            'content' => '...',
            'thumbnail' => 'news_rapat.jpg',
            'user_id' => $adminUser->id,
            'published_at' => Carbon::now()->subDays(2), // 2 hari yang lalu
        ]);

        News::create([
            'title' => 'Pembukaan PPDB Tahun Ajaran 2025/2026 Segera Dimulai',
            'slug' => 'pembukaan-ppdb-tahun-ajaran-2025-2026-segera-dimulai',
            'content' => '...',
            'thumbnail' => 'news_ppdb.jpg',
            'user_id' => $adminUser->id,
            'published_at' => Carbon::now()->subDays(5), // 5 hari yang lalu
        ]);

        News::create([
            'title' => 'Lomba Kebersihan Kelas Antar Angkatan',
            'slug' => 'lomba-kebersihan-kelas-antar-angkatan',
            'content' => '...',
            'thumbnail' => 'news_kebersihan.jpg',
            'user_id' => $adminUser->id,
            'published_at' => Carbon::now()->subDays(8), // 8 hari yang lalu
        ]);

        News::create([
            'title' => 'Hari Guru Nasional Dirayakan Meriah!',
            'slug' => 'hari-guru-nasional-dirayakan-meriah',
            'content' => '...',
            'thumbnail' => 'news_hariguru.jpg',
            'user_id' => $adminUser->id,
            'published_at' => Carbon::now()->subDays(10), // 10 hari yang lalu
        ]);
    }
}
