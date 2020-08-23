<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessGroup extends Model
{
	public $timestamps = false;
	
    public function accesses()
    {
    	return $this->hasMany('App\Access');
    }
}
