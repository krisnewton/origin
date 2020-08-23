<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\RoleAccess;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access', function ($user, $access_code, $owner_id = false) {
        	$is_allowed = RoleAccess::where('role_id', $user->role_id)->where('code', $access_code)->exists();
        	if ($is_allowed) {
        		if (is_numeric($owner_id)) {
	        		if ($user->id == $owner_id) {
	        			return true;
	        		}
	        		else {
	        			return false;
	        		}
        		}
        		else {
        			return true;
        		}
        	}
        	else {
        		return false;
        	}
        });
    }
}
