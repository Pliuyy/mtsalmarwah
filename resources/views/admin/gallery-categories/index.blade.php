@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-semibold text-navy-blue">Kategori Galeri</h3>
            <p class="text-gray-600 text-sm mt-1">
                Terdapat <span class="font-bold">{{ $categories->total() }}</span> kategori galeri.
            </p>
        </div>
        <a href="{{ route('admin.gallery-categories.create') }}"
            class="bg-royal-blue hover:bg-navy-blue text-white py-2 px-4 rounded-full text-sm transition duration-300">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="text-center text-gray-600 py-10">
            <p>Belum ada kategori galeri yang ditambahkan.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-navy-blue text-white text-sm">
                        <th class="py-3 px-4 text-left w-16">ID</th>
                        <th class="py-3 px-4 text-left">Nama Kategori</th>
                        <th class="py-3 px-4 text-center">Jumlah Item</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} border-b border-gray-200 text-sm">
                            <td class="py-3 px-4">{{ $category->id }}</td>
                            <td class="py-3 px-4">{{ $category->name }}</td>
                            <td class="py-3 px-4 text-center">
                                {{ $category->galleries_count ?? $category->galleries->count() ?? 0 }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.gallery-categories.edit', $category->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded-full text-xs transition duration-300 mr-2">Edit</a>
                                <form action="{{ route('admin.gallery-categories.destroy', $category->id) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-full text-xs transition duration-300">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
