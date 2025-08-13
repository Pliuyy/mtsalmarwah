<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PpdbRequirement;

class PpdbRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PpdbRequirement::create([
            'title' => 'Fotokopi Akta Kelahiran',
            'description' => '2 lembar fotokopi Akta Kelahiran yang dilegalisir.',
        ]);

        PpdbRequirement::create([
            'title' => 'Fotokopi Kartu Keluarga (KK)',
            'description' => '2 lembar fotokopi Kartu Keluarga.',
        ]);

        PpdbRequirement::create([
            'title' => 'Fotokopi Ijazah/Surat Keterangan Lulus (SKL)',
            'description' => '2 lembar fotokopi Ijazah atau SKL dari sekolah asal yang dilegalisir.',
        ]);

        PpdbRequirement::create([
            'title' => 'Pas Foto Terbaru',
            'description' => 'Ukuran 3x4 berwarna, 4 lembar.',
        ]);

        PpdbRequirement::create([
            'title' => 'Surat Keterangan Sehat',
            'description' => 'Dari dokter/puskesmas.',
        ]);
    }
}