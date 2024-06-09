<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Whatsapp\Interfaces\WhatsappRepositoryInterface;
use App\Whatsapp\Interfaces\WhatsappServiceInterface;
use App\Whatsapp\Repositories\WhatsappRepository;
use App\Whatsapp\Services\WhatsappService;

class WhatsappServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WhatsappRepositoryInterface::class,WhatsappRepository::class);
        $this->app->bind(WhatsappServiceInterface::class,WhatsappService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
