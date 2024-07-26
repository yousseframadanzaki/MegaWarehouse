<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

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
        Paginator::useBootstrap();
        View::composer('*', function ($view) {
            $view->with([
                'host' => request()->getHost(),
                'hosts' => [
                    "local" => "127.0.0.1",
                    "zioot" => "zioot-hindi.com",
                    "blackwhite" => "blackandwhite-eg.com",
                ]
            ]);
        });
    }
}
