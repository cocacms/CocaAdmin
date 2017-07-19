<?php
namespace App\Service;


use App\Exceptions\UndefinedRouteException;

class Route extends \Illuminate\Routing\Route{
    public $permissionName;
    public $autoPermission = false;
    public $link;
    public $groupName;

    public function permissionName($name){
        $this->permissionName = $name;
        $this->groupName = \Illuminate\Support\Facades\Route::getCurrentGroupName();
        return $this;
    }

    public function autoPermission(){
        $this->autoPermission = true;
        return $this;
    }

    public function link($link){
        $routeCollection = \Illuminate\Support\Facades\Route::getRoutes();
        $routeCollection->refreshNameLookups();
        $route = $routeCollection->getByName($link);
        if($route == null)
            throw new UndefinedRouteException($link);
        $this->link = $route;
        return $this;
    }
}
