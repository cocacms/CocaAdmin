<?php
namespace Module\AdminBase\Controllers;
use App\Http\Controllers\Controller;

/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/6
 * Time: 20:51
 */
class TestController extends Controller
{
    public function test(){
        return $this->view('test',['test'=>'this is test']);
    }
}