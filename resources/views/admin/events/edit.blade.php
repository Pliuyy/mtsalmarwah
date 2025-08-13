@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-800">
            Tambah Kegiatan Baru
        </h3>
        <a href="{{ route('admin.events.index') }}" class="text-sm text-blue-600 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="col-span-1">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Kegiatan</label>
            <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required
                class="form-input w-full">
        </div>

        {{-- Tanggal --}}
        <div class="col-span-1">
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kegiatan</label>
            <input type="date" id="date" name="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" required
                class="form-input w-full">
        </div>

        {{-- Deskripsi --}}
        <div class="col-span-1 md:col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kegiatan</label>
            <textarea id="description" name="description" rows="5" required
                class="form-textarea w-full">{{ old('description', $event->description) }}</textarea>
        </div>

        {{-- Waktu --}}
        <div class="col-span-1">
            <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Kegiatan</label>
            <input type="text" id="time" name="time" value="{{ old('time', $event->time) }}"
                placeholder="Contoh: 08:00 - 10:00" class="form-input w-full">
        </div>

        {{-- Lokasi --}}
        <div class="col-span-1">
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kegiatan</label>
            <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}"
                class="form-input w-full">
        </div>

        {{-- Foto --}}
        <div class="col-span-1 md:col-span-2">
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Kegiatan</label>
            <input type="file" id="photo" name="photo" accept="image/*"
                class="block w-full text-sm text-gray-700 border border-gray-300 rounded cursor-pointer bg-gray-50 focus:outline-none">
            
            @if ($event->photo)
                <div class="mt-3">
                    <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $event->photo) }}" alt="Foto Kegiatan" class="w-32 h-32 object-cover rounded shadow">
                </div>
            @endif
        </div>

        <div class="col-span-1 md:col-span-2 flex justify-end">
            <button type="submit"
                class="bg-navy-blue hover:bg-blue-800 text-white font-semibold px-5 py-2 rounded transition">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
