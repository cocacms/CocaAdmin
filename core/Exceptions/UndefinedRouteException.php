<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/19
 * Time: 17:46
 */

namespace App\Exceptions;


use Exception;
use Throwable;

class UndefinedRouteException extends Exception
{
    public function __construct($name)
    {
        parent::__construct("Route $name Undefined \n路由 $name 未定义\n友情提示：请将link的对应Route移到本条link之前");
    }
}