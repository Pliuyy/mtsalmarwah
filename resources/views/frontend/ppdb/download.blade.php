@extends('layouts.app')

@section('title', 'Download Sumber Daya PPDB')

@section('content')
<div class="container mx-auto px-4">

@include('components.hero_carousel')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-1">
            @include('frontend.ppdb.ppdb_sidebar')
        </div>

        <div class="lg:col-span-3 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-navy-blue mb-6">Unduh Berbagai Sumber Daya PPDB</h2>
            <p class="text-gray-700 leading-relaxed text-lg mb-8">
                Temukan dokumen-dokumen penting yang dapat Anda unduh untuk informasi lebih lanjut mengenai proses PPDB {{ $settings['school_name'] ?? 'Nama Sekolah' }}.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($resources as $resource)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center flex flex-col items-center justify-between">
                        <i class="{{ $resource['icon'] }} text-royal-blue text-5xl mb-4"></i>
                        <h3 class="font-semibold text-navy-blue text-xl mb-2">{{ $resource['title'] }}</h3>
                        <p class="text-gray-700 text-sm mb-4 flex-grow">{{ $resource['description'] }}</p>
                        <a href="{{ asset('storage/ppdb_resources/' . $resource['file_path']) }}" target="_blank" class="bg-royal-blue hover:bg-navy-blue text-white font-bold py-2 px-6 rounded-full transition duration-300 inline-block text-sm">
                            <i class="fas fa-download mr-2"></i> Unduh {{ Str::before($resource['title'], '(') }}
                        </a>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-600">Belum ada sumber daya yang tersedia untuk diunduh.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection