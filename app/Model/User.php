<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	protected $hidden = ['user_level_id', 'password', 'created_at', 'updated_at'];
	
	public function level()
	{
		return $this->belongsTo('App\Model\UserLevel', 'user_level_id');
	}

	public function avatar()
	{
		return $this->belongsTo('App\Model\MediaLibrary', 'avatar_id');
	}
	
	public function media_image_1()
	{
		return $this->belongsTo('App\Model\MediaLibrary', 'avatar_id');
	}
	
	public function user_modify()
	{
		return $this->belongsTo('App\Model\User', 'user_modified');
	}
}