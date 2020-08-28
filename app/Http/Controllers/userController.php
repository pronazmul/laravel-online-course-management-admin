<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\userResistration;

class userController extends Controller
{
	public function getAllUser(){
      $result =userResistration::orderBy('id','desc')->get();
      return $result;
    }

    public function approve(Request $req){
      $id = $req-> input('id');
      $result =userResistration::where('id',$id)->update(['approval'=>'approved']);
      return $id;
    }

    public function suspand(Request $req){
      $id = $req-> input('id');
      $result =userResistration::where('id',$id)->update(['approval'=>'suspanded']);
      return $id;
    }
}
