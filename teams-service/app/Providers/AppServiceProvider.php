<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\{TeamRepositoryInterface,FixtureRepositoryInterface,StandingRepositoryInterface};
use App\Repositories\{EloquentTeamRepository,EloquentFixtureRepository,EloquentStandingRepository};

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            TeamRepositoryInterface::class,
            EloquentTeamRepository::class
        );

        $this->app->bind(
            FixtureRepositoryInterface::class,
            EloquentFixtureRepository::class
        );

        $this->app->bind(
            StandingRepositoryInterface::class,
            EloquentStandingRepository::class
        );
        
        $this->app->singleton(\App\Services\TeamService::class, function ($app) {
            return new \App\Services\TeamService($app->make(TeamRepositoryInterface::class));
        });
    }

    public function boot()
    {
        //
    }
}
