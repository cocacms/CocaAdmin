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
    protected $description = 'Create a module';


    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    protected $moduleName;
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
        $this->moduleName = studly_case($this->argument('name'));
        $modulePath = module_path($this->moduleName);
        if($this->files->exists($modulePath)){
            $this->error('module '.$this->moduleName.' already exists!');
            return false;
        }

        if (! $this->files->makeDirectory($modulePath, 0777, true, true)) {
            $this->error('create module '.$this->moduleName.' error!');
            return false;
        }

        $dir = [
            'assets' =>[
                'css'=>null,
                'js'=>null,
                'resources'=>null,
            ],
            'Controllers'=>null,
            'Facades'=>null,
            'Middleware'=>null,
            'migrations'=>null,
            'Models'=>null,
            'Providers'=>[
                'Components'=>null,
                'ModuleServiceProvider.php'=>null
            ],
            'routes'=>[
                'admin.php'=>null,
                'api.php'=>null,
                'web.php'=>null
            ],
            'views'=>null,
            'config.php'=>null,
            'functions.php'=>null,
            'ModuleMiddlewares.php'=>null,
            'ModuleProviders.php'=>null,
        ];
        $this->handleFile('',$dir);
        $this->info($this->moduleName  .' Module created successfully.');
    }

    private function handleFile($parent,$dirs){
        $parent = empty($parent)? $parent : $parent.DIRECTORY_SEPARATOR;
        foreach ($dirs as $dir => $child){
            if (is_null($child) && ends_with($dir,'.php')){
                //创建文件
                $stub = $this->files->get(__DIR__.'/stubs/module/'.$dir.'.stub');
                $stub = str_replace('MODULE_NAME',$this->moduleName,$stub);
                $this->files->put(module_path($this->moduleName,$parent.$dir), $stub);
            }else{
                if(!$this->files->exists(module_path($this->moduleName,$parent.$dir))){
                    $this->files->makeDirectory(module_path($this->moduleName,$parent.$dir), 0777, true, true);
                }

                if (!is_null($child) && is_array($child)){
                    $this->handleFile($parent.$dir,$child);
                }

            }

        }
    }
}
