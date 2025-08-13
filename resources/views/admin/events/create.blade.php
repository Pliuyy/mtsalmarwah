@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-800">
            Tambah Kegiatan Baru
        </h3>
        <a href="{{ route('admin.events.index') }}" class="text-sm text-blue-600 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-4">
            <strong>Oops! Ada kesalahan:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Judul Kegiatan <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('title') }}">
        </div>

        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Tanggal Kegiatan <span class="text-red-500">*</span></label>
            <input type="date" id="date" name="date" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('date') }}">
        </div>

        <div class="md:col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Kegiatan <span class="text-red-500">*</span></label>
            <textarea id="description" name="description" rows="4" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="time" class="block text-sm font-medium text-gray-700">Waktu (Opsional)</label>
            <input type="text" id="time" name="time"
                placeholder="cth: 08:00 - 10:00 WIB"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('time') }}">
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-gray-700">Lokasi (Opsional)</label>
            <input type="text" id="location" name="location"
                placeholder="cth: Aula Utama"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('location') }}">
        </div>

        <div class="md:col-span-2">
            <label for="photo" class="block text-sm font-medium text-gray-700">Foto Kegiatan</label>
            <input type="file" id="photo" name="photo" accept="image/*"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <p class="text-xs text-gray-500 mt-1">Ukuran maksimal 2MB. Format: JPG, PNG, atau GIF.</p>
        </div>

        <div class="md:col-span-2 flex justify-end">
            <button type="submit"
                class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan Kegiatan
            </button>
        </div>
    </form>
</div>
@endsection
