@extends('layouts.app')

@section('title', 'Cetak Formulir PPDB')

@section('content')
<div class="container mx-auto px-4">
    
    @include('components.hero_carousel')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-1">
            @include('frontend.ppdb.ppdb_sidebar')
        </div>

        <div class="lg:col-span-3 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-navy-blue mb-6">Cetak Dokumen Pendaftaran & Kelulusan</h2>
            <p class="text-gray-700 leading-relaxed text-lg mb-6">
                Setelah pengumuman hasil seleksi, Anda dapat mencetak formulir pendaftaran dan bukti kelulusan di sini. Dokumen ini penting untuk proses daftar ulang.
            </p>

            <form action="{{ route('ppdb.print_form') }}" method="GET" class="flex items-center space-x-4 mb-8">
                {{-- Hapus @csrf karena tidak diperlukan untuk GET request --}}
                {{-- @csrf --}}
                <div class="flex-grow">
                    <label for="nomor_pendaftaran_cetak" class="sr-only">Nomor Pendaftaran / Email Anda</label>
                    <input type="text" id="nomor_pendaftaran_cetak" name="nomor_pendaftaran_cetak" placeholder="Contoh: PPDB2025-ABCDD"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('nomor_pendaftaran_cetak', request('nomor_pendaftaran_cetak')) }}" required> {{-- Tambahkan value untuk mempertahankan input --}}
                </div>
                <div>
                    <button type="submit" class="bg-navy-blue hover:bg-royal-blue text-white font-bold py-2 px-6 rounded-full transition duration-300">
                        <i class="fas fa-file-alt mr-2"></i> Cetak Dokumen
                    </button>
                </div>
            </form>

            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded-md mb-8">
                <h3 class="font-bold text-xl mb-3"><i class="fas fa-calendar-alt mr-2"></i> Jadwal & Persyaratan Daftar Ulang</h3>
                @php
                $daftarUlangSchedule = App\Models\PpdbSchedule::where('title', 'Daftar Ulang')->first();
                @endphp
                @if($daftarUlangSchedule) {{-- <<< TAMBAHKAN INI --}}
                <p class="mb-3">Bagi calon siswa yang dinyatakan lulus, harap perhatikan detail daftar ulang berikut :</p>
                <ul class="list-none space-y-2">
                    <li><i class="fas fa-calendar-check text-royal-blue mr-2"></i> <strong>Tanggal Daftar Ulang:</strong> {{ $daftarUlangSchedule->start_date->format('d - ') }}{{ $daftarUlangSchedule->end_date->format('d F Y') }}</li>
                    <li><i class="fas fa-clock text-royal-blue mr-2"></i> <strong>Waktu:</strong> 08.00 - 15.00 WIB (Sesuai jam kerja sekolah)</li>
                    <li><i class="fas fa-map-marker-alt text-royal-blue mr-2"></i> <strong>Lokasi:</strong> Sekretariat PPDB {{ $settings['school_name'] ?? 'Nama Sekolah' }} (Gedung A, Lantai 1)</li>
                </ul>
                @else {{-- <<< TAMBAHKAN INI --}}
                <p>Jadwal daftar ulang belum tersedia.</p>
                @endif {{-- <<< TUTUP IF --}}

                <h4 class="font-bold text-lg mt-6 mb-3"><i class="fas fa-file-invoice text-royal-blue mr-2"></i> Dokumen yang Harus Dibawa Saat Daftar Ulang :</h4>
                @if($requirements->isNotEmpty())
                <ul class="list-disc list-inside space-y-2">
                    @foreach($requirements as $req)
                    <li>{{ $req->description }}</li>
                    @endforeach
                </ul>
                @else
                <p>Persyaratan daftar ulang belum tersedia.</p>
                @endif
                <p class="text-sm italic mt-4">Untuk detail biaya, silakan hubungi bagian administrasi.</p>
            </div>

            {{-- Anda bisa menambahkan link download formulir cetak kosong di sini juga --}}
        </div>
    </div>
</div>
@endsection