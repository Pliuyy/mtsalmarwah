@extends('layouts.admin')

@section('title', 'Edit Pengaturan PPDB')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-2xl font-semibold text-navy-blue mb-6">Form Edit Pengaturan PPDB</h3>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.ppdb-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Bagian Umum --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="ppdb_status" class="block text-sm font-semibold text-gray-700 mb-1">Status Pendaftaran</label>
                <select name="ppdb_status" id="ppdb_status" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="open" {{ ($settings['ppdb_status'] ?? 'closed') == 'open' ? 'selected' : '' }}>Terbuka</option>
                    <option value="closed" {{ ($settings['ppdb_status'] ?? 'closed') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                </select>
            </div>
            <div>
                <label for="ppdb_contact_person" class="block text-sm font-semibold text-gray-700 mb-1">Kontak Person</label>
                <input type="text" name="ppdb_contact_person" id="ppdb_contact_person" value="{{ old('ppdb_contact_person', $settings['ppdb_contact_person'] ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label for="ppdb_start_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="ppdb_start_date" id="ppdb_start_date" value="{{ old('ppdb_start_date', $settings['ppdb_start_date'] ?? '') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label for="ppdb_end_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="ppdb_end_date" id="ppdb_end_date" value="{{ old('ppdb_end_date', $settings['ppdb_end_date'] ?? '') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
        </div>

        <div class="mt-6">
            <label for="ppdb_welcome_text" class="block text-sm font-semibold text-gray-700 mb-1">Teks Sambutan</label>
            <textarea name="ppdb_welcome_text" id="ppdb_welcome_text" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('ppdb_welcome_text', $settings['ppdb_welcome_text'] ?? '') }}</textarea>
        </div>

        {{-- Jadwal --}}
        <h4 class="text-xl font-semibold text-navy-blue mt-10 mb-4">Jadwal PPDB</h4>
        <div id="jadwal-list">
            @foreach($schedules as $index => $schedule)
                <div class="border border-gray-300 rounded-lg p-4 mb-4 relative">
                    <input type="hidden" name="schedule_id[]" value="{{ $schedule->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm font-medium">Tahap</label>
                            <input type="text" name="schedule_title[]" value="{{ $schedule->title }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        </div>
                        <div>
                            <label class="text-sm font-medium">Mulai</label>
                            <input type="date" name="schedule_start_date[]" value="{{ $schedule->start_date->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        </div>
                        <div>
                            <label class="text-sm font-medium">Selesai</label>
                            <input type="date" name="schedule_end_date[]" value="{{ $schedule->end_date->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="text-sm font-medium">Deskripsi</label>
                        <textarea name="schedule_description[]" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ $schedule->description }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-navy-blue text-white px-6 py-2 rounded-lg font-semibold hover:bg-royal-blue">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
