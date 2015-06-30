<?php namespace App\Http\Controllers;

use App\Http\Requests;


class LanguageController extends Controller {

	public function index()
	{
	    Session::set('locale', Input::get('locale'));
	    return Redirect::back();
	}

	public function choose()
	{
	    Session::set('locale', Input::get('locale'));
	    return Redirect::back();
	}


}