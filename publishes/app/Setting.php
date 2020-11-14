<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	public function getRouteKeyName()
	{
		return 'slug';
	}

    public $timestamps = false;

    public function setting_values()
    {
    	return $this->hasMany('App\SettingValue', 'setting_id', 'id');
    }
}
