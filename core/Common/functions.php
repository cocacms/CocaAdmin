<?php

if(!function_exists('captcha_check'))
{
    /**
     * 验证验证码
     * @param $captcha
     * @return bool
     */
    function captcha_check($captcha)
    {
        $_captcha = session('_captcha');
        $captchaBuild = new \Gregwar\Captcha\CaptchaBuilder();
        $captchaBuild->setPhrase($_captcha);
        return $captchaBuild->testPhrase($captcha);
    }
}


if(!function_exists('error_json'))
{

    /**
     * 错误数据通用格式
     * @param string $msg
     * @param int $code
     * @param array $data
     * @return array
     */
    function error_json($msg = '系统发生错误！', $code = 1, $data = [])
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' =>$data
        ];
    }
}

if(!function_exists('success_json'))
{
    /**
     * 正确数据通用格式
     * @param array $data
     * @param int $code
     * @param string $msg
     * @return array
     */
    function success_json($data = [], $code = 0, $msg = '操作成功！')
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' =>$data
        ];
    }
}

if(!function_exists('get_current_module'))
{
    /**
     * 获取当前访问的模块名
     * @return mixed
     */
    function get_current_module()
    {
        $content = app(App\Service\ContentService::class);
        return $content->get('currentModule');
    }
}


if(!function_exists('system_config'))
{
    /**
     * 获取系统配置 保存在缓存中
     * @param array ...$params
     * @return mixed
     */
    function system_config(...$params)
    {
        $content = app(App\Service\ContentService::class);
        return $content->config(...$params);
    }
}


if(!function_exists('system_content'))
{
    /**
     * 系统上下文参数 不会缓存 在本次请求结束后清除
     * @param array ...$params
     * @return bool
     */
    function system_content(...$params)
    {
        $content = app(App\Service\ContentService::class);
        if(count($params) == 2){
            $content->set($params[0],$params[1]);
            return true;
        }else{
            return $content->get($params[0]);
        }
    }
}
if(!function_exists('now'))
{
    /**
     * 时间格式化 默认当前时间
     * @param null $format
     * @param null $time
     * @return false|string
     */
    function now($format = null,$time = null){
        $time = $time === null ? time() : $time;
        $format = $format === null ? 'Y-m-d H:i:s' : $format;
        return date($format,time());
    }
}

if(!function_exists('module_config')){
    /**
     * 获取模块配置
     * @param $module
     * @param $name
     * @return null
     */
    function module_config($module, $name){
        $name = "$module.$name";
        $content = app('modules');
        return array_get($content,$name);
    }
}

if(!function_exists('module_temp_json')){
    /**
     * 编译模块配置文字/数组模板
     * @param $module
     * @param $name
     * @param $params
     * @return mixed|null
     */
    function module_temp_json($module, $name, $params){

        function handlerArray ($temp,$params){
            foreach ($temp as $k => $v){
                if(is_array($v)){
                    $temp[$k] = handlerArray($v,$params);
                }else{
                    $temp[$k] = preg_replace_callback('/^\$\{([^\}]+)\}$/', function($matches)use ($params){
                        return (string)$params[$matches[1]];
                    }, $v);
                }
            }
            return $temp;
        };
        $temp = module_config($module,"temp.$name");
        if (is_null($temp)) return null;
        if(is_string($temp)){
            return preg_replace_callback('/\$\{([^\}]+)\}/', function($matches)use ($params){
                return (string)$params[$matches[1]];
            }, $temp);
        }

        if (is_array($temp)){
            return handlerArray($temp,$params);
        }
        return null;
    }

}

if (!function_exists('array_value_not_null')){
    /**
     * 剔除数组中null的项
     * @param $array
     * @return array
     */
    function array_value_not_null($array){
        return array_where($array, function ($value, $key) {
            return !is_null($value);
        });
    }
}

if (!function_exists('module_status')){


    /**
     * 模块开启关闭
     * @param $name
     * @param null $status
     * @return bool
     */
    function module_status($name, $status = null){
        if (is_null($status)){
            $is = app('cache')->get($name,0);
            return $is == 1;

        }
        app('cache')->forever($name, $status);
        return true;
    }
}
if (!function_exists('module_path')){
    function module_path($name,$path = null){
        if (is_null($path)){
            return base_path('module'.DIRECTORY_SEPARATOR.$name);
        }else{
            return base_path('module'.DIRECTORY_SEPARATOR.$name.DIRECTORY_SEPARATOR.$path);
        }
    }
}


if (!function_exists('link_module_asset')){
    function link_module_asset($name){
        if (!file_exists(module_path($name,'assets'))) {
            throw new \Exception('The "module/'.$name.'/assets" directory not exists.');
        }

        if (!file_exists(public_path('module'))) {
            throw new \Exception('The "'.public_path('module').'" directory not exists, please create at first.');
        }

        if (file_exists(public_path('module'.DIRECTORY_SEPARATOR.$name))) {
            throw new \Exception('The "module/'.$name.'/assets" directory already exists.');
        }

        app('files')->link(
            module_path($name,'assets'), public_path('module'.DIRECTORY_SEPARATOR.$name)
        );

        app('files')->chmod(
            public_path('module'.DIRECTORY_SEPARATOR.$name),0777
        );

    }
}

if (!function_exists('unlink_module_asset')){
    function unlink_module_asset($name){
        if (!file_exists(public_path('module'.DIRECTORY_SEPARATOR.$name))) {
            throw new \Exception('The "module/'.$name.'" directory not exists.');
        }
        app('files')->chmod(
            public_path('module'.DIRECTORY_SEPARATOR.$name),0777
        );

        app('files')->delete(
            public_path('module'.DIRECTORY_SEPARATOR.$name)
        );

    }
}