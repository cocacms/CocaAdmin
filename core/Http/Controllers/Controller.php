<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\View\Factory as ViewFactory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function view($view = null, $data = [], $mergeData = []){
        $factory = app(ViewFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }
        $className =  get_class($this);
        $classNames = explode("\\",$className);
        if(count($classNames) < 2){
            return $factory;
        }
        $factory->addLocation(base_path('module'.DIRECTORY_SEPARATOR.$classNames[1].DIRECTORY_SEPARATOR.'views'));
        return $factory->make($view, $data, $mergeData);
    }
}
