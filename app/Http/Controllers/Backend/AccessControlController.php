<?php

namespace App\Http\Controllers\Backend;

use Session;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\AccessControl;
use App\Model\UserLevel;
use App\Model\Module;
use Illuminate\Support\Facades\Redirect;
use View;
 
class AccessControlController extends Controller {
	public function index(Request $request) {
		$userinfo = Session::get('userinfo');
		$user_level = UserLevel::where('id', '>=', $userinfo['user_level_id'])->where('active',1)->orderBy('id','asc')->get();
		$module = Module::where('active',1)->orderBy('id','asc')->get();
		$access_control = AccessControl::orderBy('id','asc')->get();
		$role = [];
		foreach ($access_control as $data):
			$role[$data->user_level_id][$data->module_id] = $data->content;
		endforeach;
		View::share ( 'user_level', $user_level);
		View::share ( 'module', $module);
		View::share ( 'access_control', $role);
		return view ('backend.access_control');
	}
	
    public function update(Request $request)
    {
		$user_level = $request->user_level;
		$module = Module::where('active',1)->orderBy('id','asc')->get();
		foreach ($module as $data):
			$find = AccessControl::where([['user_level_id','=',$user_level],['module_id','=',$data->id]])->first();
			if ($find){
				$id = $find->id;
				$update = AccessControl::find($id);
				$update->content = $_POST["access_".$data->id];
				$update->user_modified = Session::get('userinfo')['user_id'];
				$update->save();
			} else {
				$update = new AccessControl();
				$update->user_level_id = $user_level;
				$update->module_id = $data->id;
				$update->content = $_POST["access_".$data->id];
				$update->user_modified = Session::get('userinfo')['user_id'];
				$update->save();
			}
		endforeach;
		return Redirect::to('/backend/access-control')->with('success', "Data saved successfully")->with('mode', 'success');
    }
}