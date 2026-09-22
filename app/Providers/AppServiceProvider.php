<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider AS ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Produk;
use App\Policies\UserPolicy;
use App\Policies\ProdukPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class   => UserPolicy::class,
        Produk::class => ProdukPolicy::class,
    ];

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
        Carbon::setLocale('id');
        $this->registerPolicies();
        Paginator::useTailwind();
    }
}
