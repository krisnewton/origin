<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
	public $timestamps = false;
    protected $fillable = ['role_id', 'code'];
}
