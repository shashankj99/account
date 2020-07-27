<?php

namespace App\Providers;

use App\Category;
use App\Company;
use App\LedgerAccount;
use App\Policies\CategoryPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\LedgerAccountPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    // list of policies
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Company::class => CompanyPolicy::class,
        LedgerAccount::class => LedgerAccountPolicy::class,
    ];

    // function to register any authentication / authorization service
    public function boot()
    {
        $this->registerPolicies();

        // define an admin gate
        Gate::define('isAdmin', function($user) {
            return $user->email == config('app.admin');
        });
    }
}
