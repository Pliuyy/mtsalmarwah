@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-medium text-gray-800">Edit Item Galeri</h3>
        <a href="{{ route('admin.galleries.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke Galeri
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm text-gray-700 mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title', $gallery->title) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        @php
        use Carbon\Carbon;
        @endphp

        <div class="mb-4">
            <label class="block text-sm text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="date" value="{{ old('date', $gallery->date ? Carbon::parse($gallery->date)->format('Y-m-d') : '') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm text-gray-700 mb-1">Kategori</label>
            <select name="gallery_category_id" class="w-full border rounded px-3 py-2">
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('gallery_category_id', $gallery->gallery_category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm text-gray-700 mb-1">Tipe</label>
            <select name="type" id="type" class="w-full border rounded px-3 py-2" onchange="handleTypeChange()">
                <option value="photo" {{ old('type', $gallery->type) === 'photo' ? 'selected' : '' }}>Foto</option>
                <option value="video" {{ old('type', $gallery->type) === 'video' ? 'selected' : '' }}>Video</option>
            </select>
        </div>

        {{-- Foto --}}
        <div class="mb-4" id="photoInput">
            <label class="block text-sm text-gray-700 mb-1">Upload Foto</label>
            <input type="file" name="file_upload" accept="image/*" class="w-full border rounded px-3 py-2" onchange="previewImage(this)">
            
            @if ($gallery->type === 'photo' && $gallery->file_path)
            <div class="mt-3 flex flex-col items-start">
                <img id="imagePreview" src="{{ asset('storage/' . $gallery->file_path) }}" alt="Preview" class="w-full max-w-sm rounded shadow">
                <div class="mt-2 flex items-center">
                    <input type="checkbox" name="remove_image" id="remove_image" class="mr-2">
                    <label for="remove_image" class="text-sm text-red-600 cursor-pointer">Hapus gambar saat disimpan</label>
                </div>
            </div>
            @else
            <img id="imagePreview" class="mt-3 w-full max-w-sm rounded shadow hidden">
            @endif
        </div>

        {{-- YouTube ID --}}
        <div class="mb-4" id="youtubeInput">
            <label class="block text-sm text-gray-700 mb-1">ID YouTube</label>
            <input type="text" name="video_id" value="{{ old('video_id', $gallery->video_id) }}" class="w-full border rounded px-3 py-2">
            <small class="text-xs text-gray-500">Contoh: Jika URL YouTube adalah https://youtu.be/<b>abcd1234</b>, maka ID adalah <b>abcd1234</b>.</small>

            @if ($gallery->type === 'video' && $gallery->video_id)
            <div class="mt-3 aspect-video">
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $gallery->video_id }}" frameborder="0" allowfullscreen class="rounded shadow"></iframe>
            </div>
            @endif
        </div>

        {{-- Upload Video --}}
        <div class="mb-4" id="uploadVideoInput">
            <label class="block text-sm text-gray-700 mb-1">Upload Video</label>
            <input type="file" name="video_upload" accept="video/*" class="w-full border rounded px-3 py-2" onchange="previewVideo(this)">
            
            @if ($gallery->type === 'video' && $gallery->file_path && !$gallery->video_id)
            <div class="mt-3 flex flex-col items-start">
                <video controls class="w-full max-w-xl rounded shadow">
                    <source src="{{ asset('storage/' . $gallery->file_path) }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
                <div class="mt-2 flex items-center">
                    <input type="checkbox" name="remove_video" id="remove_video" class="mr-2">
                    <label for="remove_video" class="text-sm text-red-600 cursor-pointer">Hapus video saat disimpan</label>
                </div>
            </div>
            @else
            <video id="videoPreview" controls class="mt-3 w-full max-w-xl rounded shadow hidden"></video>
            @endif
        </div>

        <div class="flex gap-4 items-center mt-6">
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function handleTypeChange() {
        const type = document.getElementById('type').value;
        document.getElementById('photoInput').style.display = type === 'photo' ? 'block' : 'none';
        document.getElementById('youtubeInput').style.display = type === 'video' ? 'block' : 'none';
        document.getElementById('uploadVideoInput').style.display = type === 'video' ? 'block' : 'none';
    }

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewVideo(input) {
        const preview = document.getElementById('videoPreview');
        if (input.files && input.files[0]) {
            const fileURL = URL.createObjectURL(input.files[0]);
            preview.src = fileURL;
            preview.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', handleTypeChange);
</script>
@endsection