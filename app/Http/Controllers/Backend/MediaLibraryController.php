<?php
namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Helpers\UploadHandler;
use App\Model\MediaLibrary;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Datatables;


class MediaLibraryController extends Controller {
	public function index(Request $request) {
		return view ('backend.medialibrary.index');
	}
	
	public function popup_media($from = null, $id_count = null) {
		return view ('backend.medialibrary.view')->with('from', $from)->with('id_count', $id_count);
	}

	public function popup_media_gallery() {
		return view ('backend.medialibrary.view_gallery');
	}

	public function popup_media_editor($id_count = null) {
		return view ('backend.medialibrary.view_editor')->with('id_count', $id_count);
	}
    
	public function upload(Request $request) {
		$userinfo = Session::get('userinfo');
		$upload_handler = new UploadHandler;
		$info = $upload_handler->post();
		if(isset($info[0]->name) && (!isset($info[0]->error)))
		{
			$data = new MediaLibrary();
			$name = substr($info[0]->name, 0 , strripos($info[0]->name, '.'));
			$path_parts = pathinfo($info[0]->name);
			$name = $path_parts['filename'];
			$type = $path_parts['extension'];
			$data->name = $name;
			$data->type = $type;
			$data->url = "upload/img/".$name.".".$type;
			$data->size = $info[0]->size;
			$data->user_created = $userinfo['user_id'];
			$data->save();
		}
	}

	public function destroy(Request $request, $id){
		$count = getMediaCount($id);
		if ($count > 0){
			Session::flash('success', 'This image is currently associated with the following database(s)');
			Session::flash('mode', 'danger');
			return new JsonResponse(["status"=>true]);
		} else {
			$data = MediaLibrary::find($id);
			if ($data->delete()){
                if(file_exists('upload/img/'.$data->name.'.'.$data->type)){
                    unlink('upload/img/'.$data->name.'.'.$data->type);
                }
                if(file_exists('upload/img/thumbnails/'.$data->name.'.'.$data->type)){
                    unlink('upload/img/thumbnails/'.$data->name.'.'.$data->type);
                }
			}
			Session::flash('success', 'Data deleted successfully');
			Session::flash('mode', 'success');
			return new JsonResponse(["status"=>true]);
		}		
    }
    
    public function deleteAll(Request $request)
    {
		if (!(empty($_POST['checkall'])))
		{
            $check = false;
			foreach($_POST['checkall'] as $item)
			{ 
                $count = getMediaCount($item);
                if ($count > 0){
                    $check = true;
                    
                } else {
                    $data = MediaLibrary::find($item);
                    if ($data->delete()){
                        if(file_exists('upload/img/'.$data->name.'.'.$data->type)){
                            unlink('upload/img/'.$data->name.'.'.$data->type);
                        }
                        if(file_exists('upload/img/thumbnails/'.$data->name.'.'.$data->type)){
                            unlink('upload/img/thumbnails/'.$data->name.'.'.$data->type);
                        }
                    }
                }		
            }
            $text = "Data(s) deleted successfully";
            if ($check){
                $text = "There is image(s) currently associated with the following database(s)";
            }
            return Redirect::to('/backend/media-library/')->with('success', $text)->with('mode', 'success');
		} else {
            return Redirect::to('/backend/media-library/');
        }
    }
	
	public function datatable() {
		$medialibrary = MediaLibrary::where('id','>',0);
	
        return Datatables::of($medialibrary)
            ->addColumn('checkbox', function ($medialibrary) {
                return "                
                <input type='hidden' class='media-id' value='".$medialibrary->id."'>
                <span class='uni'>
                    <input class='checkbox_gallery_item' type='checkbox' value='".$medialibrary->id."' name='checkall[]' />
                </span>
                ";
            })        
			->addColumn('action', function ($medialibrary) {
				$userinfo = Session::get('userinfo');
				$access_control = Session::get('access_control');
				$segment =  \Request::segment(2);
				$url = url('backend/media-library/'.$medialibrary->id);

				if (!empty($access_control)) {
					if ($access_control[$userinfo['user_level_id']][$segment] == "a"){
						return "<button data-url='".$url."' onclick='return deleteData(this)' class='btn btn-danger'><i class='fa fa-trash-o'></i></button>";
					}
				} else {
					return "";
				}
            })
            ->rawColumns(['checkbox', 'action'])
            ->make(true);		
	}	
}