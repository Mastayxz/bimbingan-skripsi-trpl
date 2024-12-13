<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Daftarkan middleware role
        Route::middleware('role', RoleMiddleware::class);
    }

    public function register()
    {
        //
    }
}
