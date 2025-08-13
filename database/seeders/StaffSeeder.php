<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff; // PASTIKAN IMPORT MODELNYA BENAR

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create([ // PASTIKAN ANDA MEMANGGIL MODELNYA DENGAN BENAR
            'name' => 'Rina Kusumawati',
            'position' => 'Kepala Tata Usaha',
            'photo' => 'staff_rina.jpg',
            'bio' => 'Ibu Rina bertanggung jawab atas seluruh administrasi sekolah dan keuangan.',
        ]);

        Staff::create([
            'name' => 'Joko Susilo',
            'position' => 'Petugas Perpustakaan',
            'photo' => 'staff_joko.jpg',
            'bio' => 'Bapak Joko adalah penjaga perpustakaan yang selalu siap membantu siswa menemukan buku.',
        ]);
    }
}