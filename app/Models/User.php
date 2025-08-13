<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- PASTIKAN BARIS INI ADA DAN TIDAK ADA ERROR DI SINI
use App\Notifications\AdminResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <<< PASTIKAN BARIS INI ADA
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin' || $this->role === 'superadmin';
    }

    /**
     * Kirim notifikasi reset password custom untuk admin
     */
    public function sendPasswordResetNotification($token)
    {
        // Jika user adalah admin, gunakan notifikasi custom
        if ($this->isAdmin()) {
            $this->notify(new AdminResetPasswordNotification($token, $this->email));
        } else {
            // Default Laravel
            parent::sendPasswordResetNotification($token);
        }
    }
}