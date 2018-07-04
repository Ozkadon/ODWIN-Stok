<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AccessControl extends Model {
	protected $table = 'access_control';
	protected $hidden = ['created_at', 'updated_at'];
	
	public function user_modify()
	{
		return $this->belongsTo('App\Model\User', 'user_modified');
	}

	public function module()
	{
		return $this->belongsTo('App\Model\Module', 'module_id');
	}

	public function level()
	{
		return $this->belongsTo('App\Model\UserLevel', 'user_level_id');
	}
	
}