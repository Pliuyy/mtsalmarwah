@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        {{-- Judul --}}
        <h2 class="text-3xl font-bold text-navy-blue mb-6">Dashboard</h2>
        <p class="text-gray-600 mb-6">Selamat datang kembali di panel administrasi Anda. Ini ringkasan aktivitas.</p>

        {{-- Statistik Utama --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
                <div class="text-blue-600 text-4xl"><i class="fas fa-futbol"></i></div>
                <div>
                    <h3 class="text-lg font-semibold">Total Kegiatan</h3>
                    <p class="text-2xl font-bold text-gray-800">
                        @php $eventCount = App\Models\Event::count(); @endphp
                        {{ number_format($eventCount) }}
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
                <div class="text-indigo-600 text-4xl"><i class="fas fa-image"></i></div>
                <div>
                    <h3 class="text-lg font-semibold">Jumlah Item Galeri</h3>
                    <p class="text-2xl font-bold text-gray-800">
                        @php $galleryCount = App\Models\Gallery::count(); @endphp
                        {{ $galleryCount }}
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
                <div class="text-green-600 text-4xl"><i class="fas fa-newspaper"></i></div>
                <div>
                    <h3 class="text-lg font-semibold">Jumlah Berita & Artikel</h3>
                    <p class="text-2xl font-bold text-gray-800">
                        @php $newsCount = App\Models\News::count(); @endphp
                        {{ $newsCount }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Grid konten utama --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Aktivitas Terkini --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                <h4 class="text-xl font-semibold mb-4 text-gray-800">Aktivitas Terkini</h4>
                @php
                    $latestNewsForActivity = App\Models\News::latest()->take(5)->get();
                @endphp
                @if($latestNewsForActivity->isEmpty())
                    <p class="text-gray-600">Belum ada aktivitas terkini.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($latestNewsForActivity as $activity)
                            <li class="py-3 flex justify-between items-center">
                                <span class="text-gray-700">Berita baru: {{ Str::limit($activity->title, 50) }}</span>
                                <span class="text-sm text-gray-500">{{ $activity->published_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Shortcut Cepat --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h4 class="text-xl font-semibold mb-4 text-gray-800">Shortcut Cepat</h4>
                <div class="space-y-4">
                    <a href="{{ route('admin.news.create') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                        <i class="fas fa-plus-circle text-lg"></i>
                        <span>Tambah Berita Baru</span>
                    </a>
                    <a href="{{ route('admin.galleries.create') }}" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                        <i class="fas fa-images text-lg"></i>
                        <span>Kelola Galeri</span>
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                        <i class="fas fa-futbol text-lg"></i>
                        <span>Lihat Kegiatan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
