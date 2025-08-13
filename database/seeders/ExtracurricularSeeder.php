<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Extracurricular;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Extracurricular::create([
            'name' => 'Pramuka',
            'description' => 'Kegiatan kepramukaan untuk melatih kemandirian, kepemimpinan, dan kecintaan terhadap alam.',
            'schedule' => 'Setiap hari Sabtu, pukul 09.00 - 12.00 WIB',
            'photo' => 'extracurricular_pramuka.jpg',
        ]);

        Extracurricular::create([
            'name' => 'Futsal',
            'description' => 'Latihan dan pertandingan futsal untuk mengembangkan bakat olahraga dan kerja sama tim.',
            'schedule' => 'Setiap hari Selasa dan Jumat, pukul 15.00 - 17.00 WIB',
            'photo' => 'extracurricular_futsal.jpg',
        ]);

        Extracurricular::create([
            'name' => 'Klub Sains',
            'description' => 'Eksplorasi dunia sains melalui eksperimen dan proyek-proyek menarik.',
            'schedule' => 'Setiap hari Rabu, pukul 14.00 - 16.00 WIB',
            'photo' => 'extracurricular_sains.jpg',
        ]);
    }
}