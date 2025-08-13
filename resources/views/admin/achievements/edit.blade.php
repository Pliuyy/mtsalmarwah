@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Murid</h2>
    <a href="{{ route('admin.achievements.index') }}"
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

    <form action="{{ route('admin.achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="student_name" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="student_name" id="student_name" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('student_name', $achievement->student_name) }}">
        </div>
        
        <div>
            <label for="achievement" class="block mb-1 text-sm font-medium text-gray-700">Prestasi</label>
            <input type="text" name="achievement" id="achievement" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('achievement', $achievement->achievement) }}">
        </div>

        <div>
            <label for="published_at" class="block text-gray-700 font-medium mb-1">Tanggal Acara</label>
            <input type="datetime-local" id="published_at" name="published_at"
                value="{{ old('published_at', $achievement->published_at ? $achievement->published_at->format('Y-m-d\TH:i') : '') }}" required
                class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-navy-blue shadow-sm">
        </div>


        <div>
            <label for="photo" class="block mb-1 text-sm font-medium text-gray-700">Foto</label>
            <input type="file" name="photo" id="photo" accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

            @if($achievement->photo)
            <p class="text-sm text-gray-600 mt-2">Foto saat ini:</p>
            <img src="{{ asset('storage/' . $achievement->photo) }}" alt="Current Photo" class="w-24 h-24 object-cover rounded-full mt-2">
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-300">
                <i class="fas fa-save mr-2"></i> Update Murid
            </button>
        </div>
    </form>
</div>
@endsection