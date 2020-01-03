<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use App\Policies\ProductPolicy;
use App\Policies\PurchasePolicy;
use App\Policies\SalesPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UsersManagementPolicy;
use App\Policies\ReportPolicy;
use App\Product;
use App\Purchase;
use App\Sale;
use App\Supplier;
use App\User;
use Facade\FlareClient\Report;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Sale::class => SalesPolicy::class,
        Product::class => ProductPolicy::class,
        Purchase::class => PurchasePolicy::class,
        Supplier::class => SupplierPolicy::class,
        Report::class => ReportPolicy::class,
        User::class => UsersManagementPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
