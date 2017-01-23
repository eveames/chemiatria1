<?php

namespace chemiatria\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'chemiatria\Model' => 'chemiatria\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create_word', function ($user) {
            return $user->auth_type !== 'student';
        });

        Gate::define('edit_word', function ($user) {
            return $user->auth_type == 'admin';
        });

        Gate::define('use_word', function ($user) {
            return $user->auth_type == 'student';
        });

        //
    }
}
