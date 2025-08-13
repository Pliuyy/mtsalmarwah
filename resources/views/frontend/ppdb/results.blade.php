@extends('layouts.app')

@section('title', 'Hasil Seleksi PPDB')

@section('content')
<div class="container mx-auto px-4">

    @include('components.hero_carousel')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-1">
            @include('frontend.ppdb.ppdb_sidebar')
        </div>

        <div class="lg:col-span-3 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-navy-blue mb-6">Pantau Status Pendaftaran Anda</h2>
            <p class="text-gray-700 leading-relaxed text-lg mb-6">
                Masukkan Nomor Pendaftaran unik yang Anda terima saat mengirimkan formulir. Hasil seleksi akan diumumkan pada tanggal **{{ App\Models\PpdbSchedule::where('title', 'Pengumuman Hasil')->first()->end_date->format('d F Y') ?? 'tanggal pengumuman' }}** pukul 14:00 WIB.
            </p>

            <form action="{{ route('ppdb.check_results') }}" method="POST" class="flex items-center space-x-4 mb-8">
                @csrf
                <div class="flex-grow">
                    <label for="nomor_pendaftaran" class="sr-only">Nomor Pendaftaran Anda</label>
                    <input type="text" id="nomor_pendaftaran" name="nomor_pendaftaran" placeholder="Contoh: PPDB2025-ABCDD"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('nomor_pendaftaran', request('nomor_pendaftaran')) }}" required>
                </div>
                <div>
                    <button type="submit" class="bg-navy-blue hover:bg-royal-blue text-white font-bold py-2 px-6 rounded-full transition duration-300">
                        <i class="fas fa-search mr-2"></i> Cari Hasil
                    </button>
                </div>
            </form>

            @if($searchResult)
            @php
            $statusClasses = [
            'accepted' => 'bg-green-100 border-l-4 border-green-500 text-green-700',
            'rejected' => 'bg-red-100 border-l-4 border-red-500 text-red-700',
            'pending' => 'bg-gray-100 border-l-4 border-gray-500 text-gray-700',
            'Tidak Ditemukan' => 'bg-gray-100 border-l-4 border-gray-500 text-gray-700', // Status default
            ];
            $currentClass = $statusClasses[$searchResult['status']] ?? 'bg-gray-100 border-l-4 border-gray-500 text-gray-700';
            @endphp

            <div class="mt-8 p-6 rounded-lg {{ $currentClass }}">
                <h3 class="font-bold text-xl mb-3">Status Pendaftaran: {{ $searchResult['status'] }}</h3>
                @if($searchResult['nama_siswa'])
                <p class="text-lg">Nama Siswa: <span class="font-semibold">{{ $searchResult['nama_siswa'] }}</span></p>
                @endif
                <p class="mt-2">{{ $searchResult['informasi'] }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection