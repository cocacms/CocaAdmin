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
     * 错误数据格式
     * @param string $msg
     * @return array
     */
    function error_json($msg = '系统发生错误！')
    {
        return [
            'code' => 0,
            'msg' => $msg,
            'data' =>[]
        ];
    }
}

if(!function_exists('success_json'))
{
    /**
     * 正确数据格式
     * @param array $data
     * @param string $msg
     * @return array
     */
    function success_json($data = [],$msg = '操作成功！')
    {
        return [
            'code' => 1,
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

