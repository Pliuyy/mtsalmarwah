<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryCategory;

class GalleryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    GalleryCategory::create(['name' => 'Kegiatan Sekolah']);
    GalleryCategory::create(['name' => 'Fasilitas Sekolah']);
    GalleryCategory::create(['name' => 'Acara Wisuda']);
    GalleryCategory::create(['name' => 'Lomba dan Prestasi']);
}
}
