@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Berita</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm bg-indigo-600 text-white px-3 py-1 rounded-full">
                    Total: {{ $news->count() }}
                </span>
                <a href="{{ route('admin.news.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Berita
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
                        <th class="px-4 py-3 border-b">#</th>
                        <th class="px-4 py-3 border-b">Judul</th>
                        <th class="px-4 py-3 text-center">Tanggal</th>
                        <th class="px-4 py-3 text-center">Aktif</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 bg-white divide-y divide-gray-100">
                    @forelse ($news as $index => $item)
                    <tr>
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $item->title }}</td>
                        <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.news.toggle', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                @if ($item->is_active)
                                    <button type="submit" title="Klik untuk nonaktifkan"
                                        class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full hover:bg-green-200 transition">
                                        Aktif
                                    </button>
                                @else
                                    <button type="submit" title="Klik untuk aktifkan"
                                        class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition">
                                        Tidak Aktif
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <a href="{{ route('admin.news.edit', $item->id) }}"
                                class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">Belum ada data berita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
