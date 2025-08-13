@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Ekskul</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm bg-indigo-600 text-white px-3 py-1 rounded-full">
                    Total: {{ $extracurriculars->count() }}
                </span>
                <a href="{{ route('admin.extracurriculars.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Ekskul
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if($extracurriculars->isEmpty())
        <div class="text-center text-gray-500 py-10">
            <i class="fas fa-frown text-4xl mb-2"></i>
            <p class="text-lg">Belum ada data ekstrakurikuler yang ditambahkan.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border-b">Nama</th>
                        <th class="px-4 py-3 border-b">Jadwal</th>
                        <th class="px-4 py-3 text-center">Foto</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 bg-white divide-y divide-gray-100">
                    @foreach ($extracurriculars as $extracurricular)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} border-t border-gray-200 hover:bg-gray-100 transition">
                        <td class="py-3 px-5">{{ $extracurricular->name }}</td>
                        <td class="py-3 px-5">{{ $extracurricular->schedule ?? '-' }}</td>
                        <td class="py-3 px-5 text-center">
                            @if($extracurricular->photo)
                            <img src="{{ asset('storage/' . $extracurricular->photo) }}" alt="{{ $extracurricular->name }}" class="w-12 h-12 object-cover rounded-full mx-auto shadow-sm">
                            @else
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                            @endif
                        </td>
                        <td class="py-3 px-5 text-center">
                            <a href="{{ route('admin.extracurriculars.edit', $extracurricular->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold transition">Edit</a>
                            <form action="{{ route('admin.extracurriculars.destroy', $extracurricular->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs font-semibold transition ml-1">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $extracurriculars->links() }}
        </div>
        @endif
    </div>
</div>
@endsection