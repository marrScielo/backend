<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
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
        Response::macro('json', function ($value, $status = 200, array $headers = [], $options = 0) {
            return response()->json($value, $status, $headers, JSON_UNESCAPED_UNICODE);
        });
    }
}
