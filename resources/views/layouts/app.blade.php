<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Sekolah Kita - @yield('title')</title>

    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        /* Animasi untuk mobile menu */
        .mobile-menu {
            transition: all 0.3s ease;
            max-height: 0;
            overflow: hidden;
        }
        
        .mobile-menu.open {
            max-height: 1000px;
        }
        
        /* Dropdown menu mobile */
        .mobile-dropdown {
            transition: all 0.3s ease;
            max-height: 0;
            overflow: hidden;
        }
        
        .mobile-dropdown.open {
            max-height: 500px;
        }
        
        /* Notifikasi dropdown responsif */
        @media (max-width: 767px) {
            #notification-dropdown {
                position: fixed;
                right: 10px !important;
                left: auto !important;
                width: calc(100vw - 20px) !important;
                max-width: 350px !important;
                max-height: 70vh;
                overflow-y: auto;
            }
        }
        
        /* Hamburger button */
        #mobile-menu-button {
            transition: transform 0.3s ease;
            z-index: 50;
        }
        
        #mobile-menu-button.open {
            transform: rotate(90deg);
        }
        
        /* Navbar sticky */
        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 40;
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            right: -1px;
            top: -1px;
            display: flex;
            height: 1rem;
            width: 1rem;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background-color: #ef4444;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
        }
    </style>
</head>

@if (Route::currentRouteName() === 'home')
    @include('components.loading')
@endif

