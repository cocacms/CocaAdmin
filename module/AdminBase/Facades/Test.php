<?php
namespace Module\AdminBase\Facades;
use Illuminate\Support\Facades\Facade;
use Module\AdminBase\Providers\Components\Hello;

/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/5
 * Time: 12:24
 */
class Test extends Facade
{
    protected static function getFacadeAccessor() { return Hello::class; }
}