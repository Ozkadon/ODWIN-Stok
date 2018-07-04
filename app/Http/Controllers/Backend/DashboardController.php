<?php


namespace App\Http\Controllers\Backend;

use Session;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
 
class DashboardController extends Controller {
	public function dashboard(Request $request) {
		
		return view ('backend.dashboard');
	}
}