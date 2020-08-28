<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\adminLoginModel;
class loginController extends Controller
{
	public function __invoke(){

		return view('login');
	}

	public function adminLogin(Request $req){

		$username = $req-> input('username');
		$password = $req-> input('password');


		$result = adminLoginModel::where(['username'=> $username,'password'=> $password])->count();

		if ($result==true){

			$req->session()->put('user',$username);

			return 1;
		}else{
			return 0;
		}
	}

	public function logOut(Request $req){
		$req -> session()->flush();
		return redirect('/login');
	}
}
