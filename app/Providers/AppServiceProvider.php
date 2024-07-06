<?php

namespace App\Providers;

use App\Models\ChoiceMultiple;
use App\Notifications\EmailVerification;
use App\Policies\ChoiceMultiplePolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::policy(ChoiceMultiple::class, ChoiceMultiplePolicy::class);
        Paginator::useBootstrap(); 
        // Event::listen(
        //     EmailVerification::class
        // );
    }
}
