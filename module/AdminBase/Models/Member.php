<?php

namespace Module\AdminBase;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as auth;

class Member extends Model implements Authenticatable
{
    use auth;
}
