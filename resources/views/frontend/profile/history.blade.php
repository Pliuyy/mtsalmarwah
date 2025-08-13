@extends('layouts.app')

@section('title', 'Visi dan Misi Sekolah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-navy-blue mb-8 text-center">Visi dan Misi Kami</h1>
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-3xl mx-auto mb-10">
        <h2 class="text-3xl font-semibold text-royal-blue mb-6 border-b-2 border-royal-blue pb-2">Visi Sekolah</h2>
        <p class="text-gray-800 leading-relaxed text-lg mb-8">
            {{ $settings['school_vision'] ?? 'Visi sekolah belum diatur. Harap tambahkan melalui panel admin.' }}
        </p>
        <ul class="list-disc list-inside text-gray-800 leading-relaxed text-lg space-y-3 mb-6">
            <li>{{ $settings['school_vision_1'] ?? 'Visi pertama belum diatur.' }}</li>
            <li>{{ $settings['school_vision_2'] ?? 'Visi kedua belum diatur.' }}</li>
            <li>{{ $settings['school_vision_3'] ?? 'Visi ketiga belum diatur.' }}</li>
            <li>{{ $settings['school_vision_4'] ?? 'Visi keempat belum diatur.' }}</li>
            <li>{{ $settings['school_vision_5'] ?? 'Visi kelima belum diatur.' }}</li>
        </ul>

        <h2 class="text-3xl font-semibold text-royal-blue mb-6 border-b-2 border-royal-blue pb-2">Misi Sekolah</h2>
        <ul class="list-disc list-inside text-gray-800 leading-relaxed text-lg space-y-3">
            <li>{{ $settings['school_mission_1'] ?? 'Misi pertama belum diatur.' }}</li>
            <li>{{ $settings['school_mission_2'] ?? 'Misi kedua belum diatur.' }}</li>
            <li>{{ $settings['school_mission_3'] ?? 'Misi ketiga belum diatur.' }}</li>
            <li>{{ $settings['school_mission_4'] ?? 'Misi keempat belum diatur.' }}</li>
            <li>{{ $settings['school_mission_5'] ?? 'Misi kelima belum diatur.' }}</li>
        </ul>
    </div>
</div>
@endsection