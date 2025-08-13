@extends('layouts.app')

@section('title', 'Kepala Sekolah')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h2 class="text-4xl font-bold text-navy-blue mb-8 text-center">
        <span class="border-b-4 border-royal-blue pb-2">Kepala Madrasah Kami</span>
    </h2>

    <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-4xl mx-auto text-center">
        {{-- Gambar dinamis --}}
        @if (!empty($settings['principal_photo']))
            <img src="{{ asset('storage/' . $settings['principal_photo']) }}"
                 alt="Foto Kepala Sekolah"
                 class="w-48 h-48 md:w-52 md:h-52 rounded-full object-cover mx-auto mb-6 border-4 border-royal-blue shadow-lg">
        @else
            <img src="https://via.placeholder.com/200x200/4169E1/FFFFFF?text=KS"
                 alt="Foto Kepala Sekolah"
                 class="w-48 h-48 md:w-52 md:h-52 rounded-full object-cover mx-auto mb-6 border-4 border-royal-blue shadow-lg">
        @endif

        {{-- Nama dan Jabatan --}}
        <h2 class="text-3xl font-bold text-navy-blue mb-1">
            {{ $settings['principal_name'] ?? 'Bpk. Kepala Sekolah' }}
        </h2>
        <p class="text-gray-600 text-lg font-medium mb-6">
            Kepala Sekolah {{ $settings['school_name'] ?? 'Nama Sekolah' }}
        </p>

        {{-- Sambutan --}}
        <blockquote class="text-gray-800 text-lg md:text-xl leading-relaxed text-justify italic mb-6 px-4 md:px-0">
            <p class="mb-4">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

            <p class="mb-4">
                {{ $settings['kepala_sekolah_sambutan'] ?? 'Belum ada sambutan dari Kepala Sekolah. Harap tambahkan melalui panel admin.' }}
            </p>

            <p class="mt-6 font-semibold">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
        </blockquote>

        {{-- Tanda tangan --}}
        <div class="mt-8 text-right pr-4 md:pr-0">
            <p class="text-navy-blue font-semibold text-lg">
                {{ $settings['principal_name'] ?? 'Bpk. Kepala Sekolah' }}
            </p>
            <p class="text-sm text-gray-500">Kepala Madrasah</p>
        </div>
    </div>
</div>
@endsection
