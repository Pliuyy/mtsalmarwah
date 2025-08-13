<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen text-gray-800 bg-blue-100 font-poppins">
    <div class="w-full max-w-md p-8 text-center bg-white rounded-lg shadow-lg">
        @php
            $settings = App\Models\Setting::pluck('value', 'key')->toArray();
            $schoolName = $settings['school_name'] ?? 'MTs Al Marwah';
            $schoolLogo = $settings['school_logo'] ?? null;
        @endphp

        @if($schoolLogo && file_exists(public_path('storage/' . $schoolLogo)))
            <img src="{{ asset('storage/' . $schoolLogo) }}" alt="Logo {{ $schoolName }}" class="w-auto h-24 mx-auto mb-4">
        @else
            <div class="flex items-center justify-center w-24 h-24 mx-auto mb-4 text-2xl font-bold text-white bg-blue-600 rounded-full">
                {{ substr($schoolName, 0, 1) }}
            </div>
        @endif
        
        {{-- Nama Sekolah --}}
        <h1 class="mb-2 text-3xl font-bold text-blue-800">{{ $schoolName }}</h1>
        
        {{-- Judul Halaman --}}
        <h2 class="mb-6 text-xl font-semibold text-blue-600">@yield('title')</h2>

        {{-- Konten Utama Halaman --}}
        @yield('content')
    </div>
</body>
</html>