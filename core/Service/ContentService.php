<?php
namespace App\Service;
use Illuminate\Support\Facades\Cache;

/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */
class ContentService
{
    private $content = [];

    public function __construct()
    {
        $this->loadConfig();
    }

    public function get($key){
        return isset($this->content[$key])?$this->content[$key]:null;
    }

    public function set($key,$value){
        $this->content[$key] = $value;
    }

    public function config(...$params){
        if(count($params) == 0){
            return null;
        }
        if(count($params) == 1){
            if(isset($this->content['_config'][$params[0]]))
                return $this->content['_config'][$params[0]];
        }

        if(count($params) == 2){
            $this->content['_config'][$params[0]] = $params[1];
            $this->saveConfig();
            return true;
        }

        return null;
    }

    private function saveConfig(){
        if(isset($this->content['_config'])){
            Cache::forever('_system_config',serialize($this->content['_config']));
        }
    }

    private function loadConfig(){
        $config = Cache::get('_system_config',serialize([]));
        $config = unserialize($config);
        $this->content['_config'] = $config;
    }

}