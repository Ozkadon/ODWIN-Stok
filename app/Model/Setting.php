<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
	protected $table = 'settings';
	protected $hidden = ['created_at', 'updated_at'];
}