<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset "broker" for your application. You may change these defaults
    | as required, but they're a good starting point for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Each authentication guard defines how users are authenticated for your
    | application. Of course, you're not limited to these options and may
    | even define multiple guards for use throughout your application.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [ // <<< PASTIKAN BAGIAN GUARD 'admin' INI ADA
            'driver' => 'session',
            'provider' => 'admins', // Menggunakan provider 'admins' yang akan kita definisikan
        ],

        // 'api' => [
        //     'driver' => 'token',
        //     'provider' => 'users',
        //     'hash' => false,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your persistence layer.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [ // <<< PASTIKAN BAGIAN PROVIDER 'admins' INI ADA
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // Menggunakan model User dengan role
        ],

        // 'dummy' => [ // Contoh provider dummy, biasanya tidak perlu
        //     'driver' => 'array',
        //     'users' => [
        //         'admin@example.com' => ['password' => bcrypt('secret')],
        //     ],
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model. Each configuration can have its own
    | settings independent of any other.
    |
    | Supported: "database", "eloquent"
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets', // Tabel default untuk reset password
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [ // <<< PASTIKAN BAGIAN PASSWORD RESET 'admins' INI ADA
            'provider' => 'admins', // Menggunakan provider 'admins'
            'table' => 'password_resets', // Bisa menggunakan tabel yang sama atau tabel khusus 'admin_password_resets'
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password.
    |
    */

    'password_timeout' => 10800,

];