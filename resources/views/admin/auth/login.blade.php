@extends('layouts.admin_auth')

@section('title', 'Login Admin')

@section('content')
<p class="text-gray-700 mb-6">Silahkan Masuk untuk mengelola sistem sekolah.</p>

{{-- {{ ngubah route na, asalna salah tujuan  }} --}}
<form method="POST" action="{{ route('admin.login') }}" class="space-y-6"> 
    @csrf

    <div>
        <label for="email" class="sr-only">Email Address</label>
        <div class="relative">
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                   placeholder="Username atau Email"
                   class="py-3 px-4 pl-12 pr-4 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus-royal-blue @error('email') border-red-500 @enderror">
            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        @error('email')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="sr-only">Password</label>
        <div class="relative">
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   placeholder="Password"
                   class="py-3 px-4 pl-12 pr-4 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus-royal-blue @error('password') border-red-500 @enderror">
            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePasswordVisibility()">
                <i class="fas fa-eye" id="password-toggle-icon"></i>
            </button>
        </div>
        @error('password')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input class="form-checkbox h-4 w-4 text-royal-blue transition duration-150 ease-in-out" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="ml-2 block text-sm text-gray-900" for="remember">
                Ingat Saya
            </label>
        </div>
    </div>

    <div>
        <button type="submit" class="w-full bg-navy-blue hover:bg-royal-blue text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
            MASUK
        </button>
    </div>

    @if (Route::has('admin.password.request'))
        <a class="inline-block align-baseline font-bold text-sm text-royal-blue hover:text-navy-blue" href="{{ route('admin.password.request') }}">
            Lupa Password?
        </a>
    @endif
</form>

<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const passwordToggleIcon = document.getElementById('password-toggle-icon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordToggleIcon.classList.remove('fa-eye');
            passwordToggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            passwordToggleIcon.classList.remove('fa-eye-slash');
            passwordToggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection