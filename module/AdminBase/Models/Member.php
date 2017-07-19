<?php

namespace Module\AdminBase\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as auth;

class Member extends Model implements Authenticatable
{
    use auth;

    /**
     * 属于该用户的身份。
     */
    public function roles()
    {
        return $this->belongsToMany('Module\AdminBase\Models\Role','role_member_relations');
    }
}
