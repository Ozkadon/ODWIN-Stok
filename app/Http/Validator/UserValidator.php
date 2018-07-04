<?php

namespace App\Http\Validator;

use Request;
use Validator;
use App\Model\User;

class UserValidator
{
	public static function login($request)
	{
		$data = [
			'status' => false,
			'error' => [],
			'data' => []
		];	
		
    	$validator = Validator::make($request, [
    		'email' => 'required_without:username|email|exists:users,email',
            'password' => 'required|alpha_dash',
            'username' => 'exists:users,username|required_without:email|between:4,50'
    	]);

    	if($validator->fails()) {
    		$data['error'] = $validator->errors()->toArray();
    		return $data;
    	} else {
    		$data['status'] = true;
    		return $data;
    	}    			
    }
    

}