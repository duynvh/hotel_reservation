<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function () {
            if (Auth::user()->group->slug === 'admin')
                return true;
            else
                return false;

        });
        Gate::define('editor', function () {
            if (Auth::user()->group->slug === 'editor')
                return true;
            else
                return false;

        });
        Gate::define('member', function () {
            if (Auth::user()->group->slug === 'member')
                return true;
            else
                return false;

        });
        //action
        Gate::define('add', function () {
            if (Auth::user()->group->slug === 'admin' || Auth::user()->group->slug === 'editor')
                return true;
            else
                return false;
        });
        Gate::define('edit', function () {
            if (Auth::user()->group->slug === 'admin' || Auth::user()->group->slug === 'editor')
                return true;
            else
                return false;
        });
        Gate::define('delete', function () {
            if (Auth::user()->group->slug === 'admin' || Auth::user()->group->slug === 'editor')
                return true;
            else
                return false;
        });

    }
}