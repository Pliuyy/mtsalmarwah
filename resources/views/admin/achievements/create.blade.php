@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-semibold text-navy-blue mb-6">Tambah Prestasi Baru</h3>
     <a href="{{ route('admin.achievements.index') }}"
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

    <form action="{{ route('admin.achievements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Nama -->
        <div>
            <label for="student_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="student_name" value="{{ old('student_name') }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                required>
        </div>

        <!-- Prestasi -->
        <div>
            <label for="achievement" class="block text-sm font-medium text-gray-700 mb-1">Prestasi:</label>
            <input type="text" id="achievement" name="achievement" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('achievement') }}" required>
        </div>

        <!-- Tahun -->
        <div>
            <label for="published_at" class="block text-gray-700 text-sm font-bold mb-2">dd/mm/yy Prestasi:</label>
            <input type="datetime-local" id="published_at" name="published_at"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" required>
        </div>

    <!-- Foto Murid -->
        <div>
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Murid (Max 2MB, JPG/PNG/GIF)</label>
            <input type="file" id="photo" name="photo" accept="image/*"
                onchange="previewPhoto(event)"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
            <div class="mt-3">
                <img id="photoPreview" src="#" alt="Preview Foto" class="hidden w-32 h-32 object-cover rounded border border-gray-300">
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-end">
            <button type="submit" class="bg-navy-blue hover:bg-royal-blue text-white font-bold py-2 px-4 rounded-full transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>

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
