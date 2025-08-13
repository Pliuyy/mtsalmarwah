@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Guru</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm bg-indigo-600 text-white px-3 py-1 rounded-full">
                    Total: {{ $teachers->count() }}
                </span>
                <a href="{{ route('admin.teachers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Guru
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border-b">Nama</th>
                        <th class="px-4 py-3 border-b">Tanggal Terbit</th>
                        <th class="px-4 py-3 border-b">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-center">Biografi</th>
                        <th class="px-4 py-3 text-center">Foto</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                    <tr class="border-b">
                        <td class="px-4 py-2 font-semibold">{{ $teacher->name }}</td>
                        <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($teacher->published_at)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $teacher->subject }}</td>
                        <td class="text-gray-700 mt-4 leading-relaxed">{{ Str::limit($teacher->bio, 100) }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Foto" style="width: 120px; height: 120px; margin: 20px; object-fit: cover; border-radius: 600px;">
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="bg-yellow-400 text-gray-800 px-3 py-1 rounded text-xs font-semibold hover:bg-yellow-300 transition ml-6">
                                    Edit
                                </a>
                                <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data guru untuk ditampilkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection