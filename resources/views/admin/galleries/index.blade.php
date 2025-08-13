@extends('layouts.admin')

@section('title', 'Manajemen Galeri')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex flex-col justify-between gap-4 mb-6 sm:flex-row sm:items-center">
        <h3 class="text-xl font-semibold text-gray-800">Daftar Item Galeri</h3>
        
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <!-- Add New Button -->
            <a href="{{ route('admin.galleries.create') }}" 
               class="flex items-center justify-center px-4 py-2 text-sm text-white transition duration-300 bg-blue-600 rounded-full hover:bg-blue-700">
                <i class="mr-2 fas fa-plus-circle"></i> Tambah Item
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 border-l-4 border-green-500 rounded">
            <i class="mr-2 fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border-l-4 border-red-500 rounded">
            <i class="mr-2 fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($galleries->isEmpty())
        <div class="p-8 text-center bg-gray-100 rounded-lg">
            <i class="mx-auto mb-4 text-4xl text-gray-400 fas fa-images"></i>
            <p class="mb-2 text-lg font-medium text-gray-600">Belum ada item galeri</p>
            <p class="text-gray-500">Mulai dengan menambahkan item galeri baru</p>
            <a href="{{ route('admin.galleries.create') }}" 
               class="inline-block px-6 py-2 mt-4 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="mr-2 fas fa-plus"></i> Tambah Item Galeri
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="text-sm text-gray-700 bg-gray-100">
                        <th class="px-4 py-3 text-left">Judul</th>
                        <th class="px-4 py-3 text-left">Tipe</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-center">Preview</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($galleries as $item)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} border-b border-gray-200 text-sm text-gray-800 hover:bg-gray-100 transition-colors">
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ Str::limit($item->title, 30) }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $item->created_at->diffForHumans() }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                @if($item->type === 'photo')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="mr-1 fas fa-camera"></i> Foto
                                    </span>
                                @else
                                    @if($item->video_id)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="mr-1 fab fa-youtube"></i> YouTube
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="mr-1 fas fa-video"></i> Video
                                        </span>
                                    @endif
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @if($item->category)
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                        {{ $item->category->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @if($item->date)
                                    <div class="text-sm">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</div>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($item->type === 'photo' && $item->file_path)
                                    <div class="relative mx-auto overflow-hidden rounded-lg shadow w-28 h-20 group">
                                        <img src="{{ asset('storage/' . $item->file_path) }}" 
                                             alt="{{ $item->title }}" 
                                             class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110">
                                        <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-0 group-hover:bg-opacity-30">
                                            <i class="text-xl text-white opacity-0 fas fa-expand group-hover:opacity-100"></i>
                                        </div>
                                    </div>
                                @elseif($item->type === 'video')
                                    @if($item->video_id)
                                        <div class="relative mx-auto overflow-hidden rounded-lg shadow w-28 h-20 group">
                                            <img src="https://img.youtube.com/vi/{{ $item->video_id }}/mqdefault.jpg" 
                                                 alt="Video Preview" 
                                                 class="object-cover w-full h-full">
                                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20">
                                                <i class="text-xl text-white fas fa-play"></i>
                                            </div>
                                        </div>
                                    @elseif($item->file_path)
                                        <div class="relative mx-auto overflow-hidden rounded-lg shadow w-28 h-20">
                                            <video class="object-cover w-full h-full">
                                                <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                                            </video>
                                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20">
                                                <i class="text-xl text-white fas fa-play"></i>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.galleries.edit', $item->id) }}" 
                                       class="inline-flex items-center px-3 py-1 text-xs text-white transition duration-300 bg-yellow-500 rounded-full hover:bg-yellow-600"
                                       title="Edit">
                                        <i class="mr-1 fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.galleries.destroy', $item->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 text-xs text-white transition duration-300 bg-red-500 rounded-full hover:bg-red-600"
                                                title="Hapus">
                                            <i class="mr-1 fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a href="{{ $item->type === 'photo' ? asset('storage/' . $item->file_path) : ($item->video_id ? 'https://youtube.com/watch?v='.$item->video_id : asset('storage/' . $item->file_path)) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-3 py-1 text-xs text-white transition duration-300 bg-blue-500 rounded-full hover:bg-blue-600"
                                       title="Lihat">
                                        <i class="mr-1 fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $galleries->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection