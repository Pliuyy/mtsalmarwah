@extends('layouts.admin_auth')

@section('title', 'Reset Password Admin')

@section('content')
<p class="text-gray-700 mb-6">Masukkan password baru Anda.</p>

<form method="POST" action="{{ route('admin.password.update') }}" class="space-y-6">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email" class="sr-only">Email Address</label>
        <div class="relative">
            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                   placeholder="Email Anda"
                   class="py-3 px-4 pl-12 pr-4 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus-royal-blue @error('email') border-red-500 @enderror">
            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        @error('email')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="sr-only">Password Baru</label>
        <div class="relative">
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   placeholder="Password Baru"
                   class="py-3 px-4 pl-12 pr-4 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus-royal-blue @error('password') border-red-500 @enderror">
            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        @error('password')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password-confirm" class="sr-only">Konfirmasi Password</label>
        <div class="relative">
            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                   placeholder="Konfirmasi Password"
                   class="py-3 px-4 pl-12 pr-4 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus-royal-blue">
            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    <div>
        <button type="submit" class="w-full bg-navy-blue hover:bg-royal-blue text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
            RESET PASSWORD
        </button>
    </div>
</form>
@endsection