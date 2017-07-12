<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/10
 * Time: 10:44
 */

namespace Module\AdminBase\Controllers;


use App\Facades\Content;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function config(){
        return $this->view('system.config');
    }

    public function submitConfig(Request $request){
        $data = $request->all();
        unset($data['webLogoFile']);
        unset($data['s']);
        unset($data['_token']);
        foreach ($data as $key=>$value){
            Content::config($key,$value);
        }
        return response()->json(success_json());
    }

}