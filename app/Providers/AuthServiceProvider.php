<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Brand' => 'App\Policies\BrandPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\Client' => 'App\Policies\ClientPolicy',
        'App\Models\ClientGroup' => 'App\Policies\ClientPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
        'App\Models\Supplier' => 'App\Policies\SupplierPolicy',
        'App\Models\Warehouse' => 'App\Policies\WarehousePolicy',
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\Order' => 'App\Policies\OrderPolicy',
        'App\Models\Stock' => 'App\Policies\StockPolicy',
        'App\Models\Marketer' => 'App\Policies\MarketerPolicy',
        'App\Models\ShippingCompany' => 'App\Policies\ShippingCompanyPolicy',
        'App\Models\Template' => 'App\Policies\TemplatePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
