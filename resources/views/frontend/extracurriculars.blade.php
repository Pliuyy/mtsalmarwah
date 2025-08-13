@extends('layouts.app')

@section('title', 'Ekstrakurikuler')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Daftar Ekstrakurikuler</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($extracurriculars as $ekskul)
            <div class="bg-white shadow-md rounded-lg p-4">
                @if ($ekskul->photo)
                    <img src="{{ asset('storage/' . $ekskul->photo) }}" alt="{{ $ekskul->name }}" class="w-full h-40 object-cover rounded mb-4">
                @endif
                <h2 class="text-lg font-semibold">{{ $ekskul->name }}</h2>

                <p class="text-gray-700 text-sm line-clamp-3" id="desc-{{ $ekskul->id }}">
                    {{ $ekskul->description }}
                </p>

                <button
                    onclick="toggleDescription('{{ $ekskul->id }}')"
                    class="text-blue-600 hover:underline text-sm mt-2"
                    id="btn-{{ $ekskul->id }}"
                >
                    Selengkapnya
                </button>
            </div>
        @endforeach
    </div>
</div>

{{-- JavaScript --}}
<script>
    function toggleDescription(id) {
        const desc = document.getElementById(`desc-${id}`);
        const btn = document.getElementById(`btn-${id}`);

        if (desc.classList.contains('line-clamp-3')) {
            desc.classList.remove('line-clamp-3');
            btn.textContent = 'Sembunyikan';
        } else {
            desc.classList.add('line-clamp-3');
            btn.textContent = 'Selengkapnya';
        }
    }
</script>

{{-- Tailwind plugin line-clamp dibutuhkan --}}
@endsection
