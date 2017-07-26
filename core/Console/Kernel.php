<?php

namespace App\Console;

use App\Console\Commands\ModuleControllerMakeCommand;
use App\Console\Commands\ModuleCreate;
use App\Console\Commands\ModuleMiddlewareMakeCommand;
use App\Console\Commands\ModuleMigrateCommand;
use App\Console\Commands\ModuleMigrateMakeCommand;
use App\Console\Commands\ModuleModelMakeCommand;
use App\Console\Commands\ModuleRollbackCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ModuleCreate::class,
        ModuleModelMakeCommand::class,
        ModuleMigrateMakeCommand::class,
        ModuleControllerMakeCommand::class,
        ModuleMiddlewareMakeCommand::class,
        ModuleMigrateCommand::class,
        ModuleRollbackCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
