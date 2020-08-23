<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'avatar', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatar()
    {
    	if ($this->avatar) {
    		return $this->avatar;
    	}
    	else {
    		$name = $this->name;

    		$backgrounds = [
    			'EF5350',
    			'EC407A',
    			'AB47BC',
    			'7E57C2',
    			'5C6BC0',
    			'1E88E5',
    			'0288D1',
    			'0097A7',
    			'009688',
    			'43A047',
    			'558B2F',
    			'827717',
    			'E65100',
    			'F4511E',
    			'A1887F',
    			'757575'
    		];
    		$key = array_rand($backgrounds);

    		$data = [
    			'name' 			=> $name,
    			'background' 	=> $backgrounds[$key],
    			'color' 		=> 'fff',
    			'size'			=> 256
    		];
    		$data = http_build_query($data);

    		$url = 'https://ui-avatars.com/api/?' . $data;

    		$this->avatar = $url;
    		$this->save();

    		return $url;
    	}
    }

    public function role()
    {
    	return $this->belongsTo('App\Role');
    }

    public function name()
    {
    	if ($this->role_id == 1) {
    		return $this->name . '';
    	}
    	elseif ($this->role_id == 2) {
    		return $this->name;
    	}
    	else {
    		return $this->name;
    	}
    }
}
