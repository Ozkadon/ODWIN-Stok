<?php


namespace App\Http\Controllers\Backend;

use Session;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Setting;
use Illuminate\Support\Facades\Redirect;
use Image;

class SettingController extends Controller {
	public function index(Request $request) {
		return view ('backend.setting');
	}
	
    public function update(Request $request)
    {
		$insert = Setting::find(2);
		if (empty($request->logo)){
			if (empty($request->default_logo)){
				$insert->value = '';
			}
		} else {
			$logoName = 'logo.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('img'), $logoName);
            // $img = Image::make($request->logo);
            // $img->resize(200, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // });            
            // $img->save('img/logo.'.$request->logo->getClientOriginalExtension());
			$insert->value = 'img/logo.'.$request->logo->getClientOriginalExtension();
        }
        $insert->save();

        $data = Setting::orderBy('id', 'DESC')->first();
		for ($i=1;$i<=$data['id'];$i++){
			if (isset($_POST[$i])){
				$insert = Setting::find($i);
				$insert->value = $_POST[$i];
				$insert->user_modified = Session::get('userinfo')['user_id'];
				$insert->save();
			}
		}
		return Redirect::to('/backend/setting')->with('success', "Data saved successfully")->with('mode', 'success');
    }
	
}