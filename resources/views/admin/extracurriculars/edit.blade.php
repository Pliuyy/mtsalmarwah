@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-semibold text-navy-blue">Edit Ekskul</h3>
        <a href="{{ route('admin.extracurriculars.index') }}"
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

    <form action="{{ route('admin.extracurriculars.update', $extracurricular->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-gray-700 font-medium mb-1">Nama Ekstrakurikuler</label>
            <input type="text" id="name" name="name" value="{{ old('name', $extracurricular->name) }}" required
                class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-navy-blue shadow-sm">
        </div>

        <div>
            <label for="description" class="block text-gray-700 font-medium mb-1">Deskripsi</label>
            <textarea id="description" name="description" rows="6" maxlength="500" required
                class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-navy-blue shadow-sm">{{ old('description', $extracurricular->description) }}</textarea>
            <p class="text-sm text-gray-500 mt-1">
                <span id="desc-count">0</span>/500 karakter
            </p>
        </div>

        <div>
            <label for="schedule" class="block text-gray-700 font-medium mb-1">Jadwal Ekstrakurikuler</label>
            <input type="date" id="schedule" name="schedule" value="{{ old('schedule') }}"
                class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-navy-blue shadow-sm">
        </div>

        <div>
            <label for="photo" class="block text-gray-700 font-medium mb-1">Foto Baru (Opsional)</label>
            <input type="file" id="photo" name="photo" accept="image/*"
                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-navy-blue">
            @if($extracurricular->photo)
            <div class="mt-2 text-sm text-gray-600">Foto Saat Ini:</div>
            <img src="{{ asset('storage/' . $extracurricular->photo) }}" alt="Current Photo" class="w-32 h-20 mt-1 object-cover rounded shadow">
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-navy-blue hover:bg-royal-blue text-white font-semibold px-6 py-2 rounded-full shadow transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<script>
    const desc = document.getElementById('description');
    const count = document.getElementById('desc-count');

    function updateCounter() {
        count.textContent = desc.value.length;
    }

    desc.addEventListener('input', updateCounter);
    window.addEventListener('DOMContentLoaded', updateCounter);
</script>
@endsection