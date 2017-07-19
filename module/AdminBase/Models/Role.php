<?php
namespace Module\AdminBase\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    public function permissions()
    {
        return $this->hasMany('Module\AdminBase\Models\Permission');
    }
}
