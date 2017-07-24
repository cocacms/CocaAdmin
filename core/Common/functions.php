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
     * 获取系统配置
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
     * 系统上下文参数
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
        $content = (array)system_content('_modules');
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
    function array_value_not_null($array){
        return array_where($array, function ($value, $key) {
            return !is_null($value);
        });
    }
}