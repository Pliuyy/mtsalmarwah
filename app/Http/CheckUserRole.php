<?php

namespace App\Http; // <<< PASTIKAN NAMESPACE INI ADALAH 'App\Http;'

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login, redirect ke halaman login admin
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Periksa apakah user yang login memiliki salah satu role yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            // Jika tidak memiliki role yang sesuai, tampilkan error 403 (Akses Dilarang)
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Jika user memiliki role yang sesuai, lanjutkan ke request berikutnya
        return $next($request);
    }
}