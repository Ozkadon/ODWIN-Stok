<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PenjualanD extends Model {
	protected $table = 'penjualan_d';
	protected $hidden = ['created_at', 'updated_at'];
	
	public function penjualan()
	{
		return $this->belongsTo('App\Model\PenjualanH', 'id_penjualan');
	}

	public function barang()
	{
		return $this->belongsTo('App\Model\Barang', 'id_barang');
	}
    
}