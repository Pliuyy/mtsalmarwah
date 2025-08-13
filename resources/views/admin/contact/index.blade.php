@extends('layouts.admin')

@section('title', 'Pesan Kontak')

@section('content')
<div class="container-fluid">
    <h1 class="text-2xl font-bold mb-4">Daftar Pesan Masuk</h1>
    
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($messages->isEmpty())
        <div class="p-8 text-center">
            <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada pesan masuk</h3>
            <p class="text-gray-500">Semua pesan yang dikirim melalui form kontak akan muncul di sini</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Subjek</th>
                        <th class="px-6 py-3 text-left">Dikirim</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                    <tr class="{{ $message->read_at ? 'bg-white' : 'bg-blue-50' }} border-b">
                        <td class="px-6 py-4">{{ $message->name }}</td>
                        <td class="px-6 py-4">{{ $message->email }}</td>
                        <td class="px-6 py-4">{{ Str::limit($message->subject, 30) }}</td>
                        <td class="px-6 py-4">
                            {{ $message->created_at->format('d M Y') }}
                            <div class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $message->read_at ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $message->read_at ? 'Dibaca' : 'Belum dibaca' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.contact.show', $message->id) }}" 
                               class="text-blue-600 hover:text-blue-800 px-2 py-1 rounded hover:bg-blue-50 transition-colors">
                               <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 px-2 py-1 rounded hover:bg-red-50 transition-colors"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // SweetAlert untuk konfirmasi penghapusan
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pesan yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection