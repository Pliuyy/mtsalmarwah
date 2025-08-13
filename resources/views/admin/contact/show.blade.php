@extends('layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold mr-4">Detail Pesan</h1>
            <span class="text-sm text-gray-500">
                Dikirim: {{ $contactMessage->created_at->format('d M Y H:i') }}
            </span>
        </div>

        <div class="space-y-4">
            <div>
                <h2 class="text-lg font-semibold">Dari:</h2>
                <p>{{ $contactMessage->name }} &lt;{{ $contactMessage->email }}&gt;</p>
            </div>
            
            <div>
                <h2 class="text-lg font-semibold">Subjek:</h2>
                <p>{{ $contactMessage->subject }}</p>
            </div>
            
            <div>
                <h2 class="text-lg font-semibold">Isi Pesan:</h2>
                <div class="bg-gray-50 p-4 rounded mt-2">
                    {!! nl2br(e($contactMessage->message)) !!}
                </div>
            </div>
            
            <div class="pt-4 border-t">
                <a href="mailto:{{ $contactMessage->email }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded inline-block">
                    Balas via Email
                </a>
                <a href="{{ route('admin.contact.messages') }}" 
                   class="ml-2 text-gray-600 hover:text-gray-800">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection