@extends('layouts.admin')

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-semibold text-navy-blue">Form Tambah Berita</h3>
        <a href="{{ route('admin.news.index') }}" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-full transition duration-300 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Berita:</label>
            <input type="text" id="title" name="title"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="{{ old('title') }}" required>
        </div>

        <div>
            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Isi Berita:</label>
            <textarea id="content" name="content" rows="10"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required>{{ old('content') }}</textarea>
        </div>

        <div>
            <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Berita (Max 2MB, JPG/PNG/GIF):</label>
            <input type="file" id="thumbnail" name="thumbnail"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                accept="image/*">
        </div>

        <div>
            <label for="published_at" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Terbit:</label>
            <input type="datetime-local" id="published_at" name="published_at"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-navy-blue hover:bg-royal-blue text-white font-bold py-2 px-4 rounded-full transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan Berita
            </button>
        </div>
    </form>
</div>
@endsection
