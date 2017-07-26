<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace App;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\ProviderRepository;

class Application extends \Illuminate\Foundation\Application
{
    public function __construct($basePath = null)
    {
        parent::__construct($basePath);
        $this->load_modules();
    }

    /**
     * 重写:路径
     * Get the path to the application "app" directory.
     *
     * @param string $path Optionally, a path to append to the app path
     * @return string
     */
    public function path($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'core'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }


    /**
     * 重写:读取模块中的Provider并加入到配置中
     *
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        (new ProviderRepository($this, new Filesystem(), $this->getCachedServicesPath()))
            ->load($this->config['app.providers']);

        $modules = app('modules');
        $allModuleProviders = [];
        foreach ($modules as $moduleName =>$config){
            $path = base_path('module'.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'ModuleProviders.php');
            if(file_exists($path) && ($config['auto'] || module_status($moduleName))){
                $moduleProviders = include $path;
                $allModuleProviders = array_merge($allModuleProviders,$moduleProviders);
            }
        }

        (new ProviderRepository($this, new Filesystem(), $this->getCachedServicesPath()))
            ->load($allModuleProviders);

        $this->load_module_middleware();
        $this->load_module_func();
    }


    /**
     * 加载模块 将配置注册成为服务
     */
    public function load_modules()
    {
        $modulesList = [];
        $current_dir = opendir(base_path('module'));
        while(($file = readdir($current_dir)) !== false) {
            if ( $file != '.' && $file != '..')
            {
                $cur_path = base_path('module'.DIRECTORY_SEPARATOR.$file);
                if ( is_dir ( $cur_path ))
                {
                    $modulesList[] = $file;
                }
            }
        }
        closedir($current_dir);

        //载入配置
        $modules = [];
        foreach ($modulesList as $module){
            $path = base_path('module'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'config.php');
            if(file_exists($path)){
                $config = include $path;
                $modules[$module] = $config;

            }
        }

        $this->instance('modules', collect($modules));
    }

    /**
     * 载入模块自定义函数
     */
    public function load_module_func()
    {
        $modules = app('modules');
        foreach ($modules as $moduleName =>$config){
            $path = base_path('module'.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'functions.php');
            if(file_exists($path) && ($config['auto'] || module_status($moduleName))){
                require_once $path;
            }
        }

    }

    public function load_module_middleware()
    {
        $modules = app('modules');
        $router = app('router');
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
        foreach ($modules as $moduleName => $config){
            if ($config['auto'] || module_status($moduleName)){
                $moduleMiddlewareClassName =  '\\Module\\'.$moduleName.'\\ModuleMiddlewares';
                $moduleMiddlewareClass = new $moduleMiddlewareClassName;

                foreach ($moduleMiddlewareClass->getMiddleware() as $middleware){
                    $kernel->pushMiddleware($middleware);
                }

                foreach ($moduleMiddlewareClass->getRouteMiddleware() as $key => $middleware) {
                    $router->aliasMiddleware($key, $middleware);
                }
                foreach ($moduleMiddlewareClass->getMiddlewareGroups() as $key => $middlewares) {
                    foreach ($middlewares as $middleware){
                        $router->pushMiddlewareToGroup($key, $middleware);
                    }
                }


            }
        }
    }

}