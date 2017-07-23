<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace App\Exceptions;

use Exception;
use Throwable;

class UndefinedRouteException extends Exception
{
    public function __construct($name)
    {
        parent::__construct("\tRoute $name Undefined \n\t路由 $name 未定义\n\t友情提示：请将link的对应Route移到本条link之前");
    }
}