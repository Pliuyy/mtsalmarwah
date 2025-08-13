<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery; // Pastikan ini ada
use App\Models\GalleryCategory; // Pastikan ini ada

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan kategori sudah ada atau buat jika belum
        $kegiatanSekolah = GalleryCategory::firstOrCreate(['name' => 'Kegiatan Sekolah']);
        $prestasiSiswa = GalleryCategory::firstOrCreate(['name' => 'Prestasi Siswa']);
        $ekstrakurikuler = GalleryCategory::firstOrCreate(['name' => 'Ekstrakurikuler']);

        // Contoh data foto (pastikan file_path sesuai dengan nama file di storage/app/public/gallery_images)
        Gallery::create([
            'title' => 'Upacara Bendera',
            'type' => 'photo',
            'file_path' => 'gallery_upacara.jpg',
            'thumbnail_path' => null,
            'gallery_category_id' => $kegiatanSekolah->id,
        ]);

        Gallery::create([
            'title' => 'Siswa Belajar di Lab',
            'type' => 'photo',
            'file_path' => 'gallery_lab.jpg',
            'thumbnail_path' => null,
            'gallery_category_id' => $kegiatanSekolah->id,
        ]);

        Gallery::create([
            'title' => 'Perpustakaan Sekolah',
            'type' => 'photo',
            'file_path' => 'gallery_perpustakaan.jpg',
            'thumbnail_path' => null,
            'gallery_category_id' => $kegiatanSekolah->id,
        ]);

        // --- Bagian Video ---
        // Pastikan setiap video_id adalah ID video YouTube yang UNIK
        Gallery::create([
            'title' => 'Video Profil Sekolah',
            'type' => 'video',
            'video_id' => 'H-DeO-hnyTc',
            'file_path' => 'uxux', // ID Video YouTube 1
            'thumbnail_path' => null,
            'gallery_category_id' => $kegiatanSekolah->id,
        ]);

        Gallery::create([
            'title' => 'Kegiatan Ekstrakurikuler',
            'type' => 'video',
            'video_id' => 'XxpRd0D3Fv8',
            'file_path' => 'uxux', // ID Video YouTube 2 (ganti dengan ID video lain)
            'thumbnail_path' => null,
            'gallery_category_id' => $ekstrakurikuler->id,
        ]);

        Gallery::create([
            'title' => 'Prestasi Siswa Terbaru',
            'type' => 'video',
            'video_id' => '2T8iNrpJpIg',
            'file_path' => 'uxux', // ID Video YouTube 3 (ganti dengan ID video lain)
            'thumbnail_path' => null,
            'gallery_category_id' => $prestasiSiswa->id,
        ]);
        // --- Akhir Bagian Video ---
    }
}