<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ModuleMiddlewareMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make:middleware';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new middleware class for module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module Middleware';

    protected $module = '';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/middleware.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    public function fire()
    {

        if (! $this->option('module')) {
            return $this->error('Missing required option: --module');
        }

        $this->module = $this->option('module');

        return parent::fire();
    }

    protected function rootNamespace()
    {
        return "Module\\$this->module\\Middlewares";
    }

    protected function getPath($name)
    {
        $path = base_path().DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';

        return str_replace_first("\\Module\\","\\module\\",$path);
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['module', 'o', InputOption::VALUE_REQUIRED, 'Which module will create the model.'],
        ];
    }
}
