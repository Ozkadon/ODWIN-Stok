<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PurchaseD extends Model {
	protected $table = 'purchase_d';
	protected $hidden = ['created_at', 'updated_at'];
	
	public function purchase()
	{
		return $this->belongsTo('App\Model\PurchaseH', 'id_purchase');
	}

	public function barang()
	{
		return $this->belongsTo('App\Model\Barang', 'id_barang');
	}
    
}