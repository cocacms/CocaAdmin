<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ModuleCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建一个模块';


    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $moduleName = $this->argument('name');
        $modulePath = base_path('module'.DIRECTORY_SEPARATOR.$moduleName);
        if($this->files->exists($modulePath)){
            $this->error('module '.$moduleName.' already exists!');
            return false;
        }

        if (! $this->files->makeDirectory($modulePath, 0777, true, true)) {
            $this->error('create module '.$moduleName.' error!');
            return false;
        }

        $childDir = [
            'Facades',
            'Model',
            'Providers',
            'Controllers',
            'Middleware',
            'routes'
        ];

        foreach ($childDir as $dir){
            $this->files->makeDirectory($modulePath.DIRECTORY_SEPARATOR.$dir, 0777, true, true);
        }

        $childFile = [
            'routes'.DIRECTORY_SEPARATOR.'admin.php' => null,
            'routes'.DIRECTORY_SEPARATOR.'web.php' => null,
            'routes'.DIRECTORY_SEPARATOR.'api.php' => null,
            'ModuleProviders.php',
            'ModuleMiddleware.php',
            'functions.php'
        ];
    }
}
