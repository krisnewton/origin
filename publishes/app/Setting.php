<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $primaryKey = 'slug';
	protected $keyType = 'string';

    public $timestamps = false;

    public function setting_values()
    {
    	return $this->hasMany('App\SettingValue', 'setting_id', 'id');
    }
}
