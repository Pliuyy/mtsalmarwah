@extends('layouts.admin')

@section('title', 'Manajemen Carousel')

@section('content')
<div class="min-h-screen bg-gray-50">

    <div class="max-w-screen-2xl mx-auto bg-white rounded-lg shadow-md px-12 py-10">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-navy-blue">Manajemen Carousel</h1>
                <p class="text-gray-600 mt-2 text-base">Kelola slide yang akan ditampilkan pada halaman utama situs Anda.</p>
            </div>
            <a href="{{ route('admin.carousels.create') }}" class="mt-6 md:mt-0 bg-royal-blue hover:bg-navy-blue text-white py-3 px-5 rounded-full text-sm shadow transition duration-300">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Slide Baru
            </a>
        </div>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Data --}}
        @if($carousels->isEmpty())
            <p class="text-center text-gray-500 py-6 text-lg">Belum ada slide carousel yang diinput.</p>
        @else
            <p class="mb-4 text-gray-700 text-sm">Total Slide: <strong>{{ $carousels->total() }}</strong></p>

            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="text-gray-800 bg-gray-100 text-sm uppercase">
                            <th class="py-4 px-6 text-left font-semibold">Urutan</th>
                            <th class="py-4 px-6 text-left font-semibold">Judul</th>
                            <th class="py-4 px-6 text-left font-semibold">Tipe</th>
                            <th class="py-4 px-6 text-center font-semibold">Preview</th>
                            <th class="py-4 px-6 text-center font-semibold">Aktif</th>
                            <th class="py-4 px-6 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carousels as $slide)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} border-t border-gray-200 text-sm">
                                <td class="py-3 px-6">{{ $slide->order }}</td>
                                <td class="py-3 px-6">{{ Str::limit($slide->title, 50) }}</td>
                                <td class="py-3 px-6 capitalize">{{ $slide->type }}</td>
                                <td class="py-3 px-6 text-center">
                                    @if($slide->type === 'image' && $slide->image_path)
                                        <img src="{{ asset('storage/' . $slide->image_path) }}" alt="Slide Image" class="w-24 h-16 object-cover mx-auto rounded shadow">
                                    @elseif($slide->type === 'video' && $slide->video_url)
                                        <img src="https://img.youtube.com/vi/{{ $slide->video_url }}/hqdefault.jpg" alt="Video Thumbnail" class="w-24 h-16 object-cover mx-auto rounded shadow">
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @if($slide->is_active)
                                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                    @else
                                        <i class="fas fa-times-circle text-red-500 text-lg"></i>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.carousels.edit', $slide->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1.5 px-4 rounded-full text-xs transition duration-300 shadow mr-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.carousels.destroy', $slide->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1.5 px-4 rounded-full text-xs transition duration-300 shadow">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $carousels->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
