<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class CheckToken extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Sanctum::$accessTokenAuthenticationCallback = function ($accessToken, $isValid) {
        //     return !$accessToken->last_used_at || $accessToken->last_used_at->gte(now()->subHours(72));
        // };
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
