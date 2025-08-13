<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;
use Carbon\Carbon;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievement::create([
            'student_name' => 'Putri Indah',
            'achievement' => 'Juara 1 Lomba Pidato Bahasa Inggris Tingkat Kota',
            'published_at' => Carbon::now()->subHours(1),
            'photo' => 'achievement_putri.jpg',
        ]);

        Achievement::create([
            'student_name' => 'Kevin Pratama',
            'achievement' => 'Medali Emas Olimpiade Matematika Nasional',
            'published_at' => Carbon::now()->subYears(5),
            'photo' => 'achievement_kevin.jpg',
        ]);

        Achievement::create([
            'student_name' => 'Tim Robotik Sekolah',
            'achievement' => 'Juara Favorit Kompetisi Robot Nasional',
            'published_at' => Carbon::now()->subDays(3),
            'photo' => 'achievement_robotik.jpg',
        ]);
    }
}
