<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\visitorModel;
use App\contractModel;
use App\userResistration;

class mainController extends Controller
{
  
  public function __invoke(){

    $TotalVisitor = visitorModel::count();
    $TotalContract = contractModel::count();
    $TotalUser = userResistration::count();

  	return view('home',[
      'TotalVisitor'=>$TotalVisitor,
      'TotalUser'=>$TotalUser,
      'TotalContract'=>$TotalContract
    ]);
  }

  public function visitor(){
  	$visitorData = json_decode(visitorModel::orderBy('id','desc')->get());
  	return view('visitor',['visitorData' => $visitorData]);
  }

    public function user(){
  	return view('user');
  }
      public function message(){
    return view('message');
  }

}
