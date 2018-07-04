<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\PurchaseH;
use App\Model\PurchaseD;
use App\Model\Barang;
use App\Model\Stok;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    	$status = 0;
    	$startDate = "01"."-".date('m-Y');
        $endDate = date('d-m-Y');
        $mode = "all";
		if (isset($_GET["startDate"]) || isset($_GET["endDate"]) || isset($_GET["status"]) || isset($_GET["mode"])){
			if ((isset($_GET['startDate'])) && ($_GET['startDate'] != "")){
				$startDate = $_GET["startDate"];
			}
			if ((isset($_GET['endDate'])) && ($_GET['endDate'] != "")){
				$endDate = $_GET["endDate"];
			}
			if ((isset($_GET['status'])) && ($_GET['status'] != "")){
				$status = $_GET["status"];
            }
			if (!isset($_GET["mode"])){
				$mode = "limited";
			}
        }

		view()->share('startDate',$startDate);
		view()->share('endDate',$endDate);
		view()->share('status',$status);
        view()->share('mode',$mode);
		return view ('backend.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view ('backend.purchase.update');
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
        $data = new PurchaseH();
        $data->tanggal = date('Y-m-d', strtotime($request->tanggal));
		$data->no_inv = $request->no_inv;
        $data->id_sup = $request->id_sup;
        $data->keterangan = $request->keterangan;
        $data->status = "order";
		$data->active = 1;
        $data->user_modified = Session::get('userinfo')['user_id'];
        $total = 0;
		if($data->save()){
            $id_purchase = $data->id;
            if (isset($_POST['id_bahan_baku'])){
                foreach ($_POST['id_bahan_baku'] as $key => $id_bahan_baku):
                    $detail = new PurchaseD();
                    $detail->id_purchase = $data->id;
                    $detail->id_barang = $id_bahan_baku;
                    $detail->jumlah = $_POST['jumlah'][$key];
                    $detail->harga = $_POST['harga'][$key];
                    $total = $total + ($detail->jumlah * $detail->harga);
                    $detail->save();
                endforeach;
            }
            $data = PurchaseH::find($id_purchase);
            $data->total = $total;
            $data->save();
			return Redirect::to('/backend/purchase-order/')->with('success', "Data saved successfully")->with('mode', 'success');
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
		$data = PurchaseH::with(['user_modify', 'supplier'])->where('id', $id)->get();
		if ($data->count() > 0){
            $detail = PurchaseD::with('barang')->where('id_purchase','=',$data[0]->id)->orderBy('id', 'ASC')->get();
			return view ('backend.purchase.view', ['data' => $data , 'detail' => $detail]);
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\dosis  $dosis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = PurchaseH::with('supplier')->where('id', $id)->where('active', '!=', 0)->get();
		if ($data->count() > 0){
            $detail = PurchaseD::with('barang')->where('id_purchase','=',$data[0]->id)->orderBy('id', 'ASC')->get();
			return view ('backend.purchase.update', ['data' => $data, 'detail' => $detail]);
		}
    }

    /**
     * Update the specified resource in dosis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\dosis  $dosis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = PurchaseH::find($id);
        $data->tanggal = date('Y-m-d', strtotime($request->tanggal));
		$data->no_inv = $request->no_inv;
        $data->id_sup = $request->id_sup;
        $data->keterangan = $request->keterangan;
        $data->user_modified = Session::get('userinfo')['user_id'];
        $total = 0;
		if($data->save()){
            $delete = PurchaseD::where('id_purchase', '=', $id)->delete();
            if (isset($_POST['id_bahan_baku'])){
                foreach ($_POST['id_bahan_baku'] as $key => $id_bahan_baku):
                    $detail = new PurchaseD();
                    $detail->id_purchase = $id;
                    $detail->id_barang = $id_bahan_baku;
                    $detail->jumlah = $_POST['jumlah'][$key];
                    $detail->harga = $_POST['harga'][$key];
                    $total = $total + ($detail->jumlah * $detail->harga);
                    $detail->save();
                endforeach;
            }
            $data = PurchaseH::find($id);
            $data->total = $total;
            $data->save();
			return Redirect::to('/backend/purchase-order/')->with('success', "Data saved successfully")->with('mode', 'success');
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
		$data = PurchaseH::find($id);
		$userinfo = Session::get('userinfo');

		$data->active = 0;
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			Session::flash('success', 'Data deleted successfully');
			Session::flash('mode', 'success');
			return new JsonResponse(["status"=>true]);
		}else{
			return new JsonResponse(["status"=>false]);
		}

		return new JsonResponse(["status"=>false]);		
    }

    public function received(Request $request, $id)
    {
        //
        $dataH = PurchaseH::find($id);
        $data = PurchaseD::where('id_purchase', '=', $id)->orderBy('id', 'ASC')->get();
        foreach ($data as $data):
            $detail = new Stok();
            $detail->id_barang = $data->id_barang;
            $detail->jumlah = $data->jumlah;
            $detail->keterangan = $dataH->no_inv;
            $detail->type = "beli";
            $detail->save();

            $detail = Barang::find($data->id_barang);
            $detail->harga_beli = $data->harga;
            $detail->stok_total = $detail->stok_total + $data->jumlah;
            $detail->save();
        endforeach;

		$data = PurchaseH::find($id);
        $data->status = 'received';
		$userinfo = Session::get('userinfo');        
		$data->user_modified = Session::get('userinfo')['user_id'];
		if($data->save()){
			Session::flash('success', 'Data modified successfully');
			Session::flash('mode', 'success');
			return new JsonResponse(["status"=>true]);
		}else{
			return new JsonResponse(["status"=>false]);
		}

		return new JsonResponse(["status"=>false]);		
    }
    
	public function datatable() {
		if (isset($_GET['status']) && $_GET['status']!=""){
			$status = $_GET['status'];
		}else{
			$status = 0;
		}
		$startDate = "01"."-".date('m-Y');
		$endDate = date('d-m-Y');
		$mode = "all";
		if (isset($_GET["startDate"]) || isset($_GET["endDate"]) || isset($_GET["mode"])){
			if ((isset($_GET['startDate'])) && ($_GET['startDate'] != "")){
				$startDate = $_GET["startDate"];
			}
			if ((isset($_GET['endDate'])) && ($_GET['endDate'] != "")){
				$endDate = $_GET["endDate"];
			}
			if (isset($_GET["mode"])){
				$mode = $_GET["mode"];
			}
        }
		$startDateQuery = date("Y-m-d", strtotime($startDate));
        $endDateQuery = date("Y-m-d", strtotime($endDate));
        if ($status == '0'){
            if ($mode == "all"){
                $data = PurchaseH::select('purchase_h.*','supplier.nama')->leftJoin('supplier', 'purchase_h.id_sup', '=', 'supplier.id')->where('purchase_h.active', '!=', 0);
            } else 
            if ($mode == "limited"){
                $data = PurchaseH::select('purchase_h.*','supplier.nama')->leftJoin('supplier', 'purchase_h.id_sup', '=', 'supplier.id')->where('purchase_h.active', '!=', 0)->whereBetween('tanggal', [$startDateQuery, $endDateQuery]);
            }
        } else 
        {
            if ($mode == "all"){
                $data = PurchaseH::select('purchase_h.*','supplier.nama')->leftJoin('supplier', 'purchase_h.id_sup', '=', 'supplier.id')->where('purchase_h.active', '!=', 0)->where('purchase_h.status', '=', $status);
            } else 
            if ($mode == "limited"){
                $data = PurchaseH::select('purchase_h.*','supplier.nama')->leftJoin('supplier', 'purchase_h.id_sup', '=', 'supplier.id')->where('purchase_h.active', '!=', 0)->where('purchase_h.status', '=', $status)->whereBetween('tanggal', [$startDateQuery, $endDateQuery]);
            }
        }
        return Datatables::of($data)
			->addColumn('action', function ($data) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				
				$url_edit = url('backend/purchase-order/'.$data->id.'/edit');
                $url = url('backend/purchase-order/'.$data->id);
                $url_terima = url('backend/purchase-order/terima/'.$data->id);
                $view = "<a class='btn-action btn btn-primary' href='".$url."' title='View'><i class='fa fa-eye'></i></a>";
                $edit = "";
                $terima = "";
                $delete = "";
                if ($data->status == "order"){
                    $edit = "<a class='btn-action btn btn-info btn-edit' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a>";
                    $terima = "<button data-url='".$url_terima."' onclick='received(this)' class='btn-action btn btn-warning' title='Terima'>Terima</button>";                    
                    $delete = "<button data-url='".$url."' onclick='deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash-o'></i></button>";
                }
				if (!empty($access_control)) {
					if ($access_control[$userinfo['user_level_id']][$segment] == "v"){
						return $view;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "vu"){
						return $view." ".$edit." ".$terima;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "a"){
						return $view." ".$edit." ".$delete." ".$terima;
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
		return view ('backend.purchase.view_barang')->with('id_count', $id_count);
	}

	public function popup_media_supplier() {
		return view ('backend.purchase.view_supplier');
	}
    
}