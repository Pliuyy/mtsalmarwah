{{-- resources/views/components/admin_sidebar.blade.php --}}

<style>
    .admin-sidebar {
        width: 256px;
        flex-shrink: 0;
        height: 100vh;
        position: fixed;
        /* FIXED bukan sticky */
        top: 0;
        left: 0;
        z-index: 50;
        background-color: #000066;
        /* Tambahkan background agar tidak transparan */
        overflow-y: visible;
    }

    .admin-sidebar nav ul li>a,
    .admin-sidebar nav ul li>button {
        display: flex;
        align-items: center;
        width: calc(100% - 1.5rem);
        margin-left: 0.75rem;
        margin-right: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        position: relative;
        z-index: 10;
    }

    .admin-sidebar nav ul ul {
        position: static;
        background-color: #000066;
        padding: 0;
        margin: 0;
        list-style: none;
        transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        visibility: hidden;
    }

    .admin-sidebar nav ul ul.open-dropdown {
        max-height: 500px;
        opacity: 1;
        visibility: visible;
    }

    .admin-sidebar nav ul ul li a {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        padding-left: 2.5rem;
        color: #d1d5db;
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .admin-sidebar nav ul ul li a:hover {
        background-color: #4169E1;
        color: #fff;
    }

    .admin-sidebar button .fa-chevron-down {
        transition: transform 0.2s ease-in-out;
    }

    .admin-sidebar button.active .fa-chevron-down {
        transform: rotate(180deg);
    }
</style>

<aside class="z-30 flex flex-col min-h-screen text-white shadow-lg admin-sidebar bg-navy-blue">
    {{-- Header --}}
    <div class="flex items-center justify-start p-4 border-b border-navy-dark">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center w-full">
            <i class="mr-3 text-3xl text-white fas fa-user-graduate"></i>
            <span class="text-2xl font-bold whitespace-nowrap">Admin Panel</span>
        </a>
    </div>

    {{-- Menu --}}
    <nav class="flex-grow mt-4">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.dashboard') ? 'bg-royal-blue' : '' }}">
                    <i class="mr-3 text-lg fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Profil Dropdown --}}
            <li class="relative">
                <button type="button" class="justify-between py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 w-full {{ Request::routeIs(['admin.teachers.*', 'admin.staffs.*']) ? 'bg-royal-blue active' : '' }}" aria-controls="dropdown-profile" data-target-menu="dropdown-profile">
                    <span class="flex items-center">
                        <i class="mr-3 text-lg fas fa-user-circle"></i>
                        <span>Profil</span>
                    </span>
                    <i class="text-sm fas fa-chevron-down"></i>
                </button>
                <ul id="dropdown-profile" class="hidden py-1 text-sm rounded-b-lg bg-navy-dark">
                    <li>
                        <a href="{{ route('admin.teachers.index') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.teachers.*') ? 'bg-royal-blue' : '' }}">
                            <span>Guru</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.staffs.index') }}" class="block py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.staffs.*') ? 'bg-royal-blue' : '' }}">
                            <span>Staf</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.achievements.index') }}" class="block py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.achievements.*') ? 'bg-royal-blue' : '' }}">
                            <span>Murid</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Lainnya --}}
            <li>
                <a href="{{ route('admin.news.index') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.news.*') ? 'bg-royal-blue' : '' }}">
                    <i class="mr-3 text-lg fas fa-newspaper"></i>
                    <span>Berita</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contact.messages') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.pesan-kontak.*') ? 'bg-royal-blue' : '' }}">
                    <i class="mr-3 text-lg fas fa-envelope"></i>
                    <p>Pesan Kontak</p>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.extracurriculars.index') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.extracurriculars.*') ? 'bg-royal-blue' : '' }}">
                    <i class="mr-3 text-lg fas fa-futbol"></i>
                    <span>Ekstrakurikuler</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.events.index') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.events.*') ? 'bg-royal-blue' : '' }}">
                    <i class="mr-3 text-lg fas fa-calendar-alt"></i>
                    <span>Kegiatan</span>
                </a>
            </li>

            {{-- Galeri Dropdown --}}
            <li class="relative">
                <button type="button" class="justify-between py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 w-full {{ Request::routeIs(['admin.galleries.*', 'admin.gallery-categories.*']) ? 'bg-royal-blue active' : '' }}" aria-controls="dropdown-gallery" data-target-menu="dropdown-gallery">
                    <span class="flex items-center">
                        <i class="mr-3 text-lg fas fa-images"></i>
                        <span>Galeri</span>
                    </span>
                    <i class="text-sm fas fa-chevron-down"></i>
                </button>
                <ul id="dropdown-gallery" class="hidden py-1 text-sm rounded-b-lg bg-navy-dark">
                    <li>
                        <a href="{{ route('admin.galleries.index') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.galleries.*') ? 'bg-royal-blue' : '' }}">
                            <span>Foto & Video</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gallery-categories.index') }}" class="block py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.gallery-categories.*') ? 'bg-royal-blue' : '' }}">
                            <span>Kategori Galeri</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="relative">
                <button type="button" class="justify-between py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 w-full {{ Request::routeIs(['admin.ppdb-settings.*', 'admin.ppdb-applicants.*']) ? 'bg-royal-blue active' : '' }}" aria-controls="dropdown-ppdb" data-target-menu="dropdown-ppdb">
                    <span class="flex items-center">
                        <i class="mr-3 text-lg fas fa-user-graduate"></i>
                        <span>PPDB</span>
                    </span>
                    <i class="text-sm fas fa-chevron-down"></i>
                </button>
                <ul id="dropdown-ppdb" class="{{ Request::routeIs(['admin.ppdb-settings.*', 'admin.ppdb-applicants.*']) ? 'open-dropdown' : 'hidden' }} py-1 text-sm rounded-b-lg bg-navy-dark">
                    <li>
                        <a href="{{ route('admin.ppdb-settings.index') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.ppdb-settings.*') ? 'bg-royal-blue' : '' }}">
                            <span>Pengaturan PPDB</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.carousels.index') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 group {{ Request::routeIs('admin.carousels.*') ? 'bg-royal-blue' : '' }}">
                    <i class="mr-3 text-lg fas fa-images"></i>
                    <span>Carousel</span>
                </a>
            </li>

            {{-- Pengaturan Dropdown --}}
            <li class="relative">
                <button type="button" class="justify-between py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 w-full {{ Request::routeIs(['admin.settings.*', 'admin.principal.*']) ? 'bg-royal-blue active' : '' }}" aria-controls="dropdown-settings" data-target-menu="dropdown-settings">
                    <span class="flex items-center">
                        <i class="mr-3 text-lg fas fa-cogs"></i>
                        <span>Pengaturan</span>
                    </span>
                    <i class="text-sm fas fa-chevron-down"></i>
                </button>
                <ul id="dropdown-settings" class="hidden py-1 text-sm rounded-b-lg bg-navy-dark">
                    <li>
                        <a href="{{ route('admin.settings.edit') }}" class="py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.settings.*') ? 'bg-royal-blue' : '' }}">
                            <span>Umum</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.principal.edit') }}" class="block py-2 px-4 text-gray-300 hover:bg-royal-blue hover:text-white rounded-lg my-1 transition duration-200 {{ Request::routeIs('admin.principal.*') ? 'bg-royal-blue' : '' }}">
                            <span>Kepala Sekolah</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    {{-- Footer (Logout) --}}
    <div class="p-4 mt-auto border-t border-navy-dark">
        <form action="{{ route('admin.logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2 my-1 text-gray-300 transition duration-200 rounded-lg hover:bg-red-600 hover:text-white">
                <i class="mr-3 text-lg fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>