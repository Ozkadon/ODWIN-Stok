<?php 

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\User;
use App\Model\UserLevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Datatables;
use Validator;

class UserController extends Controller {
    public function index(Request $request) {
		return view ('backend.user.index');
	}

	public function create(){
	    $userinfo = Session::get('userinfo');		
	    $userlevel = UserLevel::where('id', '>=', $userinfo['user_level_id'])->where('active', '=', 1)->pluck('name','id');
	    return view('backend.user.update', ['userlevel' => $userlevel]);
	}
	
    public function show($id)
    {
        //
		$data = User::with(['user_modify', 'media_image_1', 'level'])->where('id', $id)->get();
		$userinfo = Session::get('userinfo');
		if ($data->count() > 0){
			if($userinfo['user_level_id'] > $data[0]->user_level_id){
				return redirect('/backend');
			}
			return view ('backend.user.view', ['data' => $data]);
		}
    }

	public function edit($id){
	    $userinfo = Session::get('userinfo');		
	    $userlevel = UserLevel::where('id', '>=', $userinfo['user_level_id'])->where('active', '=', 1)->pluck('name','id');
		$data = User::with('media_image_1')->where('users.id', $id)->where('users.active', '!=', 0)->get();
		$userinfo = Session::get('userinfo');
		if ($data->count() > 0){
			if($userinfo['user_level_id'] > $data[0]->user_level_id){
				return redirect('/backend');
			}
			return view('backend.user.update', ['userlevel' => $userlevel, 'data' => $data]);
		}
	}

	public function store(Request $request){
		$validator = Validator::make($request->all(),[]);
		
		$username = $request->username;
		$email = $request->email;
		$firstname = $request->firstname;
		$lastname = $request->lastname;
		$user_level_id = $request->user_level_id;

		$cekusername = User::where('username',$username)->get()->count();
		$cekemail = User::where('email',$email)->get()->count();

		if($cekusername > 0){
			$validator->getMessageBag()->add('username', '*) Duplicate Username');
		}else if ($cekemail >0){
			$validator->getMessageBag()->add('email', '*) Duplicate Email');
		}else{
			$user = new User();
			$user->username = $username;
			$user->email = $email;
			$user->password = Hash::make('123456');
			$user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->birthdate = date('Y-m-d',strtotime($request->birthdate));
            $user->user_level_id = $user_level_id;
            $user->address = $request->address;
			$user->active = 1;
			$user->avatar_id = $request->avatar_id;
			$user->user_modified = Session::get('userinfo')['user_id'];
			
			if($user->save()){
				return Redirect::to('/backend/users-user/')->with('success', "Data saved successfully")->with('mode', 'success');
			}
		}
		return Redirect::to('/backend/users-user/create')
				->withErrors($validator)
				->withInput();
	}

	public function destroy(Request $request,$id) {
		$data = User::find($id);
		$userinfo = Session::get('userinfo');
		if($userinfo['user_level_id'] <= $data->user_level_id){
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
		return new JsonResponse(["status"=>false]);		
	}

	public function update(Request $request,$id){
		$data = User::where('id', $id)->where('active', '!=', 0)->get();
		$userinfo = Session::get('userinfo');
		if($userinfo['user_level_id'] > $data[0]->user_level_id){
			return redirect('/backend');
		}
		
		$validator = Validator::make($request->all(),[]);
		
		$username = $request->username;
		$email = $request->email;
		$firstname = $request->firstname;
		$lastname = $request->lastname;
		$user_level_id = $request->user_level_id;

	    $cekusername = User::where('users.id','<>',$id)->where('username',$username)->get()->count();
	    $cekemail = User::where('users.id','<>',$id)->where('email',$email)->get()->count();

		if($cekusername > 0){
			$validator->getMessageBag()->add('username', '*) Duplicate Username');
		}else if ($cekemail >0){
			$validator->getMessageBag()->add('email', '*) Duplicate Email');
		}else{
			$user = User::find($id);
			$user->username = $username;
			$user->email = $email;
			if ($request->password_check == 1){
				$user->password = Hash::make($request->password);
			}
			$user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->birthdate = date('Y-m-d',strtotime($request->birthdate));
            $user->user_level_id = $user_level_id;
            $user->address = $request->address;
			$user->active = $request->active;
			$user->avatar_id = $request->avatar_id;
			$user->user_modified = Session::get('userinfo')['user_id'];
			
			if($user->save()){
				return Redirect::to('/backend/users-user/')->with('success', "Data saved successfully")->with('mode', 'success');
			}
		}
		return Redirect::to('/backend/users-user/'.$id."/edit")
				->withErrors($validator)
				->withInput();		
	}

    public function deleteAll(Request $request)
    {
		if (!(empty($_POST['checkall'])))
		{
			foreach($_POST['checkall'] as $item)
			{ 
                $data = User::find($item);
                $data->user_modified = Session::get('userinfo')['user_id'];
                $data->active = 0;
                $data->save();
            } 
            return Redirect::to('/backend/users-user/')->with('success', "Data(s) deleted successfully")->with('mode', 'success');
		} else {
            return Redirect::to('/backend/users-user/');
        }
    }

	public function datatable() {
		$userinfo = Session::get('userinfo');
		$user = User::select('users.*','user_levels.name')
		 ->join('user_levels','user_levels.id','=','users.user_level_id')
		 ->where('user_level_id', '>=', $userinfo['user_level_id'])
		 ->where('users.active', '!=', 0);
	
        return Datatables::of($user)
			->editColumn('firstname', function ($user) {
				return $user->firstname." ".$user->lastname;
			})
			->addColumn('action', function ($user) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				
				$url_edit = url('backend/users-user/'.$user->id.'/edit');
				$url = url('backend/users-user/'.$user->id);
				$view = "<a class='btn-action btn btn-primary btn-view' href='".$url."' title='View'><i class='fa fa-eye'></i></a>";
				$edit = "<a class='btn-action btn btn-info btn-edit' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a>";
				$delete = "<button data-url='".$url."' onclick='return deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash-o'></i></button>";
				if (!empty($access_control)) {
					if ($access_control[$userinfo['user_level_id']][$segment] == "v"){
						return $view;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "vu"){
						return $view." ".$edit;
					} else if ($access_control[$userinfo['user_level_id']][$segment] == "a"){
						return $view." ".$edit." ".$delete;
					}
				} else {
					return "";
				}
            })			
            ->addColumn('check', function ($data) {
                return "
                    <span class='uni'>
                        <input type='checkbox' value='".$data->id."' name='checkall[]' />
                    </span>
                ";
            })
            ->rawColumns(['action', 'check'])
            ->make(true);		
	}
}