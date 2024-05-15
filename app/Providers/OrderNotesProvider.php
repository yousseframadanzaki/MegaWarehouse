<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\OrderNotes\Interfaces\OrderNotesRepositoryInterface;
use App\OrderNotes\Interfaces\OrderNotesServiceInterface;
use App\OrderNotes\Repositories\OrderNotesRepository;
use App\OrderNotes\Services\OrderNotesService;

class OrderNotesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OrderNotesRepositoryInterface::class,OrderNotesRepository::class);
        $this->app->bind(OrderNotesServiceInterface::class,OrderNotesService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
