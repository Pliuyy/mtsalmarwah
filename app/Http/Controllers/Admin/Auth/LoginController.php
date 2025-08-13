<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = route(RouteServiceProvider::ADMIN_HOME);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->intended(route(RouteServiceProvider::ADMIN_HOME));
        }
        
        Auth::logout();
        return redirect()->route(RouteServiceProvider::ADMIN_LOGIN)
            ->withErrors(['email' => 'Anda tidak memiliki akses ke halaman admin.']);
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    //nambahan function login (asalna teuing kamana awakowqko)
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Cek kredensial dan role admin
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        // ieu ukur debug meh katingali tadi penyebab error, ternyata aman mun pake password anu di seeder
        Log::info('Login Attempt:', [
            'email' => $credentials['email'],
            'user_exists' => $user ? 'Yes' : 'No',
            'role' => $user ? $user->role : 'N/A',
            'is_admin' => $user && $user->isAdmin() ? 'Yes' : 'No'
        ]);

        // Cek apakah user ada dan memiliki role admin
        if (!$user || !$user->isAdmin()) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Email atau password yang Anda masukkan salah.',
                ]);
        }

        // Coba login dengan password yang diberikan
        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            Log::info('Password verification failed for user: ' . $credentials['email']);
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Email atau password yang Anda masukkan salah.',
                ]);
        }

        // Login berhasil
        Log::info('Login successful for user: ' . $credentials['email']);
        
        return $this->authenticated($request, $user);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route(RouteServiceProvider::ADMIN_LOGIN);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);
    }
}