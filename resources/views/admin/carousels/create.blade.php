@extends('layouts.admin')

@section('content')
<div class="px-6 py-10 min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-navy-blue mb-6">Tambah Slide Carousel Baru</h1>
        <a href="{{ route('admin.carousels.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm px-3 py-2 rounded transition duration-300" style="position: relative; bottom: -14px; left: 355px;">
            ←
        </a>

        @if ($errors->any())
        <div class="mb-6">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.carousels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Judul:</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Sub Judul</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Tipe Slide</label>
                <select name="type" id="type-select" class="w-full border-gray-300 rounded px-3 py-2">
                    <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>Gambar</option>
                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>

            {{-- IMAGE UPLOAD --}}
            <div id="image-input" class="mb-4 hidden">
                <label class="block font-semibold mb-1">Upload Gambar</label>
                <input type="file" name="image_path" class="w-full border-gray-300 rounded px-3 py-2">
            </div>

            {{-- VIDEO OPTIONS --}}
            <div id="video-options" class="mb-4 hidden">
                <label class="block font-semibold mb-1">Pilih Sumber Video</label>
                <select name="video_source" id="video-source-select" class="w-full border-gray-300 rounded px-3 py-2 mb-3">
                    <option value="youtube" {{ old('video_source') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                    <option value="upload" {{ old('video_source') === 'upload' ? 'selected' : '' }}>Upload Video</option>
                </select>

                <div id="youtube-input" class="mb-3 hidden">
                    <label class="block font-semibold mb-1">YouTube Video ID</label>
                    <input type="text" name="video_url" value="{{ old('video_url') }}" class="w-full border-gray-300 rounded px-3 py-2">
                </div>

                <div id="video-upload" class="hidden">
                    <label class="block font-semibold mb-1">Upload Video</label>
                    <input type="file" name="video_file" class="w-full border-gray-300 rounded px-3 py-2">
                </div>
            </div>

            <div class="mb-4">
                <label for="button_text" class="block text-gray-700 text-sm font-bold mb-2">Teks Tombol (Opsional):</label>
                <input type="text" id="button_text" name="button_text"
                    class="w-full border-gray-300 rounded px-3 py-2"
                    value="{{ old('button_text') }}">
            </div>

            <div class="mb-4">
                <label for="button_link" class="block text-gray-700 text-sm font-bold mb-2">Link Tombol (Opsional):</label>
                <input type="text" id="button_link" name="button_link" placeholder="Contoh: /ppdb atau https://..."
                    class="w-full border-gray-300 rounded px-3 py-2"
                    value="{{ old('button_link') }}">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Urutan Tampil</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" class="mr-2" {{ old('is_active') ? 'checked' : '' }}>
                <label for="is_active" class="font-semibold">Aktifkan Slide</label>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-royal-blue hover:bg-navy-blue text-white py-2 px-4 rounded-full transition duration-300">
                    Simpan Slide
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleInputs() {
        const type = document.getElementById('type-select').value;
        const imageInput = document.getElementById('image-input');
        const videoOptions = document.getElementById('video-options');

        imageInput.classList.add('hidden');
        videoOptions.classList.add('hidden');

        if (type === 'image') {
            imageInput.classList.remove('hidden');
        } else if (type === 'video') {
            videoOptions.classList.remove('hidden');
        }
    }

    function toggleVideoSource() {
        const source = document.getElementById('video-source-select').value;
        document.getElementById('youtube-input').classList.add('hidden');
        document.getElementById('video-upload').classList.add('hidden');

        if (source === 'youtube') {
            document.getElementById('youtube-input').classList.remove('hidden');
        } else if (source === 'upload') {
            document.getElementById('video-upload').classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleInputs();
        toggleVideoSource();

        document.getElementById('type-select').addEventListener('change', toggleInputs);
        document.getElementById('video-source-select').addEventListener('change', toggleVideoSource);
    });
</script>
@endsection
