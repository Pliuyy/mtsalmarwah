{{-- resources/views/components/hero_carousel.blade.php - Video Background Sederhana --}}
<section class="relative w-full overflow-hidden mb-8" style="height: 450px;">
    @if($carousels->isNotEmpty() && $carousels->first()->type === 'video')
        @php
            $videoSlide = $carousels->first(); // Ambil slide pertama (yang diharapkan adalah video background)
            // URL embed YouTube untuk video background otomatis, looping, dan mute
            // Parameter kunci: autoplay=1, mute=1, loop=1, playlist=VIDEO_ID (playlist diperlukan untuk looping)
            $youtubeEmbedUrl = "https://www.youtube.com/embed/{$videoSlide->video_url}?controls=0&modestbranding=1&rel=0&autoplay=1&mute=1&loop=1&playlist={$videoSlide->video_url}";
        @endphp
        
        {{-- Iframe Video sebagai Background --}}
        <iframe
            class="absolute block w-full h-full object-cover top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
            src="{{ $youtubeEmbedUrl }}"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>

        {{-- Overlay Konten Teks dan Tombol --}}
        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center text-white p-8 text-center">
            <h2 class="text-5xl font-bold mb-4">{{ $videoSlide->title }}</h2>
            <p class="text-xl mb-8">{{ $videoSlide->subtitle }}</p>
            @if($videoSlide->button_text && $videoSlide->button_link)
                <a href="{{ $videoSlide->button_link }}" class="bg-yellow-400 hover:bg-yellow-500 text-navy-blue font-bold py-3 px-10 rounded-full transition duration-300 text-2xl shadow-lg">
                    {{ $videoSlide->button_text }}
                </a>
            @endif
        </div>
    @else
        {{-- Fallback jika tidak ada video di database atau Carousel kosong --}}
        <div class="absolute inset-0 bg-royal-blue flex flex-col items-center justify-center text-white p-8 text-center">
            <h2 class="text-5xl font-bold mb-4">Selamat Datang di Website Sekolah Kami</h2>
            <p class="text-xl mb-8">Mencetak Generasi Unggul Berkarakter dan Berakhlak Mulia</p>
            <a href="{{ url('/ppdb') }}" class="bg-navy-blue hover:bg-sky-blue text-white font-bold py-3 px-10 rounded-full transition duration-300 text-2xl shadow-lg">Daftar PPDB Sekarang!</a>
        </div>
    @endif
</section>
@push('scripts')
    {{-- Tidak ada JavaScript khusus Flowbite atau carousel di sini lagi --}}
@endpush