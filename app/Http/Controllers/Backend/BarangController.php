<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Barang;
use App\Model\PurchaseD;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		return view ('backend.barang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view ('backend.barang.update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = new Barang();
        $data->kode = $request->kode;
		$data->nama = $request->nama;
        $data->img_id = $request->img_id;
        $data->harga_jual = $request->harga_jual / 1;
        $data->harga_beli = $request->harga_beli / 1;
        $data->stok_awal = $request->stok_awal / 1;
        $data->stok_total = $request->stok_awal / 1;
        $data->keterangan = $request->keterangan;
		$data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			return Redirect::to('/backend/barang')->with('success', "Data saved successfully")->with('mode', 'success');
		}

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$data = Barang::with(['user_modify'])->where('id', $id)->get();
		if ($data->count() > 0){
			return view ('backend.barang.view', ['data' => $data]);
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLevel  $userLevel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$data = Barang::where('id', $id)->where('active', '!=', 0)->get();
		if ($data->count() > 0){
			return view ('backend.barang.update', ['data' => $data]);
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = Barang::find($id);
        $data->kode = $request->kode;
		$data->nama = $request->nama;
        $data->img_id = $request->img_id;
        $data->harga_jual = $request->harga_jual / 1;
        $data->harga_beli = $request->harga_beli / 1;
        $data->stok_total = ($data->stok_total / 1) + (($request->stok_awal / 1) - ($data->stok_awal / 1));
        $data->stok_awal = $request->stok_awal / 1;
        $data->keterangan = $request->keterangan;
		$data->active = $request->active;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			return Redirect::to('/backend/barang')->with('success', "Data saved successfully")->with('mode', 'success');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLevel  $userLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
		$data = Barang::find($id);
		$data->active = 0;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			Session::flash('success', 'Data deleted successfully');
			Session::flash('mode', 'success');
			return new JsonResponse(["status"=>true]);
		}else{
			return new JsonResponse(["status"=>false]);
		}
    }
	
	public function datatable() {	
		$userinfo = Session::get('userinfo');
		$data = Barang::where('active', '!=', 0);
	
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				$url_edit = url('backend/barang/'.$data->id.'/edit');
                $url = url('backend/barang/'.$data->id);
                $url_harga = url('backend/barang/harga/'.$data->id);
				$view = "<a class='btn-action btn btn-primary btn-view' href='".$url."' title='View'><i class='fa fa-eye'></i></a>";
				$edit = "<a class='btn-action btn btn-info btn-edit' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a>";
                $delete = "<button data-url='".$url."' onclick='deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash-o'></i></button>";
                $harga = "<a class='btn-action btn btn-success btn-view' href='".$url_harga."' title='Histori'>Histori Beli</a>";
				if (!empty($access_control)) {
					if ($access_control[$userinfo['user_level_id']][$segment] == "v"){
						return $view;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "vu"){
						return $view." ".$edit." ".$harga;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "a"){
						return $view." ".$edit." ".$delete." ".$harga;
					}
				} else {
					return "";
				}
            })
            ->editColumn('harga_beli', function($data) {
                return number_format($data->harga_beli,0,',','.');
            })
            ->editColumn('harga_jual', function($data) {
                return number_format($data->harga_jual,0,',','.');
            })
            ->editColumn('jenis_mobil', function($data) {
                return str_ireplace("\r\n", ', ', $data->jenis_mobil);
            })
            ->editColumn('keterangan', function($data) {
                return str_ireplace("\r\n", ', ', $data->keterangan);
            })
            ->make(true);		
	}

	public function datatable_barang() {
		$data = Barang::select('barang.*')
		 ->where('barang.active', '!=', 0);
	
        return Datatables::of($data)
            ->make(true);		
    }        
    
	public function histori($id) {
        //
		$data = PurchaseD::with(['purchase'])->where('id_barang', $id)->orderBy('id', 'DESC')->limit(3)->get();
		return view ('backend.barang.histori', ['data' => $data]);
	}            
}
