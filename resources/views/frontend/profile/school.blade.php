@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-navy-blue mb-8 text-center">Profil Lengkap Sekolah Kami</h1>
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-3xl mx-auto">
        <h2 class="text-3xl font-semibold text-royal-blue mb-6 border-b-2 border-royal-blue pb-2">Tentang Kami</h2>
        @php
        $schoolHistory = $settings['school_history'] ?? 'Sejarah sekolah belum diatur. Harap tambahkan melalui panel admin.';

        $normalizedText = preg_replace('/\r\n|\r/', "\n", $schoolHistory);

        $paragraphs = preg_split('/\n\s*\n| {2,}/', $normalizedText);
        @endphp

        @foreach ($paragraphs as $paragraph)
        @if (trim($paragraph) !== '')
        <p class="text-gray-700 leading-relaxed text-lg mb-4">{{ trim($paragraph) }}</p>
        @endif
        @endforeach

        <p class="text-gray-700 leading-relaxed text-lg">
            Sejak didirikan pada tahun {{ $settings['school_founding_year'] ?? 'XXXX' }}, {{ $settings['school_name'] ?? 'Sekolah Kita' }} ini didasari atas keinginan membantu masyarakat menengah kebawah yang ingin menyekolahkan anak-anaknya akan tetapi kesulitan dalam masalah pembiayaan yang nyatanya pembiayaan pendidikan sekarang semakin memberatkan mereka. 
        </p>

        <h3 class="text-2xl font-semibold text-navy-blue mt-8 mb-4">Fasilitas Unggulan</h3>
        <ul class="list-disc list-inside text-gray-700 leading-relaxed text-lg space-y-2">
            <li>Laboratorium IPA dan Laboratorium Komputer</li>
            <li>Perpustakaan Lengkap dan Nyaman</li>
            <li>Lapangan Olahraga Serbaguna</li>
            <li>Masjid yang Luas dan nyaman</li>
        </ul>

        {{-- Anda bisa tambahkan struktur organisasi, denah sekolah, dll di sini --}}

    </div>
</div>
@endsection