<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/5
 * Time: 12:24
 */

namespace App\Facades;
use App\Service\ContentService;
use Illuminate\Support\Facades\Facade;

class Content extends Facade
{
    protected static function getFacadeAccessor() { return ContentService::class; }
}