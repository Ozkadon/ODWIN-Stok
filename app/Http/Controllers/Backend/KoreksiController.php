<?php

namespace App\Http\Controllers\Backend;

use Session;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Stok;
use App\Model\Barang;
use Illuminate\Support\Facades\Redirect;

class KoreksiController extends Controller {
	public function index(Request $request) {
		return view ('backend.koreksi.index');
	}
	
    public function update(Request $request)
    {
        $detail = new Stok();
        $detail->id_barang = $request->id_bahan_baku;
        $detail->jumlah = $request->jumlah / 1;
        $detail->keterangan = "Koreksi Stok";
        $detail->type = "koreksi";
        $detail->save();

        //UPDATE STOK TOTAL BARANG
        $data = Barang::find($request->id_bahan_baku);
        $data->stok_total = ($data->stok_total / 1) + ($request->jumlah / 1);
		if($data->save()){
			return Redirect::to('/backend/koreksi-stok')->with('success', "Data saved successfully")->with('mode', 'success');
		}
    }
    
	public function popup_media_barang() {
		return view ('backend.koreksi.view_barang');
	}
    
}