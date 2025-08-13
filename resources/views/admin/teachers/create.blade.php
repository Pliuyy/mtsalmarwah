@extends('layouts.admin')

@section('title', 'Tambah Guru Baru')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-semibold text-navy-blue mb-6">Tambah Guru Baru</h3>
     <a href="{{ route('admin.teachers.index') }}"
        class="inline-flex items-center text-sm px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full shadow transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Terjadi kesalahan:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                required>
        </div>

        {{-- Tanggal Terbit --}}
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

        {{-- Subject --}}
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran <span class="text-red-500">*</span></label>
            <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                required>
        </div>

        {{-- Foto --}}
        <div>
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Guru (Max 2MB, JPG/PNG/GIF)</label>
            <input type="file" id="photo" name="photo" accept="image/*"
                onchange="previewPhoto(event)"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
            <div class="mt-3">
                <img id="photoPreview" src="#" alt="Preview Foto" class="hidden w-32 h-32 object-cover rounded border border-gray-300">
            </div>
        </div>

        {{-- Biografi --}}
        <div>
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Biografi (Opsional)</label>
            <textarea id="bio" name="bio" rows="4"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">{{ old('bio') }}</textarea>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-navy-blue hover:bg-royal-blue text-white font-semibold py-2 px-6 rounded-md shadow transition duration-300 ease-in-out">
                <i class="fas fa-save mr-2"></i> Simpan Guru
            </button>
        </div>
    </form>
</div>

{{-- JavaScript Preview Gambar --}}
<script>
    function previewPhoto(event) {
        const input = event.target;
        const reader = new FileReader();
        const preview = document.getElementById('photoPreview');

        reader.onload = function () {
            preview.src = reader.result;
            preview.classList.remove('hidden');
        }

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
