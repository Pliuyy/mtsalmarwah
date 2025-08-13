@extends('layouts.app')

@section('title', 'Kontak Kami')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-800 sm:text-5xl mb-4">
                Hubungi <span class="text-blue-600">MTs Al-Marwah</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Kami siap membantu Anda. Silakan hubungi kami melalui informasi kontak atau kirim pesan langsung melalui form.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid md:grid-cols-2 gap-0">
                <!-- Contact Info Section -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-8 md:p-10 text-white">
                    <div class="max-w-md mx-auto">
                        <h2 class="text-2xl font-bold mb-6">Informasi Kontak</h2>
                        
                        <div class="space-y-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-500 rounded-full p-2">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium">Alamat Sekolah</h3>
                                    <p class="mt-1 text-blue-100">{{ $settings['school_address'] ?? 'Jl. Contoh No. 123, Kota, Provinsi' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-500 rounded-full p-2">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium">Telepon</h3>
                                    <p class="mt-1 text-blue-100">{{ $settings['school_phone'] ?? '(021) 1234567' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-500 rounded-full p-2">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium">Email</h3>
                                    <p class="mt-1 text-blue-100">{{ $settings['school_email'] ?? 'info@sekolah.com' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="text-lg font-medium mb-4">Jam Operasional</h3>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-500 rounded-full p-2">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-blue-100">Senin - Jumat: 07:00 - 15:00 WIB</p>
                                    <p class="text-blue-100">Sabtu: 08:00 - 12:00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Section -->
                <div class="p-8 md:p-10">
                    <div class="max-w-md mx-auto">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
                        <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" id="name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       placeholder="Masukkan nama lengkap Anda">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                <input type="email" name="email" id="email" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       placeholder="contoh@email.com">
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                                <input type="text" name="subject" id="subject" 
                                       value="Pertanyaan dari Website Sekolah"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none cursor-not-allowed"
                                       readonly>
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan Anda</label>
                                <textarea name="message" id="message" rows="5" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                          placeholder="Tulis pesan Anda disini..."></textarea>
                            </div>
                            
                            <div>
                                <button type="submit" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-[1.02]">
                                    <svg class="w-5 h-5 inline mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection