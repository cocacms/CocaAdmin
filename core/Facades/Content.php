<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace App\Facades;
use App\Service\ContentService;
use Illuminate\Support\Facades\Facade;

class Content extends Facade
{
    protected static function getFacadeAccessor() { return ContentService::class; }
}