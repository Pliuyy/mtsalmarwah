<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pengaturan Dasar Sekolah
        Setting::create(['key' => 'school_name', 'value' => '']); // Nama sekolah
        Setting::create(['key' => 'school_address', 'value' => '']); // Alamat sekolah
        Setting::create(['key' => 'school_phone', 'value' => '']); // Nomor telepon sekolah
        Setting::create(['key' => 'school_email', 'value' => '']); // Email sekolah
        Setting::create(['key' => 'school_description', 'value' => '']); // Deskripsi singkat sekolah

        // Pengaturan PPDB
        Setting::create(['key' => 'ppdb_status', 'value' => 'open']); // Status PPDB: 'open' atau 'closed'
        Setting::create(['key' => 'ppdb_contact_person', 'value' => 'Bapak/Ibu Admin PPDB (0812-3456-7890)']); // Kontak person PPDB
        Setting::create(['key' => 'ppdb_start_date', 'value' => '']); // Tanggal mulai pendaftaran PPDB
        Setting::create(['key' => 'ppdb_end_date', 'value' => '']); // Tanggal selesai pendaftaran PPDB
        Setting::create(['key' => 'ppdb_welcome_text', 'value' => '']); // Teks sambutan di halaman PPDB

        // Profil Kepala Sekolah
        Setting::create(['key' => 'principal_name', 'value' => 'Dr. H. Ahmad Fauzi, M.Pd.']); // Nama Kepala Sekolah
        Setting::create(['key' => 'principal_photo', 'value' => 'principal_ahmad.jpg']); // Nama file foto kepala sekolah (di public/storage/settings/)
        Setting::create(['key' => 'kepala_sekolah_sambutan', 'value' => 'Selamat datang di website resmi sekolah kami. Mari bersama wujudkan generasi penerus bangsa yang berkualitas dan berakhlak mulia. Kami siap mendidik putra-putri terbaik bangsa.']); // Sambutan Kepala Sekolah

        // Visi dan Misi Sekolah
        Setting::create(['key' => 'school_vision', 'value' => '']); 
        Setting::create(['key' => 'school_vision_1', 'value' => '']); 
        Setting::create(['key' => 'school_vision_2', 'value' => '']); 
        Setting::create(['key' => 'school_vision_3', 'value' => '']); 
        Setting::create(['key' => 'school_vision_4', 'value' => '']); 
        Setting::create(['key' => 'school_vision_5', 'value' => '']); 
        Setting::create(['key' => 'school_mission_1', 'value' => '']); 
        Setting::create(['key' => 'school_mission_2', 'value' => '']); 
        Setting::create(['key' => 'school_mission_3', 'value' => '']); 
        Setting::create(['key' => 'school_mission_4', 'value' => '']); 
        Setting::create(['key' => 'school_mission_5', 'value' => '']); 

        // Sejarah Sekolah
        Setting::create(['key' => 'school_history', 'value' => 'Sekolah kami didirikan pada tahun 1995 dengan semangat untuk menciptakan lingkungan pendidikan yang berfokus pada pengembangan karakter dan potensi akademik siswa. Sejak awal, kami berkomitmen untuk memberikan pendidikan holistik yang relevan dengan perkembangan zaman dan kebutuhan masyarakat. Berbagai inovasi kurikulum telah kami terapkan, serta fasilitas terus kami tingkatkan untuk menunjang proses belajar mengajar. Kami bangga telah menjadi bagian dari perjalanan ribuan siswa dalam meraih cita-cita mereka.']);

        // Link Media Sosial
        Setting::create(['key' => 'facebook_link', 'value' => 'https://facebook.com/mtsalmarwah']);
        Setting::create(['key' => 'instagram_link', 'value' => 'https://instagram.com/mts_almarwah_pemungpeuk']);
        Setting::create(['key' => 'youtube_link', 'value' => 'https://youtube.com/mtsalmarwahofficial']);
        Setting::create(['key' => 'tiktok_link', 'value' => 'https://youtube.com/mtsalmarwahofficial']);
    }
}
