@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
        
        {{-- Gambar Utama Berita --}}
        @if ($news->thumbnail)
            <img src="{{ asset('storage/' . $news->thumbnail) }}" 
                alt="{{ $news->title }}" 
                class="w-full max-h-[500px] object-contain bg-gray-100">
        @else
            <img src="https://via.placeholder.com/800x450/000080/FFFFFF?text=Gambar+Berita"
                alt="Gambar Berita" 
                class="w-full max-h-[500px] object-contain bg-gray-100">
        @endif

        <div class="p-8">
            <h1 class="text-3xl md:text-4xl font-extrabold text-navy-blue mb-3">{{ $news->title }}</h1>
            
            <p class="text-gray-600 text-sm mb-6 flex items-center gap-4 flex-wrap">
                <span>
                    <i class="far fa-calendar-alt mr-1"></i> 
                    {{ $news->published_at->format('d F Y') }}
                </span>
                <span>
                    <i class="fas fa-user-edit mr-1"></i> 
                    Oleh: <span class="font-semibold text-royal-blue">{{ $news->author->name ?? 'Admin' }}</span>
                </span>
            </p>

            <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                {!! nl2br(e($news->content)) !!}
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('news') }}" class="bg-royal-blue hover:bg-navy-blue text-white font-semibold py-3 px-6 rounded-full transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Berita
                </a>
            </div>
        </div>
    </article>
</div>
@endsection
