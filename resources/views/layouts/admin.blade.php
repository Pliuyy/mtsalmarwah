<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    {{-- Main Content Area --}}
    <div id="content-area" class="flex flex-col flex-grow min-h-screen">

        <header class="flex items-center justify-between p-4 bg-white shadow-md">
            <div class="text-2xl font-semibold text-navy-blue">@yield('title')</div>

            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <button id="user-menu-button" class="flex items-center px-3 py-2 text-gray-700 transition duration-200 rounded-full focus:outline-none hover:bg-gray-100">
                        <i class="mr-2 text-2xl text-gray-500 fas fa-user-circle"></i>
                        <span class="font-medium">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                        <i class="ml-2 text-sm fas fa-chevron-down"></i>
                    </button>
                    <div id="user-dropdown" class="absolute right-0 z-40 hidden w-48 py-1 mt-2 bg-white rounded-md shadow-lg">
                        <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex">
            @include('components.admin_sidebar')

            <main class="p-4 ml-64">
                @yield('content')
            </main>
        </div>

        <footer class="p-4 mt-auto text-center text-gray-600 bg-white shadow-inner">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');
            const dropdownButtons = document.querySelectorAll('[data-target-menu]');

            // Toggle user dropdown
            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });

                window.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }

            // Handle dropdowns in sidebar (Accordion style)
            dropdownButtons.forEach(button => {
                const targetId = button.getAttribute('data-target-menu');
                const targetMenu = document.getElementById(targetId);
                const chevronIcon = button.querySelector('.fa-chevron-down');

                // Set initial state: if parent route is active, open dropdown
                const hasActiveSubitem = targetMenu ? targetMenu.querySelector('a.bg-royal-blue') : false;
                if (hasActiveSubitem) {
                    targetMenu.classList.add('open-dropdown');
                    targetMenu.classList.remove('hidden');
                    chevronIcon.classList.add('rotate-180');
                    button.classList.add('active');
                }

                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    if (targetMenu) {
                        // Tutup semua submenu lain yang terbuka (accordion behavior)
                        document.querySelectorAll('ul[id^="dropdown-"]').forEach(openMenu => {
                            if (openMenu !== targetMenu && openMenu.classList.contains('open-dropdown')) {
                                openMenu.classList.remove('open-dropdown');
                                openMenu.classList.add('hidden');
                                const associatedButton = document.querySelector(`[data-target-menu="${openMenu.id}"]`);
                                if (associatedButton) {
                                    associatedButton.classList.remove('active');
                                    associatedButton.querySelector('.fa-chevron-down').classList.remove('rotate-180');
                                }
                            }
                        });

                        // Toggle submenu yang diklik
                        targetMenu.classList.toggle('hidden');
                        targetMenu.classList.toggle('open-dropdown');
                        button.classList.toggle('active');
                        chevronIcon.classList.toggle('rotate-180');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>