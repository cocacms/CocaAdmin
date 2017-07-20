<?php

namespace Module\AdminBase\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model implements Authenticatable
{
    use auth;

    protected $fillable = ['username','password','avatar','nickname','sex','tel','birthday','mail'];
    /**
     * 属于该用户的身份。
     */
    public function roles()
    {
        return $this->belongsToMany('Module\AdminBase\Models\Role','role_member_relations');
    }
}
