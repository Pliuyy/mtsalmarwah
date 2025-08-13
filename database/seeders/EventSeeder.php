<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
// database/seeders/EventSeeder.php
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'title' => 'Perayaan Hari Kemerdekaan RI',
            'description' => 'Berbagai lomba dan pertunjukan seni untuk memeriahkan Hari Kemerdekaan Republik Indonesia.',
            'date' => Carbon::parse('2025-08-17'),
            'time' => '08:00:00', // <<< UBAH KE FORMAT WAKTU STANDAR
            'location' => 'Lapangan Utama Sekolah',
            'photo' => 'event_kemerdekaan.jpg',
        ]);

        Event::create([
            'title' => 'Pentas Seni Akhir Tahun',
            'description' => 'Ajang kreativitas siswa menampilkan bakat seni tari, musik, drama, dan lainnya.',
            'date' => Carbon::parse('2025-12-15'),
            'time' => '19:00:00', // <<< UBAH KE FORMAT WAKTU STANDAR
            'location' => 'Gedung Serbaguna Sekolah',
            'photo' => 'event_pensi.jpg',
        ]);

        Event::create([
            'title' => 'Workshop Coding untuk Pemula',
            'description' => 'Workshop interaktif bagi siswa yang tertarik belajar dasar-dasar pemrograman.',
            'date' => Carbon::parse('2025-09-20'),
            'time' => '13:00:00', // <<< UBAH KE FORMAT WAKTU STANDAR
            'location' => 'Lab Komputer',
            'photo' => 'event_coding.jpg',
        ]);
    }
}