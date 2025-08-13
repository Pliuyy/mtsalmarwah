@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white shadow-md rounded-xl md:p-8">
    <h3 class="mb-6 text-2xl font-bold text-center text-navy-blue">Pengaturan Umum Website</h3>

    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border border-green-300 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="px-4 py-3 mb-4 text-red-800 bg-red-100 border border-red-300 rounded">
        <ul class="pl-5 space-y-1 list-disc">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- Informasi Dasar --}}
        <div>
            <h4 class="pb-2 mb-4 text-xl font-semibold border-b text-royal-blue">Informasi Dasar Sekolah</h4>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="block mb-1 font-medium">Nama Sekolah</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $settings['school_name'] ?? '') }}" required class="w-full px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Tagline Sekolah (Opsional)</label>
                    <input type="text" name="school_tagline" value="{{ old('school_tagline', $settings['school_tagline'] ?? '') }}" class="w-full px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Alamat Sekolah</label>
                    <input type="text" name="school_address" value="{{ old('school_address', $settings['school_address'] ?? '') }}" required class="w-full px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Nomor Telepon</label>
                    <input type="text" name="school_phone" value="{{ old('school_phone', $settings['school_phone'] ?? '') }}" required class="w-full px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Email Sekolah</label>
                    <input type="email" name="school_email" value="{{ old('school_email', $settings['school_email'] ?? '') }}" required class="w-full px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Tahun Berdiri (Opsional)</label>
                    <input type="number" name="school_founding_year" value="{{ old('school_founding_year', $settings['school_founding_year'] ?? '') }}" class="w-full px-3 py-2 border rounded">
                </div>
            </div>

            <div class="mt-4">
                <label class="block mb-1 font-medium">Deskripsi Singkat Sekolah</label>
                <textarea name="school_description" rows="3" class="w-full px-3 py-2 border rounded">{{ old('school_description', $settings['school_description'] ?? '') }}</textarea>
            </div>
        
            {{-- Logo --}}
            <div class="mt-4">
                <label class="block mb-1 font-medium">Logo Sekolah (Max 2MB)</label>
                <input type="file" name="school_logo_file" class="block w-full px-3 py-2 text-sm border rounded file:bg-royal-blue file:text-white file:rounded file:px-4 file:py-2 file:border-none">

                {{-- Simpan logo lama --}}
                @if(isset($settings['school_logo']) && $settings['school_logo'])
                <input type="hidden" name="old_school_logo" value="{{ $settings['school_logo'] }}">
                <img src="{{ asset('storage/' . $settings['school_logo']) }}" class="object-contain w-24 h-24 mt-3 border rounded-full shadow" alt="Logo Sekolah">
                @endif
            </div>
        </div>

        {{-- Visi Misi --}}
        <div>
            <h4 class="pb-2 mt-8 mb-4 text-xl font-semibold border-b text-royal-blue">Visi dan Misi Sekolah</h4>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Visi Sekolah</label>
                <textarea name="school_vision" rows="3" class="w-full px-3 py-2 border rounded">{{ old('school_vision', $settings['school_vision'] ?? '') }}</textarea>
            </div>

            @for($i = 1; $i <= 5; $i++)
            <div class="mb-4">
                <label class="block mb-1 font-medium">Visi Sekolah {{ $i }}</label>
                <textarea name="school_vision_{{ $i }}" rows="2" class="w-full px-3 py-2 border rounded">{{ old('school_vision_'.$i, $settings['school_vision_'.$i] ?? '') }}</textarea>    
            </div>
            @endfor

            @for($i = 1; $i <= 5; $i++)
                <div class="mb-4">
                <label class="block mb-1 font-medium">Misi Sekolah {{ $i }}</label>
                <textarea name="school_mission_{{ $i }}" rows="2" class="w-full px-3 py-2 border rounded">{{ old('school_mission_'.$i, $settings['school_mission_'.$i] ?? '') }}</textarea>
        </div>
        @endfor

        <div class="mb-4">
            <label class="block mb-1 font-medium">Sejarah Singkat Sekolah</label>
            <textarea name="school_history" rows="5" class="w-full px-3 py-2 border rounded">{{ old('school_history', $settings['school_history'] ?? '') }}</textarea>
        </div>
</div>

{{-- Sosial Media --}}
<div>
    <h4 class="pb-2 mt-8 mb-4 text-xl font-semibold border-b text-royal-blue">Tautan Media Sosial</h4>
    <div class="grid gap-6 md:grid-cols-3">
        <div>
            <label class="block mb-1 font-medium">Link Facebook</label>
            <input type="url" name="facebook_link" value="{{ old('facebook_link', $settings['facebook_link'] ?? '') }}" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block mb-1 font-medium">Link Instagram</label>
            <input type="url" name="instagram_link" value="{{ old('instagram_link', $settings['instagram_link'] ?? '') }}" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block mb-1 font-medium">Link YouTube</label>
            <input type="url" name="youtube_link" value="{{ old('youtube_link', $settings['youtube_link'] ?? '') }}" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block mb-1 font-medium">Link Tiktok</label>
            <input type="url" name="tiktok_link" value="{{ old('tiktok_link', $settings['tiktok_link'] ?? '') }}" class="w-full px-3 py-2 border rounded">
        </div>
    </div>
</div>

<div class="pt-4 text-right">
    <button type="submit" class="px-6 py-2 font-semibold text-white transition duration-300 rounded-full bg-navy-blue hover:bg-royal-blue">
        <i class="mr-2 fas fa-save"></i> Simpan Pengaturan
    </button>
</div>
</form>
</div>
@endsection