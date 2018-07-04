<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\PurchaseH;
use App\Model\PenjualanH;
use App\Model\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_purchase()
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
		if (isset($_GET['status']) && $_GET['status']!=""){
			$status = $_GET['status'];
		}else{
			$status = 0;
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
        $data = $data->get();

		view()->share('startDate',$startDate);
		view()->share('endDate',$endDate);
		view()->share('status',$status);
        view()->share('mode',$mode);
		return view ('backend.laporan.purchase',['data'=>$data]);
    }

    public function index_penjualan()
    {
        //
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
			if (!isset($_GET["mode"])){
				$mode = "limited";
			}
        }
		if (isset($_GET['status']) && $_GET['status']!=""){
			$status = $_GET['status'];
		}else{
			$status = 0;
        }
        
		$startDateQuery = date("Y-m-d", strtotime($startDate));
        $endDateQuery = date("Y-m-d", strtotime($endDate));
        if ($mode == "all"){
            $data = PenjualanH::where('penjualan_h.active', '!=', 0);
        } else 
        if ($mode == "limited"){
            $data = PenjualanH::where('penjualan_h.active', '!=', 0)->whereBetween('tanggal', [$startDateQuery, $endDateQuery]);
        }
        $data = $data->get();

		view()->share('startDate',$startDate);
		view()->share('endDate',$endDate);
        view()->share('mode',$mode);
		return view ('backend.laporan.penjualan',['data'=>$data]);
    }

    public function index_stok()
    {
        //
        $data = Barang::where('active', '!=', 0)->get();
        return view ('backend.laporan.stok',['data'=>$data]);
    }

    
}