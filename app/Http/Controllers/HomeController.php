<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function __construct()
	{
		$this->middleware('check-login');
	}

	public function index()
	{
		return redirect(route('user'));
	}


}
