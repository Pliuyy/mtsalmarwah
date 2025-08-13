@extends('layouts.admin')

@section('title', 'Edit Data Guru')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Guru</h2>
    <a href="{{ route('admin.teachers.index') }}"
        class="inline-flex items-center text-sm px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full shadow transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" id="name" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('name', $teacher->name) }}">
        </div>

        <div>
            <label for="published_at" class="block text-gray-700 font-medium mb-1">Tanggal Terbit</label>

            {{-- Input yang terlihat (disabled) --}}
            <input type="datetime-local" id="published_at_display"
                value="{{ now()->format('Y-m-d\TH:i') }}"
                class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-500 cursor-not-allowed shadow-sm"
                disabled>

            {{-- Input hidden untuk mengirim data --}}
            <input type="hidden" id="published_at" name="published_at"
                value="{{ now()->format('Y-m-d\TH:i') }}">
        </div>

        <div>
            <label for="subject" class="block mb-1 text-sm font-medium text-gray-700">Mata Pelajaran</label>
            <input type="text" name="subject" id="subject" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('subject', $teacher->subject) }}">
        </div>

        <div>
            <label for="photo" class="block mb-1 text-sm font-medium text-gray-700">Foto</label>
            <input type="file" name="photo" id="photo" accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

            @if($teacher->photo)
            <p class="text-sm text-gray-600 mt-2">Foto saat ini:</p>
            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Current Photo" class="w-24 h-24 object-cover rounded-full mt-2">
            @endif
        </div>

        <div>
            <label for="bio" class="block mb-1 text-sm font-medium text-gray-700">Biografi (Opsional)</label>
            <textarea name="bio" id="bio" rows="5"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('bio', $teacher->bio) }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-300">
                <i class="fas fa-save mr-2"></i> Update Guru
            </button>
        </div>
    </form>
</div>
@endsection