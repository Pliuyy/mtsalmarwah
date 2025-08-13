@extends('layouts.app')

@section('title', 'Informasi Kegiatan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-navy-blue mb-8 text-center">Kegiatan Sekolah Kami</h1>
    <p class="text-lg text-center text-gray-700 mb-10">Lihat jadwal dan informasi acara-acara terbaru di sekolah.</p>

    @if($events->isEmpty())
        <p class="text-center text-gray-600">Belum ada kegiatan yang tersedia saat ini.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($events as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
                    <img src="{{ asset('storage/' . $event->photo) }}" alt="{{ $event->title }}" class="w-full aspect-[4/3]">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-navy-blue mb-2">{{ $event->title }}</h2>
                        <p class="text-gray-600 text-sm mb-4">
                            <i class="far fa-calendar-alt mr-1"></i> {{ $event->date->format('d F Y') }}
                            @if($event->time) <span class="mx-1">|</span> <i class="far fa-clock mr-1"></i> {{ $event->time }} @endif
                            @if($event->location) <span class="mx-1">|</span> <i class="fas fa-map-marker-alt mr-1"></i> {{ $event->location }} @endif
                        </p>
                        <p class="text-gray-700 leading-relaxed">{{ Str::limit($event->description, 250) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection