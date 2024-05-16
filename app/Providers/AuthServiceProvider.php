<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = ['App\Model' => 'App\Policies\ModelPolicy', 'App\Modules\Auth\Admin\Models' => 'App\Policies\ModelPolicy', 'App\Modules\Auth\Responsible\Models' => 'App\Policies\ModelPolicy',];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        try {
            $rolesArr = [];
            $roles = Role::all();
            foreach ($roles as $role) {
                $rolesArr[$role->name] = 'desc';
            }
            Passport::tokensCan($rolesArr);
        } catch (\Exception $exception) {

        }
        if (!$this->app->routesAreCached()) {
            Passport::routes();
        }
        //
    }
}
