<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // UUID-first route model binding with numeric ID fallback for zero-downtime rollout.
        Route::bind('member', fn (string $value) => Member::where('uuid', $value)->orWhere('id', $value)->firstOrFail());
        // Strict UUID binding for hardened endpoints that must not accept sequential IDs.
        Route::bind('memberUuid', fn (string $value) => Member::where('uuid', $value)->firstOrFail());
        Route::bind('book', fn (string $value) => Book::where('uuid', $value)->orWhere('id', $value)->firstOrFail());
        Route::bind('user', fn (string $value) => User::where('uuid', $value)->orWhere('id', $value)->firstOrFail());
    }
}
