@extends('layouts.app')

@section('title', 'Galeri Sekolah')

@section('content')
<div class="container px-4 mx-auto">
    @include('components.hero_carousel')

    <div id="gallery-content" class="p-8 bg-white rounded-lg shadow-lg">
        <div class="pb-4 mb-8 border-b">
            <h2 class="mb-4 text-2xl font-bold text-navy-blue">Filter Galeri</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('gallery') }}" class="px-5 py-2 font-semibold transition duration-300 rounded-full gallery-category-link" data-category-id="">
                    Semua
                </a>
                @foreach($categories as $category)
                <a href="{{ route('gallery', ['category' => $category->id]) }}" class="px-5 py-2 font-semibold transition duration-300 rounded-full gallery-category-link" data-category-id="{{ $category->id }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>

        <section class="mb-8">
            <h2 class="flex items-center mb-4 text-3xl font-bold text-navy-blue">
                <i class="mr-3 fas fa-camera-retro"></i> Galeri Foto Kami
            </h2>
            <p class="mb-6 text-gray-700">Kumpulan foto kegiatan belajar mengajar, ekstrakurikuler, acara sekolah, dan prestasi siswa.</p>

            @php
            $filteredPhotos = $galleries->where('type', 'photo');
            if (request('category')) {
                $filteredPhotos = $filteredPhotos->where('gallery_category_id', (int)request('category'));
            }
            @endphp

            @if($filteredPhotos->isEmpty())
            <p class="text-center text-gray-600">Tidak ada foto di kategori ini.</p>
            @else
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach($filteredPhotos as $photo)
                @php
                // Perbaikan path gambar - menggunakan asset() helper untuk generate URL yang benar
                $imagePath = $photo->file_path ? asset('storage/' . $photo->file_path) : asset('images/default-image.jpg');
                @endphp
                <div class="relative flex items-center justify-center h-40 overflow-hidden bg-gray-200 rounded-lg cursor-pointer group"
                    onclick="openLightbox('{{ $imagePath }}', '{{ addslashes($photo->title) }}')">
                    <img src="{{ $imagePath }}" alt="{{ $photo->title }}" class="absolute inset-0 object-cover w-full h-full transition-transform duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black opacity-0 bg-opacity-40 group-hover:opacity-100">
                        <i class="text-3xl text-white fas fa-search-plus"></i>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 flex items-end p-2 text-white bg-black bg-opacity-60 h-1/4">
                        <span class="text-sm font-semibold truncate">{{ $photo->title }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </section>

        <section class="mt-12">
            <h2 class="flex items-center mb-4 text-3xl font-bold text-navy-blue">
                <i class="mr-3 fas fa-video"></i> Galeri Video Kami
            </h2>
            <p class="mb-6 text-gray-700">Kumpulan dokumentasi kegiatan dan profil MTS Al Marwah.</p>

            @php
            $filteredVideos = $galleries->where('type', 'video');
            if (request('category')) {
                $filteredVideos = $filteredVideos->where('gallery_category_id', (int)request('category'));
            }
            @endphp

            @if($filteredVideos->isEmpty())
            <p class="text-center text-gray-600">Tidak ada video di kategori ini.</p>
            @else
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach($filteredVideos as $video)
                <div class="relative flex items-center justify-center h-40 overflow-hidden bg-gray-200 rounded-lg cursor-pointer group"
                    onclick="openLightboxVideo('{{ $video->video_id ?: $video->file_path }}')">
                    <img src="https://img.youtube.com/vi/{{ $video->video_id ?: $video->file_path }}/hqdefault.jpg" alt="{{ $video->title }}" class="absolute inset-0 object-cover w-full h-full transition-transform duration-300 group-hover:scale-105 opacity-70">
                    <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black opacity-0 bg-opacity-40 group-hover:opacity-100">
                        <i class="text-3xl text-white fas fa-play-circle"></i>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 flex items-end p-2 text-white bg-black bg-opacity-60 h-1/4">
                        <span class="text-sm font-semibold truncate">{{ $video->title }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </section>
    </div>

    <div id="lightbox" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-80" onclick="closeLightbox()">
        <div class="relative max-w-4xl max-h-full p-4 overflow-auto bg-white rounded-lg" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[80vh] object-contain">
            <p id="lightbox-caption" class="mt-4 text-lg text-center text-gray-800"></p>
            <button class="absolute flex items-center justify-center w-8 h-8 text-xl text-white bg-red-500 rounded-full top-2 right-2" onclick="closeLightbox()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div id="lightbox-video" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-80" onclick="closeLightboxVideo()">
        <div class="relative max-w-4xl max-h-full p-4 overflow-auto bg-white rounded-lg" onclick="event.stopPropagation()">
            <div id="lightbox-video-player" class="w-full h-96 md:h-[500px] lg:h-[600px]">
                <!-- Video iframe akan diinject di sini -->
            </div>
            <button class="absolute flex items-center justify-center w-8 h-8 text-xl text-white bg-red-500 rounded-full top-2 right-2" onclick="closeLightboxVideo()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        // Lightbox Image
        function openLightbox(src, caption) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-caption').innerText = caption;
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Mencegah scroll saat lightbox terbuka
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox-img').src = '';
            document.getElementById('lightbox-caption').innerText = '';
            document.body.style.overflow = ''; // Mengembalikan scroll
        }

        // Lightbox Video
        function openLightboxVideo(videoId) {
            const videoPlayer = document.getElementById('lightbox-video-player');
            videoPlayer.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1&modestbranding=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full rounded-md"></iframe>`;
            document.getElementById('lightbox-video').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Mencegah scroll saat lightbox terbuka
        }

        function closeLightboxVideo() {
            document.getElementById('lightbox-video').classList.add('hidden');
            document.getElementById('lightbox-video-player').innerHTML = ''; // Hentikan video saat ditutup
            document.body.style.overflow = ''; // Mengembalikan scroll
        }

        // Handle category filter active state
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const currentCategoryId = urlParams.get('category');

            const allCategoryLink = document.querySelector('a.gallery-category-link[data-category-id=""]');

            if (allCategoryLink) {
                // Hapus kelas aktif dari semua link terlebih dahulu
                document.querySelectorAll('.gallery-category-link').forEach(link => {
                    link.classList.remove('bg-royal-blue', 'text-white');
                    link.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                });

                // Set 'Semua' active jika tidak ada kategori yang dipilih
                if (!currentCategoryId || currentCategoryId === '') {
                    allCategoryLink.classList.add('bg-royal-blue', 'text-white');
                    allCategoryLink.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                } else {
                    // Set active berdasarkan data-category-id
                    const activeLink = document.querySelector(`a.gallery-category-link[data-category-id="${currentCategoryId}"]`);
                    if (activeLink) {
                        activeLink.classList.add('bg-royal-blue', 'text-white');
                        activeLink.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                    }
                }
            }
        });
    </script>
    @endpush
</div>
@endsection