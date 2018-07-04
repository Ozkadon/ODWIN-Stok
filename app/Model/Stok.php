<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model {
	protected $table = 'stok';
	protected $hidden = ['created_at', 'updated_at'];
	
	
}