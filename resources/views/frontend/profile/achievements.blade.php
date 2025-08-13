@extends('layouts.app')

@section('title', 'Murid Berprestasi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-navy-blue mb-8 text-center">Murid Berprestasi</h1>
    <p class="text-lg text-center text-gray-700 mb-10">Karya dan pencapaian gemilang siswa-siswi kami.</p>

    @if($achievements->isEmpty())
    <p class="text-center text-gray-600">Belum ada data murid berprestasi yang tersedia saat ini.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($achievements as $achievement)
        <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
            @if($achievement->photo)
            <div class="w-full aspect-[1/1]">
                <img src="{{ asset('storage/' . $achievement->photo) }}" alt="{{ $achievement->name }}"
                    class="w-full h-full object-cover">
            </div>
            @else
            <img src="https://via.placeholder.com/400x400/000080/FFFFFF?text=Guru" alt="Foto tidak tersedia" class="w-full h-64 object-cover">
            @endif
            <div class="p-6 text-center">
                <h2 class="text-2xl font-semibold text-navy-blue mb-2">{{ $achievement->student_name }}</h2>
                <p class="text-royal-blue font-medium mb-2">{{ $achievement->achievement }}</p>
                <p class="mb-4 text-sm text-gray-600">
                    <i class="mr-1 far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($achievement->published_at)->format('d F Y') }}
                    <span class="mx-2">|</span>
                    <i class="mr-1 fas fa-user-edit"></i> {{ $achievement->author->name ?? 'Admin' }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection