<?php
namespace App\Http\Controllers\Backend;

use Session;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Validator\UserValidator;
use DB;
use App\Model\User;
use App\Model\Token;

 
class LoginController extends Controller {
	private function login(Request $request)
	{
		$data = [
			'request' => $request->all(),
			'response' => [
				'message' => 'An error occured',
				'error' => [],
			],
			'status' => false,
		];

		$validator = UserValidator::login($request->all());

		if( ! $validator['status']) {
			$data['response']['message'] = 'Validation error.';
			$data['response']['error'] = $validator['error'];
			return $data;
		} 

		if( ! empty($request->input('email'))) {
			$user = User::where('email', $request->input('email'))->first();
		} elseif( ! empty($request->input('username'))) {
			$user = User::where('username', $request->input('username'))->first();
		} else {
            $data['response']['message'] = 'Validation error.';
            $data['response']['error'] = array(['Username / Password not found']);
			return $data;
		}

		// Check password
		if( ! Hash::check($request->input('password'), $user->password)) {
			$data['response']['message'] = 'Username / Password not found.';
			$data['response']['error'] = array(['Username / Password not found']);
			return $data;    	
		} else {
			$last_activity = User::find($user->id);
			$last_activity->last_activity = date('Y-m-d H:i:s');
			$last_activity->save();
			
			$infos = User::with('level', 'avatar')->where(['id' => $user->id])->first();

			if(isset($infos)) {
                $info['user_id'] = $infos->id;
                $info['user_level_id'] = $infos->user_level_id;
                $info['firstname'] = $infos->firstname;
                $info['lastname'] = $infos->lastname;
                $info['email'] = $infos->email;
                $info['phone'] = $infos->phone;
                $info['gender'] = $infos->gender;
                $info['birthdate'] = $infos->birthdate;
                $info['address'] = $infos->alamat;
                $info['active'] = $infos->active;
                $info['created_at'] = $infos->created_at->toDateTimeString();            
                $info['updated_at'] = $infos->updated_at->toDateTimeString();            
                $info['level'] = $infos->level->name;
                $info['username'] = $infos->username;          
                $info['avatar'] = $infos->avatar->url;          
                $info['last_activity'] = $infos->last_activity;     

				$data['status'] = true;
				$data['response']['data']['userinfo'] = $info;            
				$data['response']['message'] = 'Login success.';
			} else {
				$data['response']['message'] = 'No result.';
				$data['response']['data'] = $infos;   
				return $data;      
			}
		}
		return $data;
	}
	
	public function index(Request $request) {
		if($request->isMethod('GET')){
			if(Session::get('userinfo') == ""){
	            return view ('backend.login');
	        }
	        else{
	            return redirect('/backend/dashboard');
	        }
		}
	
		if($request->isMethod('POST')){
			$response = $this->login( $request );
			if ($response['status']) {
				Session::put ('userinfo',$response['response']['data']['userinfo'] );
				$return = array(
					'status' => true,
					'message' => "Login Success"
				);
				return new JsonResponse($return,200);
			}else{
				$return = array(
					'status' => false,
					'message' => $response['response']['error']
				);
				return new JsonResponse($return, 200);
			}
		}
		return view ('backend.login');
	}

	public function logout(Request $request) {
		$request->session()->flush();
        return redirect('/backend/login');
	}	

}