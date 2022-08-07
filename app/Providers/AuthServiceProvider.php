<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Championship;
use App\Models\Player;
use App\Models\Team;
use App\Policies\ChampionshipPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Championship::class => ChampionshipPolicy::class,
        Team::class => TeamPolicy::class,
        Player::class => TeamPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
    }
}
