<?php
namespace App\Service;
use Illuminate\Routing\Router;

class CRouter extends Router
{
    protected $groupName;
    protected function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))
            ->setRouter($this)
            ->setContainer($this->container);
    }

    public function getCurrentGroupName()
    {
        return $this->groupName;
    }

    public function group(array $attributes, $routes,$name = null)
    {
        if($name !== null) $this->groupName = $name;
        $this->updateGroupStack($attributes);

        // Once we have updated the group stack, we'll load the provided routes and
        // merge in the group's attributes when the routes are created. After we
        // have created the routes, we will pop the attributes off the stack.
        $this->loadRoutes($routes);

        array_pop($this->groupStack);
    }
}