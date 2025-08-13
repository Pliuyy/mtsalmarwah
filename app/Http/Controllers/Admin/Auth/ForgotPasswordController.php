<?php

namespace App\Http\Controllers\Admin\Auth; // <<< PASTIKAN NAMESPACE INI

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails; // Trait untuk kirim email reset password
use Illuminate\Support\Facades\Password; // Facade Password

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     * Middleware 'guest:admin' akan memastikan hanya tamu yang bisa akses lupa password.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email'); // Merujuk ke resources/views/admin/auth/passwords/email.blade.php
    }

    /**
     * Get the broker to be used during password reset.
     * Penting untuk memastikan Laravel menggunakan broker 'admins'
     * yang kita definisikan di config/auth.php untuk reset password admin.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }
}