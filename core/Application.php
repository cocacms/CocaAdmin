<?php
namespace App;

class Application extends \Illuminate\Foundation\Application
{
    public function path($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'core'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

}