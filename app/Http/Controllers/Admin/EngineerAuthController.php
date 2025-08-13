<?php

namespace App\Http\Controllers\Admin; // <<< PASTIKAN NAMESPACE INI

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan Anda menggunakan model User
use Illuminate\Http\Request; // Import Request
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session; // Import Session untuk flash message

class EngineerAuthController extends Controller
{
    public function showRegistrationForm()
    {
        // Anda bisa menambahkan logic jika halaman ini butuh otentikasi sendiri
        return view('engineer.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email', // Validasi email unik di tabel users
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate password acak (bisa digenerate di JS frontend jika ingin tombol refresh)
        // Untuk backend, kita akan generate di sini
        $randomPassword = Str::random(12);
        $hashedPassword = Hash::make($randomPassword);

        $adminUser = User::create([
            'name' => 'Admin', // Nama default, bisa diganti nanti di admin panel
            'email' => $request->input('email'),
            'password' => $hashedPassword,
            'role' => 'admin', // Set role menjadi admin
        ]);

        // Gunakan Session::flash untuk pesan sukses yang akan hilang setelah satu request
        Session::flash('success_message', "Akun admin {$adminUser->email} berhasil didaftarkan dengan password: {$randomPassword}");
        Session::flash('generated_password', $randomPassword); // Simpan password di session untuk ditampilkan

        return redirect()->route('engineer.accounts'); // Redirect ke daftar akun
    }

    public function showRegisteredAccounts()
    {
        $adminAccounts = User::where('role', 'admin')->get();
        return view('engineer.accounts', compact('adminAccounts'));
    }

    public function resetPassword(Request $request, User $user)
    {
        // Memastikan hanya bisa mereset password untuk role admin
        if ($user->role !== 'admin' && $user->role !== 'superadmin') {
            return redirect()->back()->withErrors(['message' => 'Hanya akun admin/superadmin yang passwordnya bisa direset melalui halaman ini.']);
        }

        $newRandomPassword = Str::random(12);
        $user->password = Hash::make($newRandomPassword);
        $user->save();

        // Simpan password baru di session untuk ditampilkan (hanya sekali)
        Session::flash('success', "Password untuk akun {$user->email} berhasil direset.");
        Session::flash('generated_password', $newRandomPassword);

        return redirect()->back(); // Kembali ke halaman daftar akun
    }
}