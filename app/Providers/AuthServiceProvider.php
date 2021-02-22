<?php

namespace App\Providers;

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
        Gate::define('delComment', function($user, $item){
            if(auth()->user()->id==$item->user_id && (strtotime($item->created_at)+86400)>time())
                {return true;}
            if(auth()->user()->role=='moderator' || auth()->user()->role=='admin')
                {return true;}
            return false;
        }); 

        Gate::define('Admin', function($user){
            if(auth()->user()->role=='admin')
                {return true;}            
            return false;
        });
        Gate::define('AdminModerator', function($user){
            if(auth()->user()->role=='moderator' || auth()->user()->role=='admin')
                {return true;}            
            return false;
        });
        Gate::define('Moderator', function($user){
            if(auth()->user()->role=='moderator')
                {return true;}            
            return false;
        });
        Gate::define('User', function($user){
            if(auth()->user()->role=='user')
                {return true;}            
            return false;
        });                    
    }
}
