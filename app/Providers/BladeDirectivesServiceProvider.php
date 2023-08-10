<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('date_format', function ($date) {
            return "<?php echo ($date)->format('d-m-Y').'  '.($date)->format('g:i A'); ?>";
        });
    }
}
