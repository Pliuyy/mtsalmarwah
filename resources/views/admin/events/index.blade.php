@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Kegiatan</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm bg-indigo-600 text-white px-3 py-1 rounded-full">
                    Total: {{ $events->count() }}
                </span>
                <a href="{{ route('admin.events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Ekskul
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if($events->isEmpty())
        <div class="text-center text-gray-500 py-10">
            <i class="fas fa-frown text-4xl mb-2"></i>
            <p class="text-lg">Belum ada kegiatan yang ditambahkan.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border-b">Judul</th>
                        <th class="px-4 py-3 border-b">Tanggal</th>
                        <th class="px-4 py-3 border-b">Waktu</th>
                        <th class="px-4 py-3 border-b">Lokasi</th>
                        <th class="py-3 px-4 text-center">Foto</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 bg-white divide-y divide-gray-100">
                    @foreach ($events as $event)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} border-b border-gray-200 hover:bg-gray-100 transition">
                        <td class="py-3 px-4">{{ Str::limit($event->title, 50) }}</td>
                        <td class="py-3 px-4">{{ $event->date->format('d M Y') }}</td>
                        <td class="py-3 px-4">{{ $event->time ?? '-' }}</td>
                        <td class="py-3 px-4">{{ Str::limit($event->location ?? '-', 30) }}</td>
                        <td class="py-3 px-4 text-center">
                            @if($event->photo)
                            <img src="{{ asset('storage/' . $event->photo) }}" alt="{{ $event->title }}" class="w-12 h-12 object-cover rounded-full mx-auto shadow-sm">
                            @else
                            <i class="fas fa-image text-gray-400 text-xl"></i>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center space-x-2">
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white py-1 px-3 rounded-full text-xs transition">Edit</a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-full text-xs transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $events->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection