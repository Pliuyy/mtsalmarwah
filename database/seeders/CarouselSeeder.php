<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carousel;

class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua entri carousel lainnya dan hanya sisakan satu ini untuk video background
        // Gunakan ID video YouTube yang akan menjadi background utama
        Carousel::create([
            'title' => 'Wujudkan Mimpi Pendidikan Terbaik!', // Judul yang akan tampil di atas video
            'subtitle' => 'Mencetak Generasi Unggul Berkarakter dan Berakhlak Mulia', // Subtitle
            'image_path' => null, // Tidak menggunakan gambar
            'video_url' => 'H-DeO-hnyTc', // <<< GANTI DENGAN ID VIDEO YOUTUBE BACKGROUND ANDA
            'type' => 'video',
            'button_text' => 'Daftar Sekarang', // Teks tombol
            'button_link' => '/ppdb', // Link tombol
            'order' => 1,
            'is_active' => true,
        ]);
    }
}