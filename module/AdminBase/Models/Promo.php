<?php

namespace Module\AdminBase\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = ['tag','name','link','target','pic','description','content','show','order'];
}
