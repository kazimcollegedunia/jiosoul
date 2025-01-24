<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User extends Controller
{
 
	public static userDetails(){
		User::get();
	}

}
