<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace App\Console\Commands;


class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{
    public function stubPath()
    {
        return __DIR__.'/stubs/migrations';
    }

}