<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TeamRepositoryInterface;
use App\Repositories\EloquentTeamRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            TeamRepositoryInterface::class,
            EloquentTeamRepository::class
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
