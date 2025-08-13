@extends('layouts.admin')

@section('title', 'Tambah Item Galeri')

@section('content')
<div class="max-w-4xl p-8 mx-auto bg-white rounded-lg shadow-md">
    <div class="flex items-center justify-between pb-2 mb-6 border-b">
        <h3 class="text-2xl font-bold text-gray-800">Tambah Item Galeri</h3>
        <a href="{{ route('admin.galleries.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke Daftar Galeri
        </a>
    </div>

    @if ($errors->any())
    <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded-lg">
        <h4 class="mb-2 font-bold">Terdapat kesalahan:</h4>
        <ul class="pl-5 list-disc">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid gap-6 mb-8 md:grid-cols-2">
            {{-- Judul --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-700">Judul *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="date" value="{{ old('date') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Kategori</label>
                <select name="gallery_category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('gallery_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Tipe --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-700">Tipe *</label>
                <select name="type" id="type" required onchange="toggleMediaType()"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="photo" {{ old('type', 'photo') == 'photo' ? 'selected' : '' }}>Foto</option>
                    <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>
        </div>

        {{-- Foto --}}
        <div class="mb-6" id="photoInput">
            <label class="block mb-2 text-sm font-medium text-gray-700">Upload Foto *</label>
            <input type="file" name="file_upload" accept="image/*" id="file_upload"
                   class="w-full border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                   onchange="previewImage(this)">
            
            <div class="mt-3" id="imagePreviewContainer">
                <img id="imagePreview" class="hidden max-w-full rounded-lg shadow-md max-h-60">
            </div>
            <small class="block mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF (Maksimal 5MB)</small>
        </div>

        {{-- YouTube ID --}}
        <div class="mb-6 hidden" id="youtubeInput">
            <label class="block mb-2 text-sm font-medium text-gray-700">ID YouTube</label>
            <input type="text" name="video_id" value="{{ old('video_id') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            <small class="block mt-1 text-xs text-gray-500">
                Contoh: Jika URL YouTube adalah https://youtu.be/<b>abcd1234</b>, maka ID adalah <b>abcd1234</b>
            </small>
        </div>

        {{-- Upload Video --}}
        <div class="mb-6 hidden" id="uploadVideoInput">
            <label class="block mb-2 text-sm font-medium text-gray-700">Upload Video</label>
            <input type="file" name="video_upload" accept="video/*" id="video_upload"
                   class="w-full border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                   onchange="previewVideo(this)">
            
            <div class="mt-3" id="videoPreviewContainer">
                <video id="videoPreview" controls class="hidden max-w-full rounded-lg shadow-md max-h-60"></video>
            </div>
            <small class="block mt-1 text-xs text-gray-500">Format: MP4, WebM (Maksimal 20MB)</small>
        </div>

        <div class="flex justify-end gap-4 pt-4 mt-8 border-t">
            <a href="{{ route('admin.galleries.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="mr-2 fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
    // Toggle between photo and video inputs
    function toggleMediaType() {
        const type = document.getElementById('type').value;
        
        if (type === 'photo') {
            document.getElementById('photoInput').classList.remove('hidden');
            document.getElementById('youtubeInput').classList.add('hidden');
            document.getElementById('uploadVideoInput').classList.add('hidden');
        } else {
            document.getElementById('photoInput').classList.add('hidden');
            document.getElementById('youtubeInput').classList.remove('hidden');
            document.getElementById('uploadVideoInput').classList.remove('hidden');
        }
    }

    // Preview image before upload
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                
                // Remove any existing video preview
                const videoPreview = document.getElementById('videoPreview');
                if (videoPreview) {
                    videoPreview.classList.add('hidden');
                    videoPreview.src = '';
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview video before upload
    function previewVideo(input) {
        const preview = document.getElementById('videoPreview');
        const container = document.getElementById('videoPreviewContainer');
        
        if (input.files && input.files[0]) {
            const fileURL = URL.createObjectURL(input.files[0]);
            preview.src = fileURL;
            preview.classList.remove('hidden');
            
            // Remove any existing image preview
            const imagePreview = document.getElementById('imagePreview');
            if (imagePreview) {
                imagePreview.classList.add('hidden');
                imagePreview.src = '';
            }
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleMediaType();
    });
</script>
@endsection