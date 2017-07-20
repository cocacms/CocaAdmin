<?php

namespace App\Http\Controllers;

use App\Service\ContentService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    protected $content = null;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        //设置运行的模块名称
        $className =  get_class($this);
        $classNames = explode("\\",$className);
        if(count($classNames) >= 2){
            $content = app(ContentService::class);
            $content->set('currentModule',$classNames[1]);
        }

    }

    protected function view($view = null, $data = [], $mergeData = []){

        if(Auth::check()){
            View::share('_member',Auth::user());
        }
        $factory = app(ViewFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }
        $factory->addLocation(base_path('module'.DIRECTORY_SEPARATOR.get_current_module().DIRECTORY_SEPARATOR.'views'));
        return $factory->make($view, $data, $mergeData);
    }
}
