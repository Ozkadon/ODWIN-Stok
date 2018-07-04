<?php

namespace App\Http\Middleware;

use Cache;
use Closure;
use Session;
use Illuminate\Http\Request;

class TokenAllMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::get('userinfo')) {
            return redirect('/backend/login');
        }else{
			$userinfo = Session::get('userinfo');
			$access_control = Session::get('access_control');
			$segment =  \Request::segment(2);
			if (!empty($access_control)) {
				if ($access_control[$userinfo['user_level_id']][$segment] != "a"){
					return redirect('/backend/'.$segment);
				}
			} else {
				return redirect('/backend');
			}
        }
        return $next($request);
    }
}