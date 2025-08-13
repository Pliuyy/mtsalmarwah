@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
<div class="flex flex-col-reverse md:flex-row items-center justify-center min-h-screen px-6 py-12 bg-gradient-to-br from-slate-100 to-white">
    {{-- Teks --}}
    <div class="text-center md:text-left md:w-1/2">
        <h1 class="text-7xl font-black text-royal-blue mb-4 leading-none">404</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Kamu nyasar ke dunia lain 🚀</h2>
        <p class="text-gray-600 mb-6 max-w-md">Halaman yang kamu cari tidak tersedia, mungkin sudah dipindahkan, dihapus, atau kamu sedang eksplorasi tanpa peta.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 font-medium text-white bg-royal-blue hover:bg-navy-blue rounded-lg shadow transition duration-300">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7 7-7"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    {{-- Ilustrasi --}}
    <div class="md:w-1/2 mb-10 md:mb-0">
        <img src="https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif" alt="404 Illustration" class="w-full max-w-md mx-auto">
    </div>
</div>
@endsection
