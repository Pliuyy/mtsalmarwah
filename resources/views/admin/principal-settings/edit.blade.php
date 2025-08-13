@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6 border-b pb-4">
        <h3 class="text-2xl font-semibold text-navy-blue">Pengaturan Kepala Madrasah</h3>
        <p class="text-gray-500 text-sm mt-1">Edit informasi nama, sambutan, dan foto kepala Madrasah.</p>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit Kepala Sekolah --}}
    <form action="{{ route('admin.principal.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf
        @method('PUT')

        {{-- Nama Kepala Sekolah --}}
        <div class="col-span-1">
            <label for="principal_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kepala Sekolah</label>
            <input type="text" id="principal_name" name="principal_name" value="{{ old('principal_name', $settings['principal_name'] ?? '') }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-royal-blue focus:border-royal-blue py-2 px-3" required>
        </div>

        {{-- Upload Foto --}}
        <div class="col-span-1">
            <label for="principal_photo_file" class="block text-sm font-semibold text-gray-700 mb-2">
                Foto Kepala Sekolah
            </label>

            <input type="file" id="principal_photo_file" name="principal_photo_file" accept="image/*"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-royal-blue focus:border-royal-blue py-2 px-3">

            {{-- Jika sudah ada foto, tampilkan dan kirim value lama --}}
            @if(isset($settings['principal_photo']) && $settings['principal_photo'])
                <input type="hidden" name="old_principal_photo" value="{{ $settings['principal_photo'] }}">
                <div class="mt-3">
                    <p class="text-sm text-gray-600">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $settings['principal_photo']) }}" alt="Foto Kepala Sekolah"
                        class="mt-2 w-24 h-24 object-cover rounded-full border shadow">
                </div>
            @endif
        </div>

        {{-- Sambutan --}}
        <div class="col-span-1 md:col-span-2">
            <label for="kepala_sekolah_sambutan" class="block text-sm font-semibold text-gray-700 mb-2">Sambutan Kepala Sekolah</label>
            <textarea id="kepala_sekolah_sambutan" name="kepala_sekolah_sambutan" rows="6"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-royal-blue focus:border-royal-blue py-2 px-3 resize-none"
                required>{{ old('kepala_sekolah_sambutan', $settings['kepala_sekolah_sambutan'] ?? '') }}</textarea>
        </div>

        {{-- Tombol Simpan --}}
        <div class="col-span-1 md:col-span-2 flex justify-end mt-4">
            <button type="submit"
                class="bg-navy-blue hover:bg-royal-blue text-white font-semibold py-2 px-6 rounded-full transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
