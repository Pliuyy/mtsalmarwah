@extends('layouts.admin')

@section('title', 'Pengaturan PPDB')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-semibold text-navy-blue">Pengaturan PPDB</h3>
        <a href="{{ route('admin.ppdb-settings.edit') }}" class="bg-royal-blue hover:bg-navy-blue text-white py-2 px-4 rounded-full text-sm transition duration-300">
            <i class="fas fa-edit mr-2"></i> Edit Pengaturan
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        {{-- STATUS --}}
        <div class="p-5 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
            <h4 class="text-base font-semibold text-royal-blue mb-1">Status Pendaftaran</h4>
            <p class="text-xl font-bold">
                @if(($settings['ppdb_status'] ?? 'closed') === 'open')
                    <span class="text-green-600">Terbuka</span>
                @else
                    <span class="text-red-600">Ditutup</span>
                @endif
            </p>
        </div>

        {{-- PERIODE --}}
        <div class="p-5 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
            <h4 class="text-base font-semibold text-royal-blue mb-1">Periode Pendaftaran</h4>
            <p class="text-lg font-medium text-gray-800">
                {{ $settings['ppdb_start_date'] ?? '-' }} s/d {{ $settings['ppdb_end_date'] ?? '-' }}
            </p>
        </div>

        {{-- SAMBUTAN --}}
        <div class="md:col-span-2 p-5 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
            <h4 class="text-base font-semibold text-royal-blue mb-2">Teks Sambutan PPDB</h4>
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $settings['ppdb_welcome_text'] ?? '-' }}</p>
        </div>

        {{-- KONTAK --}}
        <div class="md:col-span-2 p-5 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
            <h4 class="text-base font-semibold text-royal-blue mb-2">Kontak Person PPDB</h4>
            <p class="text-gray-700">{{ $settings['ppdb_contact_person'] ?? '-' }}</p>
        </div>
    </div>

    {{-- JADWAL --}}
    <h3 class="text-2xl font-semibold text-navy-blue mb-4">Jadwal PPDB</h3>
    @if($schedules->isEmpty())
        <p class="text-gray-600 italic">Belum ada jadwal PPDB yang ditambahkan.</p>
    @else
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full text-sm text-gray-800 border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-navy-blue text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Tahap</th>
                        <th class="py-3 px-4 text-left">Mulai</th>
                        <th class="py-3 px-4 text-left">Selesai</th>
                        <th class="py-3 px-4 text-left">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} border-b border-gray-200">
                        <td class="py-3 px-4 font-medium">{{ $schedule->title }}</td>
                        <td class="py-3 px-4">{{ $schedule->start_date->format('d M Y') }}</td>
                        <td class="py-3 px-4">{{ $schedule->end_date->format('d M Y') }}</td>
                        <td class="py-3 px-4">{{ Str::limit($schedule->description ?? '-', 50) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- FOOTER LINK --}}
    <div class="text-right mt-4">
        <a href="{{ route('admin.ppdb-settings.edit') }}" class="inline-block text-royal-blue hover:underline text-sm">
            <i class="fas fa-cog mr-1"></i> Edit Jadwal, Persyaratan, dan Hasil Seleksi
        </a>
    </div>
</div>
@endsection
