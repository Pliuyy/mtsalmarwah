<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TeacherSeeder::class,
            StaffSeeder::class,
            AchievementSeeder::class,
            ExtracurricularSeeder::class,
            EventSeeder::class,
            GalleryCategorySeeder::class, 
            GallerySeeder::class,
            NewsSeeder::class,
            PpdbScheduleSeeder::class,
            PpdbRequirementSeeder::class,
            PpdbResultSeeder::class,
            SettingSeeder::class,
            CarouselSeeder::class,
        ]);
    }
}