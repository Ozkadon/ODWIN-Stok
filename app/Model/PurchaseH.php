<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PurchaseH extends Model {
	protected $table = 'purchase_h';
	protected $hidden = ['created_at', 'updated_at'];
	
	public function user_modify()
	{
		return $this->belongsTo('App\Model\User', 'user_modified');
	}

	public function supplier()
	{
		return $this->belongsTo('App\Model\Supplier', 'id_sup');
	}
    
}