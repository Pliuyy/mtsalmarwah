@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-semibold text-navy-blue">Form Edit Berita</h3>
        <a href="{{ route('admin.news.index') }}"
            class="inline-flex items-center text-sm px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full shadow transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-gray-700 font-medium mb-1">Judul Berita</label>
            <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required
                class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-navy-blue shadow-sm">
        </div>

        <div>
            <label for="content" class="block text-gray-700 font-medium mb-1">Isi Berita</label>
            <textarea id="content" name="content" rows="10" required
                class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-navy-blue shadow-sm">{{ old('content', $news->content) }}</textarea>
        </div>

        <div>
            <label for="thumbnail" class="block text-gray-700 font-medium mb-1">Thumbnail Baru (Opsional)</label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-navy-blue">
            @if($news->thumbnail)
            <div class="mt-2 text-sm text-gray-600">Thumbnail Saat Ini:</div>
            <img src="{{ asset('storage/news_thumbnails/' . $news->thumbnail) }}" alt="Current Thumbnail" class="w-32 h-20 mt-1 object-cover rounded shadow">
            @endif
        </div>

        <div>
            <label for="published_at" class="block text-gray-700 font-medium mb-1">Tanggal Terbit</label>
            <input type="datetime-local" id="published_at" name="published_at"
                value="{{ old('published_at', $news->published_at->format('Y-m-d\TH:i')) }}" required
                class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-navy-blue shadow-sm">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-navy-blue hover:bg-royal-blue text-white font-semibold px-6 py-2 rounded-full shadow transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection