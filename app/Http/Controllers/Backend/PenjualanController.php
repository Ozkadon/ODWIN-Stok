<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\PenjualanH;
use App\Model\PenjualanD;
use App\Model\Barang;
use App\Model\Stok;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		return view ('backend.penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view ('backend.penjualan.update');
    }

    /**
     * Store a newly created resource in dosis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = new PenjualanH();
        $data->tanggal = date('Y-m-d', strtotime($request->tanggal));
		$data->no_nota = $request->no_nota;
        $data->keterangan = $request->keterangan;
		$data->active = 1;
        $data->user_modified = Session::get('userinfo')['user_id'];
        $total = 0;
		if($data->save()){
            $id_penjualan = $data->id;
            if (isset($_POST['id_bahan_baku'])){
                foreach ($_POST['id_bahan_baku'] as $key => $id_bahan_baku):
                    $detail = new PenjualanD();
                    $detail->id_penjualan = $data->id;
                    $detail->id_barang = $id_bahan_baku;
                    $detail->jumlah = $_POST['jumlah'][$key];
                    $detail->harga = $_POST['harga'][$key];
                    $total = $total + ($detail->jumlah * $detail->harga);
                    $detail->save();
                endforeach;
            }
            $data = PenjualanH::find($id_penjualan);
            $data->total = $total;
            $data->save();

            $dataH = PenjualanH::find($id_penjualan);
            $data = PenjualanD::where('id_penjualan', '=', $id_penjualan)->orderBy('id', 'ASC')->get();
            foreach ($data as $data):
                $detail = new Stok();
                $detail->id_barang = $data->id_barang;
                $detail->jumlah = $data->jumlah * -1;
                $detail->keterangan = $dataH->no_nota;
                $detail->type = "jual";
                $detail->save();
    
                $detail = Barang::find($data->id_barang);
                $detail->harga_jual = $data->harga;
                $detail->stok_total = $detail->stok_total - $data->jumlah;
                $detail->save();
            endforeach;
                
			return Redirect::to('/backend/penjualan/')->with('success', "Data saved successfully")->with('mode', 'success');
		}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\dosis  $dosis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$data = PenjualanH::with(['user_modify'])->where('id', $id)->get();
		if ($data->count() > 0){
            $detail = PenjualanD::with('barang')->where('id_penjualan','=',$data[0]->id)->orderBy('id', 'ASC')->get();
			return view ('backend.penjualan.view', ['data' => $data , 'detail' => $detail]);
		}
    }

    /**
     * Remove the specified resource from gudang.
     *
     * @param  \App\dosis  $dosis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
		$data = PenjualanH::find($id);
        $data->active = 0;
        $userinfo = Session::get('userinfo');
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){

            $data = PenjualanH::find($id);
            $data = Stok::where('keterangan', '=', $data->no_nota)->orderBy('id', 'ASC')->get();
            foreach ($data as $data):
                $detail = Barang::find($data->id_barang);
                $detail->stok_total = $detail->stok_total - $data->jumlah;
                $detail->save();
            endforeach;

            $data = PenjualanH::find($id);
            $res = Stok::where('keterangan', '=', $data->no_nota)->delete();
            
			Session::flash('success', 'Data deleted successfully');
			Session::flash('mode', 'success');
			return new JsonResponse(["status"=>true]);
		}else{
			return new JsonResponse(["status"=>false]);
		}

		return new JsonResponse(["status"=>false]);		
    }
    
	public function datatable() {
        $data = PenjualanH::select('penjualan_h.*')->where('penjualan_h.active', '!=', 0);
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				
                $url = url('backend/penjualan/'.$data->id);
                $view = "<a class='btn-action btn btn-primary' href='".$url."' title='View'><i class='fa fa-eye'></i></a>";
                $delete = "<button data-url='".$url."' onclick='deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash-o'></i></button>";

				if (!empty($access_control)) {
					if ($access_control[$userinfo['user_level_id']][$segment] == "v"){
						return $view;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "vu"){
						return $view;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "a"){
						return $view." ".$delete;
					}
				} else {
					return "";
				}
            })		
            ->editColumn('tanggal', function ($data) {
                return date('d-m-Y', strtotime($data->tanggal));
            })
            ->editColumn('total', function ($data) {
                return number_format($data->total,0,',','.');
            })
            ->make(true);		
	}

	public function popup_media_barang($id_count = null) {
		return view ('backend.penjualan.view_barang')->with('id_count', $id_count);
	}
    
}