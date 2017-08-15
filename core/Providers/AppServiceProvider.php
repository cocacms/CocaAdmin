<?php

namespace App\Providers;

use App\Console\Commands\MigrationCreator;
use App\Console\Commands\Migrator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('migrations.module.creator',function($app){
            return new MigrationCreator($app['files']);
        });

        $this->app->singleton('module.migrator',function($app){
            $repository = $app['migration.repository'];

            return new Migrator($repository, $app['db'], $app['files']);
        });
    }
}
