<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\PurchaseD;
use App\Model\PurchaseH;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class IndenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		return view ('backend.inden.index');
    }

	public function datatable() {	
        $data = PurchaseH::select('purchase_h.*','purchase_d.jumlah', 'barang.nama', 'purchase_h.no_inv', 'purchase_h.tanggal')->leftJoin('purchase_d', 'purchase_d.id_purchase', '=', 'purchase_h.id')->leftJoin('barang', 'purchase_d.id_barang', '=', 'barang.id')->where('purchase_h.active', '!=', 0)->where('purchase_h.status', '=','order');
        return Datatables::of($data)
        ->editColumn('tanggal', function ($data) {
            return date('d-m-Y', strtotime($data->tanggal));
        })
        ->editColumn('jumlah', function ($data) {
            return number_format($data->jumlah, 0,',','.');
        })
        ->make(true);		
	}

}
