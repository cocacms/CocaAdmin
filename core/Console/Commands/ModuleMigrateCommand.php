<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
class ModuleMigrateCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:migrate {name} {--database= : The database connection to use.}
                {--force : Force the operation to run when in production.}
                {--pretend : Dump the SQL queries that would be run.}
                {--seed : Indicates if the seed task should be re-run.}
                {--step : Force the migrations to be run so they can be rolled back individually.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the database migrations for module';




    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (! $this->argument('name')) {
            return $this->error('Missing required argument: name');
        }

        $module = $this->argument('name');

        $this->call('migrate', [
            '--database' => $this->option('database'),
            '--force' => $this->option('force'),
            '--pretend' => $this->option('pretend'),
            '--seed' => $this->option('seed'),
            '--step' => $this->option('step'),
            '--path' => [
                "module\\$module\\migrations"
            ],

        ]);
    }
}
