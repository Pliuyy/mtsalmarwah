<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbSchedule;
use App\Models\PpdbRequirement;
use App\Models\PpdbResult;
use App\Models\Setting;
use App\Models\PpdbApplicant;
use App\Models\Carousel;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PpdbController extends Controller
{
    // Halaman Utama PPDB (Portal)
    public function index()
    {
        $schedules = PpdbSchedule::orderBy('start_date')->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $carousels = Carousel::where('is_active', true)->orderBy('order')->get();

        return view('frontend.ppdb.index', compact('schedules', 'settings', 'carousels'));
    }

    // Halaman Formulir Pendaftaran Online
    public function form()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $carousels = Carousel::where('is_active', true)->orderBy('order')->get();

        return view('frontend.ppdb.form', compact('settings', 'carousels'));
    }

    // Metode untuk submit formulir
    public function submitForm(Request $request)
    {
        // 1. Validasi data dari formulir, termasuk field baru
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat_lengkap' => 'required|string',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:255|unique:ppdb_applicants,nisn',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'penghasilan_ayah' => 'required|string|max:255',
            'penghasilan_ibu' => 'required|string|max:255',
            'telepon_ortu' => 'required|string|max:20',
            'email_ortu' => 'nullable|email|max:255',
            'upload_akta_kelahiran' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'upload_kk' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'upload_ijazah' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'upload_pas' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // 2. Buat objek pendaftar baru
        $applicant = new PpdbApplicant();

        // 3. Pindahkan data dari request ke kolom database secara manual
        $applicant->full_name = $request->nama_lengkap;
        $applicant->birth_place = $request->tempat_lahir;
        $applicant->birth_date = $request->tanggal_lahir;
        $applicant->gender = $request->jenis_kelamin;
        $applicant->address = $request->alamat_lengkap;
        $applicant->previous_school = $request->asal_sekolah;
        $applicant->nisn = $request->nisn;
        $applicant->father_name = $request->nama_ayah;
        $applicant->father_job = $request->pekerjaan_ayah;
        $applicant->mother_name = $request->nama_ibu;
        $applicant->mother_job = $request->pekerjaan_ibu;
        $applicant->father_income = $request->penghasilan_ayah; // Mapped new field
        $applicant->mother_income = $request->penghasilan_ibu; // Mapped new field
        $applicant->parent_phone = $request->telepon_ortu;
        $applicant->parent_email = $request->email_ortu;

        // 4. Proses dan simpan file jika ada
        if ($request->hasFile('upload_akta_kelahiran')) {
            $applicant->akta_kelahiran_path = $request->file('upload_akta_kelahiran')->store('ppdb/akta', 'public');
        }

        if ($request->hasFile('upload_kk')) {
            $applicant->kk_path = $request->file('upload_kk')->store('ppdb/kk', 'public');
        }

        if ($request->hasFile('upload_ijazah')) {
            $applicant->ijazah_path = $request->file('upload_ijazah')->store('ppdb/ijazah', 'public');
        }

        if ($request->hasFile('upload_pas')) {
            $applicant->pas_foto_path = $request->file('upload_pas')->store('ppdb/pas_foto', 'public');
        }

        // 5. Generate dan simpan nomor pendaftaran
        $applicant->registration_number = 'PPDB2025-' . strtoupper(Str::random(5));

        // 6. Simpan semua data ke database
        $applicant->save();

        // 7. Redirect ke halaman formulir dengan pesan sukses dan nomor pendaftaran
        return redirect()->route('ppdb.form')->with('success', 'Formulir berhasil dikirim! Nomor pendaftaran Anda adalah ' . $applicant->registration_number);
    }

    // Halaman Hasil Seleksi
    // Halaman Hasil Seleksi
    public function results(Request $request)
    {
        $searchResult = null;
        $pengumumanSchedule = PpdbSchedule::where('title', 'Pengumuman Hasil')->first();
        $settings = Setting::pluck('value', 'key')->toArray();
        $carousels = Carousel::where('is_active', true)->orderBy('order')->get();

        // Pastikan tombol pencarian ditekan dan ada nomor pendaftaran
        if ($request->has('nomor_pendaftaran') && $request->nomor_pendaftaran) {
            $nomorPendaftaran = $request->nomor_pendaftaran;

            // Cari pendaftar di database berdasarkan nomor pendaftaran
            $applicant = PpdbApplicant::where('registration_number', $nomorPendaftaran)->first();

            if ($applicant) {
                // Jika pendaftar ditemukan
                $searchResult = [
                    'status' => $applicant->status, // Ambil status dari database
                    'nama_siswa' => $applicant->full_name,
                    'nomor_pendaftaran' => $applicant->registration_number,
                    'informasi' => $this->getInformationByStatus($applicant->status), // Dapatkan pesan info
                ];
            } else {
                // Jika pendaftar tidak ditemukan
                $searchResult = [
                    'status' => 'Tidak Ditemukan',
                    'nama_siswa' => null,
                    'informasi' => 'Nomor pendaftaran tidak ditemukan atau belum diumumkan. Pastikan nomor yang Anda masukkan benar.',
                ];
            }
        }

        return view('frontend.ppdb.results', compact('searchResult', 'pengumumanSchedule', 'settings', 'carousels'));
    }

    // Metode pembantu untuk mendapatkan pesan berdasarkan status
    private function getInformationByStatus($status)
    {
        if ($status === 'accepted') {
            return 'Selamat! Anda diterima sebagai calon siswa baru. Silakan lanjutkan ke tahap daftar ulang.';
        } elseif ($status === 'rejected') {
            return 'Mohon maaf, Anda belum diterima. Coba lagi di lain waktu.';
        }
        return 'Status pendaftaran Anda masih dalam proses.';
    }

    public function checkResults(Request $request)
    {
        return $this->results($request);
    }

    // Halaman Cetak Formulir & Kelulusan
    public function printForm()
    {
        $requirements = PpdbRequirement::all();
        $settings = Setting::pluck('value', 'key')->toArray();
        $carousels = Carousel::where('is_active', true)->orderBy('order')->get();

        return view('frontend.ppdb.print_form', compact('requirements', 'settings', 'carousels'));
    }

    // Halaman Unduhan Berkas
    public function downloadResources()
    {
        $resources = [
            [
                'title' => 'Formulir Pendaftaran (Kosong)',
                'description' => 'Unduh dan cetak formulir pendaftaran kosong untuk pendaftaran manual.',
                'icon' => 'fas fa-file-pdf',
                'file_path' => 'formulir_kosong.pdf',
            ],
            [
                'title' => 'Brosur Informasi PPDB',
                'description' => 'Berisikan informasi lengkap tentang visi, misi, program, dan keunggulan pendidikan.',
                'icon' => 'fas fa-book',
                'file_path' => 'brosur_ppdb.pdf',
            ],
            [
                'title' => 'Panduan Teknis Pengisian Online',
                'description' => 'Panduan langkah demi langkah untuk mengisi formulir pendaftaran online dengan benar.',
                'icon' => 'fas fa-file-alt',
                'file_path' => 'panduan_online.pdf',
            ],
        ];

        $settings = Setting::pluck('value', 'key')->toArray();
        $carousels = Carousel::where('is_active', true)->orderBy('order')->get();

        return view('frontend.ppdb.download', compact('resources', 'settings', 'carousels'));
    }
}
