<?php
namespace App\Http\Controllers\Uber\Admin;
use App\Http\Controllers\Controller;
use Lang;

class PageController extends Controller {
	
	public function index(){
		return view('uber.admin.login');
	}
}
