@extends('layouts.admin')

@section('title', 'Edit Data Staf')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 mx-auto max-w-2xl">
    <h3 class="text-2xl font-semibold text-navy-blue mb-6">Edit Data Staf</h3>
     <a href="{{ route('admin.staffs.index') }}"
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

    <form action="{{ route('admin.staffs.update', $staff->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name', $staff->name) }}" required
                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring focus:border-royal-blue">
        </div>

        <div>
            <label for="published_at" class="block text-gray-700 font-medium mb-1">Tanggal Terbit</label>

            {{-- Input yang terlihat (disabled) --}}
            <input type="datetime-local" id="published_at_display"
                value="{{ now()->format('Y-m-d\TH:i') }}"
                class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-500 cursor-not-allowed shadow-sm"
                disabled>

            {{-- Input hidden untuk mengirim data --}}
            <input type="hidden" id="published_at" name="published_at"
                value="{{ now()->format('Y-m-d\TH:i') }}">
        </div>

        <div>
            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
            <input type="text" name="position" id="position" value="{{ old('position', $staff->position) }}" required
                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring focus:border-royal-blue">
        </div>

        <div>
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Staf</label>
            <input type="file" name="photo" id="photo" accept="image/*"
                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring focus:border-royal-blue">
            @if($staff->photo)
                <div class="mt-3">
                    <p class="text-sm text-gray-600">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $staff->photo) }}" alt="Current Photo" class="w-20 h-20 object-cover rounded-full border mt-2">
                </div>
            @endif
        </div>

        <div>
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Biografi (Opsional)</label>
            <textarea name="bio" id="bio" rows="5"
                      class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring focus:border-royal-blue">{{ old('bio', $staff->bio) }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-navy-blue hover:bg-royal-blue text-white font-semibold py-2 px-5 rounded-full transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
