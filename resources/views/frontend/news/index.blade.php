@extends('layouts.app')

@section('title', 'Berita Sekolah')

@section('content')
<div class="container px-4 py-8 mx-auto">
    <h1 class="mb-8 text-4xl font-bold text-center text-navy-blue">Berita Terbaru</h1>

    @if($allNews->isEmpty())
        <p class="text-center text-gray-600">Belum ada berita yang tersedia saat ini.</p>
    @else
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($allNews as $newsItem)
                <div class="overflow-hidden transition duration-300 transform bg-white rounded-lg shadow-md hover:scale-105">
                    
                    {{-- Gambar berita dari storage atau fallback placeholder --}}
                    @if($newsItem->thumbnail)
                        <img src="{{ asset('storage/' . $newsItem->thumbnail) }}" alt="{{ $newsItem->title }}" class="object-cover w-full h-56">
                    @else
                        <img src="https://placehold.jp/400x250.png" alt="{{ $newsItem->title }}" class="object-cover w-full h-56">
                    @endif

                    <div class="p-6">
                        <h2 class="mb-2 text-xl font-semibold text-navy-blue">{{ $newsItem->title }}</h2>
                        <p class="mb-4 text-sm text-gray-600">
                            <i class="mr-1 far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($newsItem->published_at)->format('d F Y') }}
                            <span class="mx-2">|</span>
                            <i class="mr-1 fas fa-user-edit"></i> {{ $newsItem->author->name ?? 'Admin' }}
                        </p>
                        <p class="mb-4 leading-relaxed text-gray-700">
                            {{ \Illuminate\Support\Str::limit(strip_tags($newsItem->content), 150) }}
                        </p>
                        <a href="{{ route('news.detail', $newsItem->slug) }}" class="font-semibold text-royal-blue hover:underline">
                            Baca Selengkapnya <i class="ml-1 text-sm fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $allNews->links() }}
        </div>
    @endif
</div>
@endsection
