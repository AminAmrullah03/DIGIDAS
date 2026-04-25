<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class NipAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Daftarkan custom provider yang login pakai NIP bukan email
        Auth::provider('nip', function ($app, array $config) {
            return new NipUserProvider($app['hash']);
        });
    }
}
