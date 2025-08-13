@extends('layouts.admin_auth')

@section('title', 'Lupa Password')

@section('content')
<p class="text-gray-700 mb-6">Anda akan mendapatkan link untuk mengubah password anda di email.</p>

@if (session('status'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.password.email') }}" class="space-y-6">
    @csrf

    <div>
        <label for="email" class="sr-only">Email Address</label>
        <div class="relative">
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                   placeholder="Masukkan email anda"
                   class="py-3 px-4 pl-12 pr-4 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus-royal-blue @error('email') border-red-500 @enderror">
            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        @error('email')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <button type="submit" class="w-full bg-navy-blue hover:bg-royal-blue text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
            UBAH PASSWORD
        </button>
    </div>

    <a class="inline-block align-baseline font-bold text-sm text-royal-blue hover:text-navy-blue" href="{{ route('admin.login') }}">
        Login?
    </a>
</form>
@endsection