@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container px-4 mx-auto">
    {{-- Carousel Dinamis: Menggantikan Hero Section statis --}}
    @include('components.hero_carousel')

    {{-- Status Pendaftaran & Periode Pendaftaran --}}
    @if(isset($settings['ppdb_status']) && isset($settings['ppdb_start_date']) && isset($settings['ppdb_end_date']))
    <div class="relative bg-gray-300 border border-gray-300 text-black py-5 px-6 rounded-3xl overflow-hidden shadow-lg mb-8">
        <div class="absolute top-2 left-0 w-full h-full animate-marquee whitespace-nowrap">
            <p class="inline-block text-lg font-semibold tracking-wide">
                📢 Pendaftaran PPDB saat ini
                @if($settings['ppdb_status'] === 'open')
                <span class="text-lime-200">DIBUKA</span>
                @else
                <span class="text-red-300">DITUTUP</span>
                @endif
                &nbsp;&nbsp;|&nbsp;&nbsp;
                Periode: {{ \Carbon\Carbon::parse($settings['ppdb_start_date'])->translatedFormat('d F Y') }}
                - {{ \Carbon\Carbon::parse($settings['ppdb_end_date'])->translatedFormat('d F Y') }}
                &nbsp;&nbsp;|&nbsp;&nbsp; Silakan cek informasi lengkap di bawah atau hubungi kontak yang tersedia.
            </p>
        </div>
    </div>

    {{-- Animasi Marquee (Tailwind + Custom CSS) --}}
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
    </style>
    @endif

    <div class="grid grid-cols-1 gap-8 mb-12 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            <section class="p-8 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-3xl font-bold text-navy-blue">Sekolah Kami</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="mb-4 leading-relaxed text-gray-700">
                           {{ Str::limit($settings['school_description'] ?? '', 300) }}
                        </p>
                    </div>
                    <div>
                        <div class="flex items-center justify-center h-48 overflow-hidden text-gray-500 bg-gray-200 rounded-lg">
                            @if($youtubeVideoCarousel)
                            <div class="w-full h-full aspect-video relative">
                                <iframe width="100%" height="100%"
                                    src="https://www.youtube.com/embed/{{ $youtubeVideoCarousel->video_url }}?autoplay=1&mute=1&controls=0&modestbranding=1&rel=0&loop=1&playlist={{ $youtubeVideoCarousel->video_url }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    class="w-full h-full">
                                </iframe>

                                <!-- Overlay transparan -->
                                <div class="absolute inset-0 z-10" style="background: transparent;"></div>
                            </div>
                            @else
                            <span class="text-sm text-gray-500">Belum ada video tersedia.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="p-8 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-3xl font-bold text-navy-blue">Visi dan Misi</h2>
                <h3 class="mb-2 text-xl font-semibold text-royal-blue">1. Visi</h3>
                <p class="mb-6 leading-relaxed text-gray-700">
                    {{ $settings['school_vision'] ?? '' }}
                </p>
                <ul class="space-y-2 leading-relaxed text-gray-700 list-disc list-inside mb-6">
                    <li>{{ $settings['school_vision_1'] ?? '' }}</li>
                    <li>{{ $settings['school_vision_2'] ?? '' }}</li>
                    <li>{{ $settings['school_vision_3'] ?? '' }}</li>
                    <li>{{ $settings['school_vision_4'] ?? '' }}</li>
                    <li>{{ $settings['school_vision_5'] ?? '' }}</li>
                </ul>

                <h3 class="mb-2 text-xl font-semibold text-royal-blue">2. Misi</h3>
                <ul class="space-y-2 leading-relaxed text-gray-700 list-disc list-inside">
                    <li>{{ $settings['school_mission_1'] ?? '' }}</li>
                    <li>{{ $settings['school_mission_2'] ?? '' }}</li>
                    <li>{{ $settings['school_mission_3'] ?? '' }}</li>
                    <li>{{ $settings['school_mission_4'] ?? '' }}</li>
                    <li>{{ $settings['school_mission_5'] ?? '' }}</li>
                </ul>
                <div class="mt-4 text-right">
                    <a href="{{ url('/profil/sejarah') }}" class="text-sm text-royal-blue hover:underline">Baca Selengkapnya Visi & Misi</a>
                </div>
            </section>

            <section class="p-8 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-3xl font-bold text-navy-blue">Berita Terbaru</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @forelse ($latestNews as $newsItem)
                    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md">
                        <img src="https://via.placeholder.com/400x250/4169E1/FFFFFF?text=Berita" alt="{{ $newsItem->title }}" class="object-cover w-full h-40">
                        <div class="p-4">
                            <h3 class="mb-1 text-lg font-semibold text-navy-blue">{{ Str::limit($newsItem->title, 50) }}</h3>
                            <p class="mb-2 text-sm text-gray-600">{{ $newsItem->published_at->format('d F Y') }}</p>
                            <p class="text-sm text-gray-700">{{ Str::limit($newsItem->content, 80) }}</p>
                            <a href="{{ route('news.detail', $newsItem->slug) }}" class="inline-block mt-3 text-sm text-royal-blue hover:underline">Baca Selengkapnya</a>
                        </div>
                    </div>
                    @empty
                    <p class="col-span-3 text-center text-gray-600">Belum ada berita terbaru.</p>
                    @endforelse
                </div>
                <div class="mt-8 text-center">
                    <a href="{{ route('news') }}" class="px-6 py-3 font-bold text-white transition duration-300 rounded-full bg-navy-blue hover:bg-royal-blue">Lihat Semua Berita</a>
                </div>
            </section>
        </div>

        <div class="space-y-8 lg:col-span-1">
            <section class="p-8 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-3xl font-bold text-navy-blue">Galeri Kami</h2>
                <div class="grid grid-cols-1 gap-4">
                    {{-- Loop 3-4 item galeri terbaru/random --}}
                    @forelse($latestGalleryItems as $galleryItem)
                    <div class="relative h-40 overflow-hidden bg-gray-200 rounded-lg">
                        @if($galleryItem->type === 'photo')
                        <img src="https://via.placeholder.com/400x200/{{ rand(0, 999999) }}?text=Foto" alt="{{ $galleryItem->title }}" class="absolute inset-0 object-cover w-full h-full">
                        @elseif($galleryItem->type === 'video')
                        <div class="absolute inset-0 flex items-center justify-center w-full h-full bg-black">
                            <img src="https://img.youtube.com/vi/{{ $galleryItem->video_id ?: $galleryItem->file_path }}/hqdefault.jpg"
                                alt="{{ $galleryItem->title }}"
                                class="absolute inset-0 object-cover w-full h-full opacity-70">
                            <a href="https://www.youtube.com/watch?v={{ $galleryItem->video_id ?: $galleryItem->file_path }}" target="_blank"
                                class="absolute inset-0 flex items-center justify-center text-5xl text-white transition-all bg-black bg-opacity-50 hover:bg-opacity-70">
                                <i class="fas fa-play-circle"></i>
                            </a>
                        </div>
                        @endif
                        <div class="absolute inset-x-0 bottom-0 flex items-end p-2 text-white bg-black bg-opacity-60 h-1/4">
                            <span class="text-sm font-semibold truncate">{{ $galleryItem->title }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-600">Belum ada foto/video galeri.</p>
                    @endforelse
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('gallery') }}" class="inline-block px-4 py-2 text-sm font-bold text-white transition duration-300 rounded-full bg-navy-blue hover:bg-royal-blue">Lihat Semua Galeri</a>
                </div>
            </section>

            <section class="p-8 text-center bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-3xl font-bold text-navy-blue">Kepala Sekolah</h2>

                @if(!empty($settings['principal_photo']))
                <img src="{{ asset('storage/' . $settings['principal_photo']) }}"
                    alt="Foto Kepala Sekolah"
                    class="object-cover w-32 h-32 mx-auto mb-4 border-4 rounded-full border-royal-blue">
                @else
                <img src="https://via.placeholder.com/128x128/4169E1/FFFFFF?text=KS"
                    alt="Placeholder Foto Kepala Sekolah"
                    class="object-cover w-32 h-32 mx-auto mb-4 border-4 rounded-full border-royal-blue">
                @endif

                <h3 class="mb-2 text-xl font-semibold text-navy-blue">
                    {{ $settings['principal_name'] ?? 'Bpk. Kepala Sekolah' }}
                </h3>

                <p class="text-sm italic leading-relaxed text-gray-700">
                    {{ Str::limit($settings['kepala_sekolah_sambutan'] ?? '', 150) }}
                </p>

                <div class="mt-4 text-center">
                    <a href="{{ route('profile.principal') }}" class="text-sm text-royal-blue hover:underline">
                        Selengkapnya <i class="ml-1 fas fa-arrow-right"></i>
                    </a>
                </div>
            </section>

            <section class="p-8 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-3xl font-bold text-navy-blue">Pengumuman Terbaru</h2>
                @if($latestEvents->isEmpty())
                <p class="text-gray-600">Belum ada pengumuman terbaru.</p>
                @else
                <ul class="space-y-4">
                    @foreach($latestEvents as $event)
                    <li class="pb-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold leading-tight text-navy-blue">{{ $event->title }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            <i class="mr-1 far fa-calendar-alt"></i> {{ $event->date->format('d F Y') }}
                            @if($event->time) | <i class="mr-1 far fa-clock"></i> {{ $event->time }}@endif
                        </p>
                        <a href="{{ route('events') }}" class="inline-block mt-2 text-xs text-royal-blue hover:underline">Baca Selengkapnya</a>
                    </li>
                    @endforeach
                </ul>
                @endif
                <div class="mt-6 text-center">
                    <a href="{{ route('events') }}" class="inline-block px-4 py-2 text-sm font-bold text-white transition duration-300 rounded-full bg-navy-blue hover:bg-royal-blue">Lihat Semua Kegiatan</a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection