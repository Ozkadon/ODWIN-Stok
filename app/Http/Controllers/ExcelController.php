<?php 
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Model\User;
use Excel;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller {

	public function export_user($type)
	{
		$data = User::select(DB::raw('CONCAT(firstname," ",lastname) AS nama'),'email','gender','address','phone','birthdate')
		->orderBy('id', 'ASC')->get()->toArray();
		return Excel::create('export_user', function($excel) use ($data) {
			$excel->sheet('List User', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}


}