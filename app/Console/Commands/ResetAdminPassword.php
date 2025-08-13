<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password {email} {password}';
    protected $description = 'Reset password admin dengan email tertentu';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User dengan email {$email} tidak ditemukan!");
            return 1;
        }

        if (!$user->isAdmin()) {
            $this->error("User ini bukan admin!");
            return 1;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("Password berhasil direset untuk user {$email}");
        return 0;
    }
} 