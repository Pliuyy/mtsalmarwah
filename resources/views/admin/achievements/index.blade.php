@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Murid</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm bg-indigo-600 text-white px-3 py-1 rounded-full">
                    Total: {{ $achievements->count() }}
                </span>
                <a href="{{ route('admin.achievements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Murid
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if($achievements->isEmpty())
        <p class="text-center text-gray-500 py-4">Belum ada data murid yang diinput.</p>
        @else

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-3 px-4 border-b">Nama</th>
                        <th class="py-3 px-4 border-b">Prestasi</th>
                        <th class="px-4 py-3 text-center">Tanggal</th>
                        <th class="py-3 px-4 text-center">Foto</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($achievements as $achievement)
                    <tr class="border-b">
                        <td class="py-2 px-4 font-semibold">{{ $achievement->student_name }}</td>
                        <td class="py-2 px-4">{{ $achievement->achievement }}</td>
                       <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($achievement->published_at)->format('d M Y') }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $achievement->photo) }}" alt="Foto" style="width: 120px; height: 120px; margin: 20px; object-fit: cover; border-radius: 600px;">
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.achievements.edit', $achievement->id) }}" class="bg-yellow-400 text-gray-800 px-3 py-1 rounded text-xs font-semibold hover:bg-yellow-300 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.achievements.destroy', $achievement->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $achievements->links() }}
    </div>
    @endif
</div>
@endsection