<body class="bg-gray-100 font-poppins text-gray-800">

    @php
        $settings = App\Models\Setting::pluck('value', 'key')->toArray();
        $schoolName = $settings['school_name'] ?? 'Nama Sekolah Default';
        $schoolTagline = $settings['school_tagline'] ?? 'Mencetak Umat Tataqurahu Fie Al Din wa Ziyadatil Khair';
        $schoolLogo = $settings['school_logo'] ?? null;
    @endphp

    {{-- Top Header --}}
    <div class="bg-white py-4 shadow-sm">
        <div class="container mx-auto flex flex-wrap items-center justify-between px-4">
            <div class="flex items-center space-x-3">
                <a href="{{ url('/') }}" class="flex items-center space-x-3">
                    @if($schoolLogo && file_exists(public_path('storage/' . $schoolLogo)))
                    <img src="{{ asset('storage/' . $schoolLogo) }}" alt="Logo Sekolah"
                        class="h-12 w-auto rounded-full md:h-14">
                    @else
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-300 md:h-14 md:w-14">
                        <i class="fas fa-school text-xl text-gray-600"></i>
                    </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="text-xl font-bold text-navy-blue md:text-2xl">{{ $schoolName }}</span>
                        <span class="text-xs text-gray-600 md:text-sm">{{ $schoolTagline }}</span>
                    </div>
                </a>
            </div>

            <div class="mt-2 flex items-center space-x-4 md:mt-0">
                {{-- Jam Digital --}}
                <div class="hidden items-center justify-center md:flex">
                    <div class="rounded-lg bg-gray-200 px-4 py-2 text-l font-semibold text-gray-900 shadow-sm">
                        <span id="digital-clock">00:00:00</span>
                    </div>
                </div>

                {{-- Notification Icon --}}
                <div class="relative z-50" id="notification-bell-container">
                    <button id="notification-bell"
                        class="relative cursor-pointer text-xl text-gray-700 hover:text-royal-blue focus:outline-none">
                        <i class="fas fa-bell"></i>
                        @php
                        $unreadNewsCount = \App\Models\News::where('published_at', '>', session('last_viewed_news', now()->subDays(7)))->count();
                        $totalNewsForDropdown = \App\Models\News::latest()->take(5)->get();
                        $newsCountForBadge = $totalNewsForDropdown->count();
                        @endphp
                        @if ($newsCountForBadge > 0)
                        <span class="notification-badge">
                            {{ $newsCountForBadge }}
                        </span>
                        @endif
                    </button>

                    <div id="notification-dropdown"
                        class="absolute right-0 top-full hidden w-72 rounded-md border border-gray-200 bg-white shadow-lg md:w-80">
                        <div class="border-b border-gray-200 px-4 py-2 text-sm font-semibold text-navy-blue">
                            Notifikasi Terbaru
                        </div>
                        @if ($totalNewsForDropdown->isEmpty())
                        <div class="px-4 py-2 text-sm text-gray-600">Tidak ada notifikasi baru.</div>
                        @else
                        <ul class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                            @foreach ($totalNewsForDropdown as $newsItem)
                            <li>
                                <a href="{{ route('news.detail', $newsItem->slug) }}"
                                    class="block px-4 py-3 transition duration-150 hover:bg-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ Str::limit($newsItem->title, 40) }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-600">
                                        {{ $newsItem->published_at->diffForHumans() }}
                                    </p>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="border-t border-gray-200 px-4 py-2 text-center">
                            <a href="{{ route('news') }}" class="text-sm text-royal-blue hover:underline">
                                Lihat Semua Berita
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Navigation Header --}}
    <header class="bg-navy-blue py-4 shadow-md sticky-nav">
        <div class="container mx-auto px-4">
            <nav class="flex items-center justify-between">
                {{-- Tombol Hamburger untuk Mobile --}}
                <button id="mobile-menu-button" class="text-white focus:outline-none md:hidden">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                {{-- Menu Utama (Desktop) --}}
                <div class="hidden w-full md:block">
                    <ul class="flex justify-center space-x-6 text-lg">
                        <li><a href="{{ url('/') }}"
                                class="text-white transition duration-300 hover:text-royal-blue">Beranda</a></li>
                        <li class="group relative">
                            <a href="#" class="block text-white transition duration-300 hover:text-royal-blue">Tentang Kami
                                <i class="fas fa-caret-down ml-1 text-sm"></i></a>
                            <ul
                                class="group-hover:block absolute z-10 hidden w-48 rounded-md border border-gray-200 bg-white py-2 shadow-lg text-gray-800">
                                <li><a href="{{ url('/profil/sekolah') }}"
                                        class="whitespace-nowrap block px-4 py-2 hover:bg-gray-200">Profil Sekolah</a></li>
                                <li><a href="{{ url('/profil/guru') }}"
                                        class="whitespace-nowrap block px-4 py-2 hover:bg-gray-200">Profil Guru</a></li>
                                <li><a href="{{ url('/profil/staf') }}"
                                        class="whitespace-nowrap block px-4 py-2 hover:bg-gray-200">Profil Staf</a></li>
                                <li><a href="{{ url('/profil/berprestasi') }}"
                                        class="whitespace-nowrap block px-4 py-2 hover:bg-gray-200">Murid Berprestasi</a>
                                </li>
                                <li><a href="{{ url('/profil/kepala-sekolah') }}"
                                        class="whitespace-nowrap block px-4 py-2 hover:bg-gray-200">Kepala Sekolah</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('/profil/sejarah') }}"
                                class="text-white transition duration-300 hover:text-royal-blue">Visi dan Misi</a></li>
                        <li><a href="{{ url('/ppdb') }}"
                                class="text-white transition duration-300 hover:text-royal-blue">PPDB {{ date('Y') }}</a>
                        </li>
                        <li><a href="{{ url('/galeri') }}"
                                class="text-white transition duration-300 hover:text-royal-blue ">Galeri</a></li>
                        <li>
                            <a href="{{ route('contact') }}"
                                class="text-white transition duration-300 hover:text-royal-blue {{ request()->is('kontak') }}">
                                Kontak
                            </a>
                        </li>
                        <li class="group relative">
                            <a href="#"
                                class="block text-white transition duration-300 hover:text-royal-blue">Tautan <i
                                    class="fas fa-caret-down ml-1 text-sm"></i></a>
                            <ul
                                class="group-hover:block absolute z-10 hidden w-48 rounded-md border border-gray-200 bg-white py-2 shadow-lg text-gray-800">
                                <li><a href="{{ url('/ekskul') }}"
                                        class="whitespace-nowrap block px-4 py-2 hover:bg-gray-200">Ekstrakurikuler</a></li>
                                <li><a href="{{ url('/kegiatan') }}"
                                        class="whitespace-nowrap block px-4 py-2 hover:bg-gray-200">Kegiatan</a></li>
                                <li><a href="{{ url('/berita') }}"
                                        class="whitespace-nowrap block px-4 py-2 hover:bg-gray-200">Berita</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            
            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="mobile-menu w-full bg-navy-blue text-white md:hidden">
                <ul class="flex flex-col space-y-0 py-2 text-lg">
                    <li><a href="{{ url('/') }}" class="block px-4 py-3 hover:bg-navy-blue-dark hover:text-royal-blue">Beranda</a></li>
                    <li>
                        <button id="about-dropdown-btn" class="flex w-full items-center justify-between px-4 py-3 hover:bg-navy-blue-dark hover:text-royal-blue">
                            <span>Tentang Kami</span>
                            <i class="fas fa-caret-down ml-2 text-sm transition-transform duration-300" id="about-caret"></i>
                        </button>
                        <ul id="about-dropdown-menu" class="mobile-dropdown bg-navy-blue-dark">
                            <li><a href="{{ url('/profil/sekolah') }}" class="block px-6 py-2 hover:bg-navy-blue-darker">Profil Sekolah</a></li>
                            <li><a href="{{ url('/profil/guru') }}" class="block px-6 py-2 hover:bg-navy-blue-darker">Profil Guru</a></li>
                            <li><a href="{{ url('/profil/staf') }}" class="block px-6 py-2 hover:bg-navy-blue-darker">Profil Staf</a></li>
                            <li><a href="{{ url('/profil/berprestasi') }}" class="block px-6 py-2 hover:bg-navy-blue-darker">Murid Berprestasi</a></li>
                            <li><a href="{{ url('/profil/kepala-sekolah') }}" class="block px-6 py-2 hover:bg-navy-blue-darker">Kepala Sekolah</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/profil/sejarah') }}" class="block px-4 py-3 hover:bg-navy-blue-dark hover:text-royal-blue">Visi dan Misi</a></li>
                    <li><a href="{{ url('/ppdb') }}" class="block px-4 py-3 hover:bg-navy-blue-dark hover:text-royal-blue">PPDB {{ date('Y') }}</a></li>
                    <li><a href="{{ url('/galeri') }}" class="block px-4 py-3 hover:bg-navy-blue-dark hover:text-royal-blue">Galeri</a></li>
                    <li><a href="{{ route('contact') }}" class="block px-4 py-3 hover:bg-navy-blue-dark hover:text-royal-blue">Kontak</a></li>
                    <li>
                        <button id="links-dropdown-btn" class="flex w-full items-center justify-between px-4 py-3 hover:bg-navy-blue-dark hover:text-royal-blue">
                            <span>Tautan</span>
                            <i class="fas fa-caret-down ml-2 text-sm transition-transform duration-300" id="links-caret"></i>
                        </button>
                        <ul id="links-dropdown-menu" class="mobile-dropdown bg-navy-blue-dark">
                            <li><a href="{{ url('/ekskul') }}" class="block px-6 py-2 hover:bg-navy-blue-darker">Ekstrakurikuler</a></li>
                            <li><a href="{{ url('/kegiatan') }}" class="block px-6 py-2 hover:bg-navy-blue-darker">Kegiatan</a></li>
                            <li><a href="{{ url('/berita') }}" class="block px-6 py-2 hover:bg-navy-blue-darker">Berita</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="py-8">
        @yield('content')
    </main>

    <footer class="bg-navy-blue py-10 text-white">
        <div class="container mx-auto px-4">
            <div class="mb-6 flex flex-col flex-wrap justify-between md:flex-row md:space-x-8">

                {{-- Kolom 1: Info Kontak --}}
                <div class="mb-6 w-full md:mb-0 md:w-1/3">
                    <h4 class="mb-4 text-lg font-semibold text-yellow-400">Kontak Kami</h4>
                    <div class="mb-3 flex items-start">
                        <i class="fas fa-map-marker-alt mr-3 text-xl text-yellow-400"></i>
                        <span>{{ $settings['school_address'] ?? 'Alamat Sekolah Default' }}</span>
                    </div>
                    <div class="mb-3 flex items-center">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['school_phone'] ?? '0000000000') }}"
                            target="_blank"
                            class="flex items-center hover:underline">
                            <i class="fab fa-whatsapp mr-3 text-xl text-yellow-400"></i>
                            <span>{{ $settings['school_phone'] ?? '(000) 000-0000' }}</span>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-xl text-yellow-400"></i>
                        <span>{{ $settings['school_email'] ?? 'info@sekolah.com' }}</span>
                    </div>
                </div>

                {{-- Kolom 2: Sosial Media --}}
                <div class="mb-6 w-full md:mb-0 md:w-1/5">
                    <h4 class="mb-4 text-lg font-semibold text-yellow-400">Ikuti Kami</h4>
                    <div class="flex space-x-4 text-2xl">
                        @if (!empty($settings['facebook_link']))
                        <a href="{{ $settings['facebook_link'] }}" class="hover:text-blue-500" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if (!empty($settings['instagram_link']))
                        <a href="{{ $settings['instagram_link'] }}" class="hover:text-pink-400" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if (!empty($settings['youtube_link']))
                        <a href="{{ $settings['youtube_link'] }}" class="hover:text-red-500" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @endif
                        @if (!empty($settings['tiktok_link']))
                        <a href="{{ $settings['tiktok_link'] }}" class="hover:text-purple-500" target="_blank">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Kolom 3: Google Maps --}}
                @if (!empty($settings['school_address']))
                <div class="w-full md:w-1/3">
                    <h4 class="mb-4 text-lg font-semibold text-yellow-400">Lokasi Sekolah</h4>
                    <iframe
                        src="https://maps.google.com/maps?q={{ urlencode($settings['school_address']) }}&output=embed"
                        width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
                @endif
            </div>

            <div class="border-t border-gray-600 pt-4 text-center">
                <p>© {{ date('Y') }} {{ $schoolName ?? 'Nama Sekolah' }}. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clock
            function updateClock() {
                const now = new Date();
                const time = now.toLocaleTimeString('id-ID', {
                    hour12: false
                });
                const clockElement = document.getElementById('digital-clock');
                if (clockElement) {
                    clockElement.textContent = time;
                }
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Notifikasi Bell - Perbaikan untuk mobile
            const bell = document.getElementById('notification-bell');
            const dropdown = document.getElementById('notification-dropdown');
            
            bell.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
                
                // Jika di mobile, posisikan dropdown dengan benar
                if (window.innerWidth < 768) {
                    const rect = bell.getBoundingClientRect();
                    dropdown.style.top = `${rect.bottom + window.scrollY + 5}px`;
                    dropdown.style.left = 'auto';
                    dropdown.style.right = '10px';
                }
            });
            
            // Tutup dropdown notifikasi saat klik di luar
            document.addEventListener('click', function(e) {
                if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            // Hamburger Menu - Perbaikan untuk mobile
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuButton.addEventListener('click', function() {
                this.classList.toggle('open');
                mobileMenu.classList.toggle('open');
                
                // Tutup semua dropdown saat menu utama dibuka/ditutup
                document.querySelectorAll('.mobile-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('open');
                });
                document.querySelectorAll('.mobile-dropdown + i').forEach(caret => {
                    caret.classList.remove('fa-caret-up');
                    caret.classList.add('fa-caret-down');
                });
            });

            // Dropdown menu mobile
            const setupMobileDropdown = (buttonId, menuId, caretId) => {
                const button = document.getElementById(buttonId);
                const menu = document.getElementById(menuId);
                const caret = document.getElementById(caretId);
                
                if (button && menu && caret) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        menu.classList.toggle('open');
                        caret.classList.toggle('fa-caret-down');
                        caret.classList.toggle('fa-caret-up');
                        
                        // Tutup dropdown lainnya
                        document.querySelectorAll('.mobile-dropdown').forEach(d => {
                            if (d !== menu) {
                                d.classList.remove('open');
                            }
                        });
                        document.querySelectorAll('.mobile-dropdown + i').forEach(c => {
                            if (c !== caret) {
                                c.classList.remove('fa-caret-up');
                                c.classList.add('fa-caret-down');
                            }
                        });
                    });
                }
            };
            
            setupMobileDropdown('about-dropdown-btn', 'about-dropdown-menu', 'about-caret');
            setupMobileDropdown('links-dropdown-btn', 'links-dropdown-menu', 'links-caret');
            
            // Tutup semua menu saat klik di luar
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#mobile-menu') && !e.target.closest('#mobile-menu-button')) {
                    mobileMenu.classList.remove('open');
                    mobileMenuButton.classList.remove('open');
                    
                    document.querySelectorAll('.mobile-dropdown').forEach(menu => {
                        menu.classList.remove('open');
                    });
                    document.querySelectorAll('.mobile-dropdown + i').forEach(caret => {
                        caret.classList.remove('fa-caret-up');
                        caret.classList.add('fa-caret-down');
                    });
                }
            });

            // Hapus Loading Screen saat halaman selesai dimuat
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                window.addEventListener('load', function() {
                    loadingScreen.style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>