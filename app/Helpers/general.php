<?php

use Illuminate\Support\Facades\Cache;
use App\Model\User;
use App\Model\Barang;
use App\Model\AccessControl;
use App\Model\Setting;

function getData($column){
    $setting = Setting::where('name',$column)->get();
    return $setting[0]->value;
}

function getUserAccess($id){
	$access_control = AccessControl::with('module')->where('user_level_id', $id)->get();
	$role = [];
	foreach ($access_control as $data):
		$role[$data->user_level_id][$data->module->slug] = $data->content;
	endforeach;
	return $role;
}

function getMediaCount($id){
	$total = 0;
    $count_user = User::where('avatar_id',$id)->where('active', '!=', 0)->count();
    $count_barang = Barang::where('img_id',$id)->where('active', '!=', 0)->count();
	$total = $count_user + $count_barang; 
	return $total;
}