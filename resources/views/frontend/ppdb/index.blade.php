@extends('layouts.app')

@section('title', 'Portal PPDB')

@section('content')
<div class="container mx-auto px-4 py-6">
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

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Portal PPDB {{ $settings['school_name'] ?? 'MTs Al Marwah' }}</h2>
                <p class="text-lg text-gray-600">Tahun Ajaran 2025/2026</p>
            </div>

            {{-- Informasi Utama --}}
            <div class="prose max-w-none text-gray-700 mb-8">
                <p class="text-lg leading-relaxed mb-6">
                    {{ $settings['ppdb_welcome_text'] ?? 'MTs Al Marwah berkomitmen untuk menyediakan pendidikan holistik yang menggabungkan keunggulan akademik dengan penguatan karakter Islami. Kami menyambut calon siswa-siswi berprestasi untuk bergabung dengan keluarga besar kami.' }}
                </p>
            </div>

            {{-- Jadwal PPDB --}}
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-6 rounded-md mb-8">
                <h3 class="font-bold text-xl mb-4 flex items-center">
                    <i class="fas fa-calendar-alt mr-3 text-blue-600"></i> Jadwal Penting PPDB
                </h3>
                @if($schedules->isNotEmpty())
                <div class="space-y-4">
                    @foreach($schedules as $schedule)
                    <div class="flex items-start">
                        <div class="bg-blue-100 text-blue-800 rounded-lg p-2 mr-4 text-center min-w-[50px]">
                            <div class="font-bold">{{ $schedule->start_date->format('d') }}</div>
                            <div class="text-xs uppercase">{{ $schedule->start_date->format('M') }}</div>
                        </div>
                        <div>
                            <h4 class="font-semibold">{{ $schedule->title }}</h4>
                            <p class="text-sm text-blue-700">
                                {{ $schedule->start_date->format('d M Y') }} - {{ $schedule->end_date->format('d M Y') }}
                            </p>
                            @if($schedule->description)
                            <p class="text-sm mt-1 text-blue-600">{{ $schedule->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p>Informasi jadwal akan segera diumumkan.</p>
                @endif
            </div>

            {{-- Kontak Person --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-user-tie mr-2 text-blue-600"></i> Kontak Person PPDB
                    </h4>
                    <div class="space-y-2">
                        @if(isset($settings['ppdb_contact_person']))
                        @php
                            // Ekstrak nomor telepon dari teks (format: "Nama (081234567890)")
                            preg_match('/\((\d+)\)/', $settings['ppdb_contact_person'], $matches);
                            $phoneNumber = $matches[1] ?? str_replace([' ', '-', '(', ')'], '', $settings['ppdb_contact_person']);
                        @endphp
                        <p class="flex items-center">
                            <i class="fas fa-phone-alt text-gray-500 mr-3"></i>
                            <a href="https://wa.me/{{ $phoneNumber }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">
                                {{ $settings['ppdb_contact_person'] }}
                                <i class="fab fa-whatsapp ml-2 text-green-500"></i>
                            </a>
                        </p>
                        @else
                        <p>-</p>
                        @endif
                        @if(isset($settings['ppdb_email']))
                        <p class="flex items-center">
                            <i class="fas fa-envelope text-gray-500 mr-3"></i>
                            <a href="mailto:{{ $settings['ppdb_email'] }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                {{ $settings['ppdb_email'] }}
                            </a>
                        </p>
                        @endif
                    </div>
                </div>

                <div class="p-6 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i> Informasi Tambahan
                    </h4>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                            <span>Pendaftaran murah dan terjangkau</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                            <span>Proses seleksi transparan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                            <span>Kuota terbatas</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
</style>
@endsection