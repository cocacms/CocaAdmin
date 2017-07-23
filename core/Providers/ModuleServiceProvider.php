<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace App\Providers;


use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    private $modules = [];

    public function boot(){

        $this->app->booted(function () {
            //读取模块
            $current_dir = opendir(base_path('module'));
            while(($file = readdir($current_dir)) !== false) {
                if ( $file != '.' && $file != '..')
                {
                    $cur_path = base_path('module'.DIRECTORY_SEPARATOR.$file);
                    if ( is_dir ( $cur_path ))
                    {
                        $this->modules[] = $file;
                    }
                }
            }
            closedir($current_dir);

            //读取配置与目录信息
            foreach ($this->modules as $module){
                if(file_exists(base_path('module'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'config.php'))){
                    $config = include base_path('module'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'config.php');
                    $menu = system_content('system_menu') == null ? [] : system_config('system_menu');
                    if (isset($config['menu'])){
                        $menu = array_merge($menu,$config['menu']);
                        system_content('system_menu',$menu);
                        unset($config['menu']);
                    }
                    $moduleConfig = system_content('_modules') == null? [] : system_config('_modules');
                    $moduleConfig[$module] = $config;
                    system_content('_modules',$moduleConfig);

                }

                if(file_exists(base_path('module'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'functions.php'))){
                    require_once base_path('module'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'functions.php');
                }
            }
        });


    }
}