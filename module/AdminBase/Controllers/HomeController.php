<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/8
 * Time: 12:07
 */

namespace Module\AdminBase\Controllers;


use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('index');
    }

    public function home(){
        return $this->view('home');
    }

    public function menu()
    {
        return response()->json(system_content('system_menu'));
    }

}