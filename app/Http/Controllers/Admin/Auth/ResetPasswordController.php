<?php

namespace App\Http\Controllers\Admin\Auth; // <<< PASTIKAN NAMESPACE INI

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords; // Trait untuk reset password
use Illuminate\Http\Request; // Import Request

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin'; // Redirect ke dashboard admin setelah reset password

    /**
     * Create a new controller instance.
     * Middleware 'guest:admin' akan memastikan hanya tamu yang bisa akses reset password.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Display the password reset view.
     * Ini adalah metode yang akan menampilkan form untuk memasukkan password baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        ); // Merujuk ke resources/views/admin/auth/passwords/reset.blade.php
    }
}