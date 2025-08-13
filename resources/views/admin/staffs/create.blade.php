@extends('layouts.admin')

@section('title', 'Tambah Staf Baru')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-semibold text-navy-blue mb-6">Tambah Staff Baru</h3>
     <a href="{{ route('admin.staffs.index') }}"
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

    <form action="{{ route('admin.staffs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                required>
        </div>

        <!-- Jabatan -->
        <div>
            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Jabatan:</label>
            <input type="text" id="position" name="position" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('position') }}" required>
        </div>

    <!-- Foto Staff -->
        <div>
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Staff (Max 2MB, JPG/PNG/GIF)</label>
            <input type="file" id="photo" name="photo" accept="image/*"
                onchange="previewPhoto(event)"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
            <div class="mt-3">
                <img id="photoPreview" src="#" alt="Preview Foto" class="hidden w-32 h-32 object-cover rounded border border-gray-300">
            </div>
        </div>

        <!-- Biodata -->
        <div>
            <label for="bio" class="block text-gray-700 text-sm font-bold mb-2">Biografi:</label>
            <textarea id="bio" name="bio" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('bio') }}</textarea>
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-end">
            <button type="submit" class="bg-navy-blue hover:bg-royal-blue text-white font-bold py-2 px-4 rounded-full transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan Staf
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
