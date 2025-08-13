@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-navy-blue mb-8 text-center">Profil Staff-Staff Kami</h1>
    <p class="text-lg text-center text-gray-700 mb-10">Dedikasi dan keahlian para guru adalah pilar utama pendidikan di sekolah kami.</p>

    @if($staffs->isEmpty())
    <p class="text-center text-gray-600">Belum ada data guru yang tersedia saat ini.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($staffs as $staff)
        <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
            {{-- Foto guru dari storage atau fallback placeholder --}}
            @if($staff->photo)
            <div class="w-full aspect-[4/3]">
                <img src="{{ asset('storage/' . $staff->photo) }}" alt="{{ $staff->name }}"
                    class="w-full h-full object-cover">
            </div>
            @else
            <img src="https://via.placeholder.com/400x400/000080/FFFFFF?text=Guru" alt="Foto tidak tersedia" class="w-full h-64 object-cover">
            @endif
            <div class="p-6 text-center">
                <h2 class="text-2xl font-semibold text-navy-blue mb-2">{{ $staff->name }}</h2>
                <p class="text-royal-blue font-medium mb-2">{{ $staff->subject }}</p>
                <p class="mb-4 text-sm text-gray-600">
                    <i class="mr-1 far fa-calendar-alt"></i> Update : {{ \Carbon\Carbon::parse($staff->published_at)->format('d F Y') }}
                </p>
                <p class="text-gray-700 mt-4 leading-relaxed">{{ Str::limit($staff->bio, 150) }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection