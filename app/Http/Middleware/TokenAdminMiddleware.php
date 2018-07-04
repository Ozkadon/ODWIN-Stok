<?php

namespace App\Http\Middleware;

use Cache;
use Closure;
use Session;
use App\Model\User;

class TokenAdminMiddleware
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
			//Jika bukan admin
        	if($userinfo['user_level_id'] == 3){
                return redirect('/');
            }
        }
        return $next($request);
    }
}