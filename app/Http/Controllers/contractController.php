<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\contractModel;

class contractController extends Controller
{
 public function allContractData(){
    $result =contractModel::orderBy('id','desc')->get();
    return $result;
    }

    public function deleteContractData(Request $req){
    $id = $req-> input('id');
    return $result =contractModel::where('id',$id)->delete();
  }

}
